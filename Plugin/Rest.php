<?php
/**
 * Rest
 *
 * @copyright Copyright © 2022 Onecode  All rights reserved.
 * @author    spyros@onecode.gr
 */

namespace Onecode\WebApiLogger\Plugin;

use Exception;
use Magento\Framework\App\FrontControllerInterface;
use Magento\Framework\App\Response\Http as HttpResponse;
use Magento\Framework\App\ResponseInterface;
use Magento\Webapi\Controller\Rest as PluggedInClass;
use Magento\Framework\App\RequestInterface;

/**
 * Class Rest
 * @package Onecode\WebApiLogger\Plugin
 */
class Rest extends AbstractPlugin
{

    /**
     * @param PluggedInClass $subject
     * @param RequestInterface $request
     *
     * @throws Exception
     */
    public function beforeDispatch(PluggedInClass $subject, RequestInterface $request)
    {
        if ($this->_dataHelper->getApiConfig("active") && $this->isApiMethodAccepted() && $this->canTrackUser()) {
            $this->_apiLogger->setApiType("REST")
                ->setRequestData($this->convertContent($this->_httpRequest->getContent()))
                ->setMethodRequest($this->_httpRequest->getMethod())
                ->setUrlRequest(urldecode($this->_httpRequest->getPathInfo()))
                ->setApiUser($this->getIntegratedUser());
            $this->apiLoggerRepository->save($this->_apiLogger);

        }
    }

    public function afterDispatch(PluggedInClass $subject, ResponseInterface $result, RequestInterface $request)
    {
        if ($this->_dataHelper->getApiConfig("active") && $this->_apiLogger->getId() && $result->getContent()) {
            $this->_apiLogger
                ->setResponseData($this->convertContent($result->getContent()));
            $this->apiLoggerRepository->save($this->_apiLogger);
        }

        return $result;
    }

}
