<?php

namespace Onecode\WebApiLogger\Plugin;

use Exception;
use Magento\Framework\App\FrontControllerInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\Response\Http as HttpResponse;
use Magento\Framework\App\ResponseInterface;
use Magento\GraphQl\Controller\GraphQl as PluggedInClass;

class GraphQl extends AbstractPlugin
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
            $this->_apiLogger->setApiType("GRAPHQL")
                ->setRequestData($this->convertContent(str_replace(["\\n"], "", $this->_httpRequest->getContent())))
                ->setMethodRequest($this->_httpRequest->getMethod())
                ->setUrlRequest(urldecode($this->_httpRequest->getPathInfo()))
                ->setApiUser($this->getIntegratedUser());
            $this->apiLoggerRepository->save($this->_apiLogger);
        }
    }

    /**
     * @param PluggedInClass $subject
     * @param ResponseInterface $result
     * @param RequestInterface $request
     * @return ResponseInterface
     * @throws Exception
     */
    public function afterDispatch(PluggedInClass $subject, ResponseInterface $result, RequestInterface $request): ResponseInterface
    {
        if ($this->_dataHelper->getApiConfig("active") && $this->_apiLogger->getId() && $result->getContent()) {
            $this->_apiLogger
                ->setResponseData($this->convertContent($result->getContent()));
            $this->apiLoggerRepository->save($this->_apiLogger);
        }
        return $result;
    }
}
