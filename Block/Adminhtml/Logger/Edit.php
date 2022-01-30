<?php
/**
 * Edit
 *
 * @copyright Copyright © 2022 Onecode  All rights reserved.
 * @author    spyros@onecode.gr
 */

namespace Onecode\WebApiLogger\Block\Adminhtml\Logger;

use Magento\Backend\Block\Widget\Form\Container;
use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\AbstractBlock;
use Onecode\WebApiLogger\Model\ApiLogger;

class Edit extends Container {

	/**
	 * Core registry
	 *
	 * @var Registry
	 */
	protected $_coreRegistry = null;


	/**
	 * @param Context  $context
	 * @param Registry $registry
	 * @param array    $data
	 */
	public function __construct (
		Context $context,
		Registry $registry,
		array $data = []
	) {
		$this->_coreRegistry = $registry;
		parent::__construct( $context, $data );
	}


	/**
	 * Class constructor
	 *
	 * @return void
	 */
	protected function _construct () {
		$this->_objectId   = 'id';
		$this->_controller = 'adminhtml_logger';
		$this->_blockGroup = 'Onecode_WebApiLogger';
		parent::_construct();
		$this->removeButton( "save" );
		$this->removeButton( "reset" );
		$this->removeButton( "delete" );
		$this->buttonList->update( 'back', 'onclick', 'setLocation(\'' . $this->getUrl( "*/*/" ) . '\');' );
	}

	/**
	 * Retrieve text for header element depending on loaded news
	 *
	 * @return string
	 */
	public function getHeaderText () {
		/** @var ApiLogger $apiLogger */
		$apiLogger = $this->_coreRegistry->registry( 'api_logger' );
		if ( $apiLogger->getId() ) {
			$processTitle = $this->escapeHtml( $apiLogger->getUrlRequest() );

			return __( "API Request '%1'", $processTitle );
		}

		return "";
	}

	/**
	 * Prepare layout
	 *
	 * @return AbstractBlock
	 */
	protected function _prepareLayout () {
		$this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('post_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'post_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'post_content');
                }
            };
        ";

		return parent::_prepareLayout();
	}

}
