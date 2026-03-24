<?php
/**
 * Soap
 *
 * @copyright Copyright © 2022 Onecode  All rights reserved.
 * @author    support@onecde.gr
 *
 */

namespace Onecode\WebApiLogger\Plugin;

use Exception;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Webapi\Controller\Soap as PluggedInClass;
use Onecode\WebApiLogger\Helper\Data as Helper;

class Soap extends AbstractPlugin
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
            && $this->_dataHelper->getApiConfig(Helper::CONFIG_LOG_SOAP)
            && $this->isApiMethodAccepted()
            && $this->canTrackUser()
        ) {
            $this->_apiLogger
                ->setApiType('SOAP')
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
     */
    public function afterDispatch(
        PluggedInClass    $subject,
        ResponseInterface $result,
        RequestInterface  $request
    ): ResponseInterface {
        if ($this->_dataHelper->getApiConfig(Helper::CONFIG_ACTIVE)
            && $this->_dataHelper->getApiConfig(Helper::CONFIG_LOG_SOAP)
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
