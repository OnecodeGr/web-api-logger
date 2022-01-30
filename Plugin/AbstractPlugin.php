<?php
/**
 * AbstractPlugin
 *
 * @copyright Copyright © 2022 Onecode  All rights reserved.
 * @author    spyros@onecode.gr
 */

namespace Onecode\WebApiLogger\Plugin;

use Magento\Framework\App\Request\Http;
use Magento\Integration\Model\IntegrationFactory;
use Onecode\WebApiLogger\Helper\Data;
use Onecode\WebApiLogger\Model\ApiLogger;
use Magento\Integration\Model\Oauth\TokenFactory;

/**
 * Class AbstractPlugin
 * @package Onecode\WebApiLogger\Plugin
 */
class AbstractPlugin
{
    /**
     * @var Data
     */
    protected $_dataHelper;

    /**
     * @var ApiLogger
     */
    protected $_apiLogger;

    /**
     * @var Http
     */
    protected $_httpRequest;

    /**
     * @var TokenFactory
     */
    private $_tokenFactory;

    /**
     * @var IntegrationFactory
     */
    private $_integrationFactory;

    /**
     * AbstractPlugin constructor.
     *
     * @param Data $data
     * @param ApiLogger $apiLogger
     * @param Http $httpRequest
     * @param TokenFactory $tokenFactory
     * @param IntegrationFactory $integrationFactory
     */
    public function __construct(
        Data               $data,
        ApiLogger          $apiLogger,
        Http               $httpRequest,
        TokenFactory       $tokenFactory,
        IntegrationFactory $integrationFactory
    )
    {
        $this->_dataHelper = $data;
        $this->_apiLogger = $apiLogger;
        $this->_httpRequest = $httpRequest;
        $this->_tokenFactory = $tokenFactory;
        $this->_integrationFactory = $integrationFactory;
    }


    /**
     * @param $content
     *
     * @return string
     */
    protected function convertContent($content)
    {
        switch ($this->_httpRequest->getHeader("Content-Type")) {
            case "application/json":
                return json_encode(json_decode($content, true), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            case "application/xml":
            case "text/xml":
            case "text/html":
            case "application/javascript":
            case "text/plain":
            default:
                return $content;
        }

    }

    /**
     * @return bool
     */
    protected function isApiMethodAccepted()
    {
        if ($this->_dataHelper->getApiConfig(Data::CONFIG_ACCEPT_ALL_HTTP_METHODS)) {
            return true;
        }
        $selected = $this->_dataHelper->getApiConfig(Data::CONFIG_SELECTED_HTTP_METHODS);

        return isset($selected[strtoupper($this->_httpRequest->getMethod())]);
    }

    protected function canTrackUser()
    {
        $users = explode(",",$this->_dataHelper->getApiConfig(Data::CONFIG_SELECTED_USER_TO_TRACK));
        return in_array($this->getIntegratedUser(), $users);
    }


    /**
     * @return string
     */
    protected function getIntegratedUser()
    {
        if ($accessToken = $this->getAccessToken()) {
            $token = $this->_tokenFactory->create()->loadByToken($accessToken);
            if ($consumerId = $token->getConsumerId()) {
                $integration = $this->_integrationFactory->create()->loadByConsumerId($consumerId);

                return $integration->getName();
            }
        }

        return "anonymous";

    }


    /**
     * @return mixed|null
     */
    private function getAccessToken()
    {
        $accessToken = $this->_httpRequest->getParam("oauth_token", false);
        if (!$accessToken) {
            $accessToken = $this->getHeaderToken();
        }

        return $accessToken;


    }

    /**
     * get access token from header
     * */
    private function getHeaderToken()
    {
        $headers = $this->getAuthorizationHeader();
        // HEADER: Get the access token from the header
        if (!empty($headers)) {
            if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
                return $matches[1];
            } elseif (preg_match('/OAuth\s(\S+)/', $headers, $matches)) {
                foreach (explode(",", $matches[1]) as $value) {
                    list($key, $data) = explode("=", $value);
                    if ($key == "oauth_token") {
                        return str_ireplace(["\"", "'"], "", $data);
                    }
                }
            }
        }

        return null;
    }

    /**
     * @return string|null
     */
    private function getAuthorizationHeader()
    {
        $headers = null;
        if (isset($_SERVER['Authorization'])) {
            $headers = trim($_SERVER["Authorization"]);
        } elseif (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
        } elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
            $requestHeaders =
                array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
            //print_r($requestHeaders);
            if (isset($requestHeaders['Authorization'])) {
                $headers = trim($requestHeaders['Authorization']);
            }
        }

        return $headers;
    }


}
