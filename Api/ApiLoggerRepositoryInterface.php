<?php

namespace Onecode\WebApiLogger\Api;


use Magento\Framework\Api\SearchCriteriaInterface;
use Onecode\WebApiLogger\Api\Data\ApiLoggerInterface;
use Onecode\WebApiLogger\Api\Data\ApiLoggerSearchResultInterface;

interface ApiLoggerRepositoryInterface
{

    /**
     * @param int $id
     * @return ApiLoggerInterface
     */
    public function get(int $id): ApiLoggerInterface;

    /**
     * @param ApiLoggerInterface $entity
     * @return ApiLoggerInterface
     */
    public function save(ApiLoggerInterface $entity): ApiLoggerInterface;


    /**
     * @param ApiLoggerInterface $entity
     * @return bool
     */
    public function delete(ApiLoggerInterface $entity): bool;

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return ApiLoggerSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria):ApiLoggerSearchResultInterface;

}
