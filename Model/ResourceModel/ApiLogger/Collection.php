<?php

/**
 * @copyright Copyright © 2022 Onecode  All rights reserved.
 * @author    spyros@onecode.gr
 */

namespace Onecode\WebApiLogger\Model\ResourceModel\ApiLogger;

use Magento\Framework\Api\SearchCriteriaInterface;
use  Magento\Framework\Model\ResourceModel\Db\VersionControl\Collection as AbstractCollection;
use Onecode\WebApiLogger\Api\Data\ApiLoggerSearchResultInterface;
use  Onecode\WebApiLogger\Model\ApiLogger as ModelClass;
use Onecode\WebApiLogger\Model\ResourceModel\ApiLogger as ResourceModelClass;


/**
 * Class Collection
 * @package Onecode\WebApiLogger\Model\ResourceModel\ApiLogger\Collection
 */
class Collection extends AbstractCollection implements ApiLoggerSearchResultInterface {

    /**
     * @var SearchCriteriaInterface
     */
    private $searchCriteria;

    /**
	 * Initialize resource collection
	 *
	 * @return void
	 */
	public function _construct () {
		$this->_init( ModelClass::class, ResourceModelClass::class );
	}

    public function setItems( $items)
    {
        if (!$items) {
            return $this;
        }
        foreach ($items as $item) {
            $this->addItem($item);
        }
        return $this;
    }

    public function getSearchCriteria()
    {
        return $this->searchCriteria;
    }

    public function setSearchCriteria(SearchCriteriaInterface $searchCriteria)
    {
        $this->searchCriteria = $searchCriteria;
        return $this;
    }

    public function getTotalCount()
    {
        return $this->getSize();
    }

    public function setTotalCount($totalCount)
    {
        $this->_totalRecords = $totalCount;
        return $this;
    }
}
