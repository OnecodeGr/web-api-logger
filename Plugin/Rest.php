<?php
/**
 * Rest
 *
 * @copyright Copyright © 2022 Onecode  All rights reserved.
 * @author    support@onecde.gr
 *
 */

namespace Onecode\WebApiLogger\Plugin;

use Exception;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Webapi\Controller\Rest as PluggedInClass;
use Onecode\WebApiLogger\Helper\Data as Helper;

/**
 * Class Rest
 * @package Onecode\WebApiLogger\Plugin
 */
class Rest extends AbstractPlugin
{
    /**
     * @param PluggedInClass   $subject
     * @param RequestInterface $request
     *
     * @throws Exception
     */
    public function beforeDispatch(PluggedInClass $subject, RequestInterface $request): void
    {
        if ($this->_dataHelper->getApiConfig(Helper::CONFIG_ACTIVE)
                && $this->_dataHelper->getApiConfig(Helper::CONFIG_LOG_REST)
            && $this->isApiMethodAccepted()
            && $this->canTrackUser()
        ) {
            $this->_apiLogger
                ->setApiType('REST')
                ->setRequestData($this->convertContent((string) $this->_httpRequest->getContent()))
                ->setMethodRequest($this->_httpRequest->getMethod())
                ->setUrlRequest(urldecode($this->_httpRequest->getPathInfo()))
                ->setApiUser($this->getIntegratedUser());

            $this->apiLoggerRepository->save($this->_apiLogger);
        }
    }

    /**
     * @param PluggedInClass    $subject
     * @param ResponseInterface $result
     * @param RequestInterface  $request
     *
     * @return ResponseInterface
     * @throws Exception
     */
    public function afterDispatch(
        PluggedInClass    $subject,
        ResponseInterface $result,
        RequestInterface  $request
    ): ResponseInterface {
        if ($this->_dataHelper->getApiConfig(Helper::CONFIG_ACTIVE)
            && $this->_dataHelper->getApiConfig(Helper::CONFIG_LOG_REST)
            && $this->_apiLogger->getId()
            && $result->getContent()
        ) {
            $this->_apiLogger->setResponseData(
                $this->convertContent((string) $result->getContent())
            );
            $this->apiLoggerRepository->save($this->_apiLogger);
        }

        return $result;
    }
}
