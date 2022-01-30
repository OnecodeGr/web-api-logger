<?php
/**
 * ApiUsers
 *
 * @copyright Copyright © 2022 Onecode  All rights reserved.
 * @author    spyros@onecode.gr
 */

namespace Onecode\WebApiLogger\Model\System\Config;

use Magento\Framework\Data\OptionSourceInterface;
use Onecode\WebApiLogger\Model\ResourceModel\ApiLogger\CollectionFactory;

class ApiUsers implements OptionSourceInterface
{


    private $collectionFactory;

    public function __construct(CollectionFactory $collectionFactory)
    {
        $this->collectionFactory = $collectionFactory;
    }


    public function toOptionArray()
    {

        $collection = $this->collectionFactory->create()->distinct(true)->addFieldToSelect("api_user");
        $options = [];
        foreach ($collection as $apiLogger) {
            $options[$apiLogger->getData("api_user")] = $apiLogger->getData("api_user");
        }
        return $options;
    }


}
