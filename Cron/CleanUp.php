<?php
/**
 * CleanUp
 *
 * @copyright Copyright © 2022 Onecode  All rights reserved.
 * @author    spyros@onecode.gr
 */

namespace Onecode\WebApiLogger\Cron;


use Exception;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Onecode\WebApiLogger\Api\ApiLoggerRepositoryInterface;
use Onecode\WebApiLogger\Api\Data\ApiLoggerInterface;
use Onecode\WebApiLogger\Helper\Data;
use Onecode\WebApiLogger\Model\ApiLogger;

/**
 * Class CleanUp
 * @package Onecode\WebApiLogger\Cron
 */
class CleanUp
{


    private $_data;
    /**
     * @var ApiLoggerRepositoryInterface
     */
    private $apiLoggerRepository;
    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    public function __construct(
        Data                         $data,
        ApiLoggerRepositoryInterface $apiLoggerRepository,
        SearchCriteriaBuilder        $searchCriteriaBuilder
    )
    {
        $this->_data = $data;
        $this->apiLoggerRepository = $apiLoggerRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;

    }


    /**
     * @return bool
     */
    public function execute(): bool
    {
        try {
            $days = $this->_data->getApiConfig("cleanup_days");
            if ($days > 0) {
                $dateTime = date('Y-m-d H:i:s', strtotime("-$days days"));
                $this->searchCriteriaBuilder->addFilter(ApiLoggerInterface::CREATED_AT, $dateTime, "lt");
                $searchCriteria = $this->searchCriteriaBuilder->create();
                $collection = $this->apiLoggerRepository->getList($searchCriteria);
                $collection->load(true);
                /** @var ApiLogger $item */
                foreach ($collection as $item) {
                    $this->apiLoggerRepository->delete($item);
                }
            }

        } catch (Exception $e) {

        }

        return true;
    }

}
