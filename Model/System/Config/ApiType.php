<?php
/**
 * ApiType
 *
 * @copyright Copyright © 2022 Onecode  All rights reserved.
 * @author    spyros@onecode.gr
 */

namespace Onecode\WebApiLogger\Model\System\Config;

use Magento\Framework\Data\OptionSourceInterface;
use Onecode\WebApiLogger\Model\ResourceModel\ApiLogger\CollectionFactory;

/**
 * Class ApiType
 * @package Onecode\WebApiLogger\Model\System\Config
 */
class ApiType implements OptionSourceInterface {


    private $collectionFactory;

    public function __construct(CollectionFactory $collectionFactory)
    {
        $this->collectionFactory = $collectionFactory;
    }

    /**
	 * @return array
	 */
	public function toOptionArray () {

        $collection = $this->collectionFactory->create()->distinct(true)->addFieldToSelect("api_type");
        $options = [];
        foreach ($collection as $apiLogger) {
            $options[$apiLogger->getData("api_type")] = $apiLogger->getData("api_type");
        }
        return $options;
	}
}
