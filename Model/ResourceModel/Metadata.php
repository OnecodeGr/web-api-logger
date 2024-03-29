<?php
/**
 * Metadata.php
 *
 * @copyright Copyright © 2021 Onecode P.C. All rights reserved.
 * @author    Spyros Bodinis {spyros@onecode.gr}
 */

namespace Onecode\WebApiLogger\Model\ResourceModel;

use Magento\Framework\Api\ExtensibleDataInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\ObjectManagerInterface;

class Metadata
{
    /**
     * @var ObjectManagerInterface
     */
    protected $objectManager;

    /**
     * @var string
     */
    protected $resourceClassName;

    /**
     * @var string
     */
    protected $modelClassName;

    /**
     * @param ObjectManagerInterface $objectManager
     * @param string $resourceClassName
     * @param string $modelClassName
     */
    public function __construct(
        ObjectManagerInterface $objectManager,
                               $resourceClassName,
                               $modelClassName
    )
    {
        $this->objectManager = $objectManager;
        $this->resourceClassName = $resourceClassName;
        $this->modelClassName = $modelClassName;
    }

    /**
     * @return AbstractDb
     */
    public function getMapper(): AbstractDb
    {
        return $this->objectManager->get($this->resourceClassName);
    }

    /**
     * @return ExtensibleDataInterface
     */
    public function getNewInstance(): ExtensibleDataInterface
    {
        return $this->objectManager->create($this->modelClassName);
    }
}
