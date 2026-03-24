<?php
/**
 * @copyright Copyright © 2022 Onecode  All rights reserved.
 * @author    support@onecde.gr
 */

namespace Onecode\WebApiLogger\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Onecode\WebApiLogger\Model\ApiLoggerFactory;

/**
 * Class Logger
 * @package Onecode\WebApiLogger\Controller\Adminhtml
 */
class Logger extends Action
{
    public const ADMIN_RESOURCE = 'Onecode_WebApiLogger::logger_view';

    /** @var PageFactory */
    protected $_resultPageFactory;

    /** @var ApiLoggerFactory */
    protected $_apiLoggerFactory;

    /** @var Registry */
    protected $_coreRegistry;

    public function __construct(
        Context          $context,
        PageFactory      $resultPageFactory,
        ApiLoggerFactory $apiLoggerFactory,
        Registry         $registry
    ) {
        $this->_resultPageFactory = $resultPageFactory;
        $this->_apiLoggerFactory  = $apiLoggerFactory;
        $this->_coreRegistry      = $registry;
        parent::__construct($context);
    }

    /**
     * @return bool
     */
    protected function _isAllowed(): bool
    {
        return $this->_authorization->isAllowed(static::ADMIN_RESOURCE);
    }

    /**
     * Base execute — child classes override this.
     */
    public function execute()
    {
    }
}
