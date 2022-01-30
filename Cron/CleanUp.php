<?php
/**
 * CleanUp
 *
 * @copyright Copyright © 2022 Onecode  All rights reserved.
 * @author    spyros@onecode.gr
 */

namespace Onecode\WebApiLogger\Cron;


use Exception;
use Onecode\WebApiLogger\Helper\Data;
use Onecode\WebApiLogger\Model\ApiLogger;
use Onecode\WebApiLogger\Model\ResourceModel\ApiLogger\CollectionFactory;

/**
 * Class CleanUp
 * @package Onecode\WebApiLogger\Cron
 */
class CleanUp
{


    private $_data;
    private $collectionFactory;

    /**
     * CleanUp constructor.
     *
     * @param ApiLogger $apiLogger
     * @param Data $data
     */
    public function __construct(CollectionFactory $collectionFactory, Data $data)
    {

        $this->collectionFactory = $collectionFactory;
        $this->_data = $data;

    }


    /**
     * @return bool
     */
    public function execute()
    {
        try {
            $days = $this->_data->getApiConfig("cleanup_days");
            if($days > 0 ){
                $dateTime = date('Y-m-d H:i:s', strtotime("-$days days"));
                $collection = $this->collectionFactory->create()->addFieldToFilter("created_at", ["lt" => $dateTime]);
                $collection->load(true);
                /** @var ApiLogger $item */
                foreach ($collection as $item) {
                    $item->delete();
                }
            }

        } catch (Exception $e) {

        }

        return true;
    }

}
