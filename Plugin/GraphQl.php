<?php
/**
 * GraphQl
 *
 * @copyright Copyright © 2022 Onecode  All rights reserved.
 * @author    support@onecde.gr
 *
 */

namespace Onecode\WebApiLogger\Plugin;

use Exception;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\App\RequestInterface;
use Magento\GraphQl\Controller\GraphQl as PluggedInClass;
use Onecode\WebApiLogger\Helper\Data as Helper;

class GraphQl extends AbstractPlugin
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
            && $this->_dataHelper->getApiConfig(Helper::CONFIG_LOG_GRAPHQL)
            && $this->isApiMethodAccepted()
            && $this->canTrackUser()
        ) {
            $rawContent = str_replace(["\n", "\r"], ' ', (string) $this->_httpRequest->getContent());

            $this->_apiLogger
                ->setApiType('GRAPHQL')
                ->setRequestData($this->convertContent($rawContent))
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
            && $this->_dataHelper->getApiConfig(Helper::CONFIG_LOG_GRAPHQL)
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
