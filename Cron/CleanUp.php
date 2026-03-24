<?php
/**
 * CleanUp
 *
 * @copyright Copyright © 2022 Onecode  All rights reserved.
 * @author    support@onecde.gr
 *
 */

namespace Onecode\WebApiLogger\Cron;

use Exception;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Psr\Log\LoggerInterface;
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
    private const BATCH_SIZE = 500;

    /** @var Data */
    private $_data;

    /** @var ApiLoggerRepositoryInterface */
    private $apiLoggerRepository;

    /** @var SearchCriteriaBuilder */
    private $searchCriteriaBuilder;

    /** @var LoggerInterface */
    private $logger;

    public function __construct(
        Data                         $data,
        ApiLoggerRepositoryInterface $apiLoggerRepository,
        SearchCriteriaBuilder        $searchCriteriaBuilder,
        LoggerInterface              $logger
    ) {
        $this->_data                 = $data;
        $this->apiLoggerRepository   = $apiLoggerRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->logger                = $logger;
    }

    /**
     * @return bool
     */
    public function execute(): bool
    {
        try {

            $days = (int) $this->_data->getApiConfig(Data::CONFIG_CLEAN_UP_DAYS);

            if ($days <= 0) {
                return true; // cleanup disabled
            }

            $cutoffDate = date('Y-m-d H:i:s', strtotime("-{$days} days"));


            $deleted = 0;
            do {
                $this->searchCriteriaBuilder
                    ->addFilter(ApiLoggerInterface::CREATED_AT, $cutoffDate, 'lt');

                $searchCriteria = $this->searchCriteriaBuilder
                    ->setPageSize(self::BATCH_SIZE)
                    ->setCurrentPage(1)
                    ->create();

                $collection = $this->apiLoggerRepository->getList($searchCriteria);
                $items      = $collection->getItems();

                if (empty($items)) {
                    break;
                }

                /** @var ApiLogger $item */
                foreach ($items as $item) {
                    $this->apiLoggerRepository->delete($item);
                    $deleted++;
                }

            } while (count($items) === self::BATCH_SIZE);

            if ($deleted > 0) {
                $this->logger->info(
                    "WebApiLogger CleanUp: deleted {$deleted} records older than {$days} days."
                );
            }

        } catch (Exception $e) {
            $this->logger->error(
                'WebApiLogger CleanUp failed: ' . $e->getMessage(),
                ['exception' => $e]
            );

            return false;
        }

        return true;
    }
}
