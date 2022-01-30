<?php
/**
 * @copyright Copyright © 2022 Onecode  All rights reserved.
 * @author    spyros@onecode.gr
 */

namespace Onecode\WebApiLogger\Controller\Adminhtml;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\App\Action;
use Onecode\WebApiLogger\Model\ApiLoggerFactory;
use Magento\Framework\Registry;

/**
 * Class Index
 * @package Onecode\WebApiLogger\Controller\Adminhtml\Logger\Index
 */
class Logger extends Action {


	/**
	 * Index resultPageFactory
	 * @var PageFactory
	 */
	protected $_resultPageFactory;

	/**
	 * @var ApiLoggerFactory
	 */
	protected $_apiLoggerFactory;

	/**
	 * @var Registry
	 */
	protected $_coreRegistry;

	/**
	 * Logger constructor.
	 *
	 * @param Context          $context
	 * @param PageFactory      $resultPageFactory
	 * @param ApiLoggerFactory $apiLoggerFactory
	 * @param Registry         $registry
	 */
	public function __construct (
		Context $context,
		PageFactory $resultPageFactory,
		ApiLoggerFactory $apiLoggerFactory,
		Registry $registry
	) {
		$this->_resultPageFactory = $resultPageFactory;
		$this->_apiLoggerFactory  = $apiLoggerFactory;
		$this->_coreRegistry      = $registry;
		parent::__construct( $context );
	}


	public function execute () {
	}
}
