<?php
/**
 * AbstractPlugin
 *
 * @copyright Copyright © 2022 Onecode  All rights reserved.
 * @author    support@onecde.gr
 *
 */

namespace Onecode\WebApiLogger\Plugin;

use Magento\Framework\App\Request\Http;
use Magento\Integration\Model\IntegrationFactory;
use Magento\Integration\Model\Oauth\Token;
use Magento\Integration\Model\Oauth\TokenFactory;
use Onecode\WebApiLogger\Api\ApiLoggerRepositoryInterface;
use Onecode\WebApiLogger\Helper\Data;
use Onecode\WebApiLogger\Model\ApiLogger;

/**
 * Class AbstractPlugin
 * @package Onecode\WebApiLogger\Plugin
 */
class AbstractPlugin
{
    /**
     * Fields whose values must be replaced with [REDACTED] before storage.
     * Add any sensitive field names your API uses.
     */
    private const SENSITIVE_FIELDS = [
        'password', 'current_password', 'new_password', 'confirm_password',
        'token', 'access_token', 'refresh_token', 'api_key', 'secret',
        'credit_card', 'card_number', 'cvv', 'cc_number', 'cc_cid',
        'authorization', 'x-api-key',
    ];

    private const MAX_BODY_SIZE_BYTES = 65536; // 64 KB

    /** @var Data */
    protected $_dataHelper;

    /** @var ApiLogger */
    protected $_apiLogger;

    /** @var Http */
    protected $_httpRequest;

    /** @var TokenFactory */
    private $_tokenFactory;

    /** @var IntegrationFactory */
    private $_integrationFactory;

    /** @var ApiLoggerRepositoryInterface */
    protected $apiLoggerRepository;

    public function __construct(
        Data                         $data,
        ApiLogger                    $apiLogger,
        Http                         $httpRequest,
        TokenFactory                 $tokenFactory,
        IntegrationFactory           $integrationFactory,
        ApiLoggerRepositoryInterface $apiLoggerRepository
    ) {
        $this->_dataHelper         = $data;
        $this->_apiLogger          = $apiLogger;
        $this->_httpRequest        = $httpRequest;
        $this->_tokenFactory       = $tokenFactory;
        $this->_integrationFactory = $integrationFactory;
        $this->apiLoggerRepository = $apiLoggerRepository;
    }

    /**
     * Convert request/response body to a readable format,
     * then mask sensitive fields and truncate if too large.
     *
     * @param string $content
     * @return string
     */
    protected function convertContent(string $content): string
    {
        if (strlen($content) > self::MAX_BODY_SIZE_BYTES) {
            $content = substr($content, 0, self::MAX_BODY_SIZE_BYTES)
                . PHP_EOL."[... TRUNCATED: body exceeded " . self::MAX_BODY_SIZE_BYTES . " bytes ...]";
        }

        $contentType = $this->_httpRequest->getHeader('Content-Type') ?? '';

        if (str_contains($contentType, 'application/json')) {
            $decoded = json_decode($content, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $decoded = $this->maskSensitiveData($decoded);
                return (string) json_encode($decoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            }
        }
        return $this->maskSensitivePatterns($content);
    }

    /**
     *
     * @param array $data
     * @return array
     */
    private function maskSensitiveData(array $data): array
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $data[$key] = $this->maskSensitiveData($value);
            } elseif (in_array(strtolower((string) $key), self::SENSITIVE_FIELDS, true)) {
                $data[$key] = '[REDACTED]';
            }
        }
        return $data;
    }

    /**
     * @param string $content
     * @return string
     */
    private function maskSensitivePatterns(string $content): string
    {
        foreach (self::SENSITIVE_FIELDS as $field) {
            // Covers: password=value, <password>value</password>, "password":"value"
            $content = preg_replace(
                '/(' . preg_quote($field, '/') . '["\s]*[=:>]+["\s]*)([^<&"\s,}]+)/i',
                '$1[REDACTED]',
                $content
            );
        }
        return $content;
    }

    /**
     * @return bool
     */
    protected function isApiMethodAccepted(): bool
    {
        if ($this->_dataHelper->getApiConfig(Data::CONFIG_ACCEPT_ALL_HTTP_METHODS)) {
            return true;
        }
        $selected      = (string) $this->_dataHelper->getApiConfig(Data::CONFIG_SELECTED_HTTP_METHODS);
        $requestMethod = strtoupper($this->_httpRequest->getMethod());
        return in_array($requestMethod, explode(',', $selected), true);
    }

    /**
     * @return bool
     */
    protected function canTrackUser(): bool
    {
        $configured = (string) $this->_dataHelper->getApiConfig(Data::CONFIG_SELECTED_USER_TO_TRACK);
        $users      = array_filter(array_map('trim', explode(',', $configured)));

        // Empty list means "track all users"
        if (empty($users)) {
            return true;
        }

        return in_array($this->getIntegratedUser(), $users, true);
    }

    /**
     *
     * @return string
     */
    protected function getIntegratedUser(): string
    {
        $accessToken = $this->getAccessToken();
        if (!$accessToken) {
            return 'anonymous';
        }

        /** @var Token $token */
        $token = $this->_tokenFactory->create()->loadByToken($accessToken);

        if (!$token->getId()) {
            return 'anonymous';
        }

        // OAuth integration token
        if ($consumerId = $token->getConsumerId()) {
            $integration = $this->_integrationFactory->create()->loadByConsumerId($consumerId);
            return $integration->getName() ?: 'integration_unknown';
        }

        $tokenType = $token->getCustomerToken() ? 'customer' : 'admin';
        $userId    = $token->getCustomerId() ?: $token->getAdminId();
        if ($userId) {
            return $tokenType . ':' . $userId;
        }

        return 'anonymous';
    }

    /**
     * @return string|null
     */
    private function getAccessToken(): ?string
    {
        // Try query string (OAuth 1.0)
        $accessToken = $this->_httpRequest->getParam('oauth_token', null);
        if ($accessToken) {
            return (string) $accessToken;
        }

        return $this->getHeaderToken();
    }

    /**
     *
     * @return string|null
     */
    private function getHeaderToken(): ?string
    {

        $authHeader = $this->_httpRequest->getHeader('Authorization');

        if (empty($authHeader)) {
            return null;
        }

        // Bearer token (customer/admin JWT)
        if (preg_match('/Bearer\s(\S+)/i', $authHeader, $matches)) {
            return $matches[1];
        }

        // OAuth 1.0 header
        if (preg_match('/OAuth\s(\S+)/i', $authHeader, $matches)) {
            foreach (explode(',', $matches[1]) as $part) {
                $part = trim($part);
                if (strpos($part, '=') === false) {
                    continue;
                }
                [$key, $value] = explode('=', $part, 2);
                if (trim($key) === 'oauth_token') {
                    return trim($value, " \"'\t");
                }
            }
        }

        return null;
    }
}
