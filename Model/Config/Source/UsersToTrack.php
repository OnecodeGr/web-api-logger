<?php
/**
 * UsersToTrack.php
 *
 * @copyright Copyright © 2022 Onecode  All rights reserved.
 * @author    Spyros Bodinis {spyros@onecode.gr}
 */

namespace Onecode\WebApiLogger\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Integration\Model\Integration;
use Magento\Integration\Model\ResourceModel\Integration\CollectionFactory as IntegrationCollectionFactory;

class UsersToTrack implements OptionSourceInterface
{

    private $collectionFactory;

    public function __construct(IntegrationCollectionFactory $collectionFactory)
    {
        $this->collectionFactory = $collectionFactory;
    }


    public function toOptionArray()
    {
        $this->collectionFactory->create();
        $data = [
            [
                "label" => "anonymous",
                "value" => "anonymous"
            ]
        ];

        /** @var  Integration $integration */
        foreach ($this->collectionFactory->create() as $integration) {
            if ($integration->getStatus() == 1) {
                $data [] = [
                    "label" => $integration->getName(),
                    "value" => $integration->getName()
                ];
            }

        }
        return $data;
    }
}
