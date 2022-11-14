<?php

namespace Onecode\WebApiLogger\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface ApiLoggerSearchResultInterface extends SearchResultsInterface
{
    /**
     * @return  ApiLoggerInterface[]
     */
    public function getItems();

    /**
     * @param ApiLoggerInterface[] $items
     * @return void
     */
    public function setItems($items);
}
