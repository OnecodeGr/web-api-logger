<?php

namespace Onecode\WebApiLogger\Model;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\NoSuchEntityException;
use Onecode\WebApiLogger\Api\ApiLoggerRepositoryInterface;
use Onecode\WebApiLogger\Api\Data\ApiLoggerInterface;
use Onecode\WebApiLogger\Api\Data\ApiLoggerSearchResultInterfaceFactory;
use Onecode\WebApiLogger\Api\Data\ApiLoggerSearchResultInterface;
use Onecode\WebApiLogger\Model\ResourceModel\Metadata;

class ApiLoggerRepository implements ApiLoggerRepositoryInterface
{

    private $registry = [];
    /**
     * @var ApiLoggerSearchResultInterfaceFactory
     */
    private $searchResultFactory;
    /**
     * @var Metadata
     */
    private $metadata;
    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    public function __construct(
        ApiLoggerSearchResultInterfaceFactory $searchResultInterfaceFactory,
        Metadata                       $metadata,
        CollectionProcessorInterface   $collectionProcessor
    )
    {
        $this->searchResultFactory = $searchResultInterfaceFactory;
        $this->metadata = $metadata;
        $this->collectionProcessor = $collectionProcessor;
    }

    public function get(int $id): ApiLoggerInterface
    {
        if (!$id) {
            throw new InputException(__('An ID is needed. Set the ID and try again.'));
        }
        if (!isset($this->registry[$id])) {
            /** @var ApiLoggerInterface $entity */
            $entity = $this->metadata->getNewInstance()->load($id);
            if (!$entity->getId()) {
                throw new NoSuchEntityException(
                    __('Unable to find api logger record with id "%1"', $id)
                );
            }


            $this->registry[$id] = $entity;
        }
        return $this->registry[$id];
    }

    public function save(ApiLoggerInterface $entity): ApiLoggerInterface
    {
        $this->metadata->getMapper()->save($entity);

        $this->registry[$entity->getId()] = $entity;
        return $this->registry[$entity->getId()];
    }

    public function delete(ApiLoggerInterface $entity): bool
    {
        $this->metadata->getMapper()->delete($entity);
        unset($this->registry[$entity->getId()]);
        return true;
    }

    public function getList(SearchCriteriaInterface $searchCriteria): ApiLoggerSearchResultInterface
    {
        $searchResults = $this->searchResultFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $this->collectionProcessor->process($searchCriteria, $searchResults);


        return $searchResults;
    }
}
