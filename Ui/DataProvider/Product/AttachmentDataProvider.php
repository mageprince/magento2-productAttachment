<?php
/**
 * @author Convert Team
 * @copyright Copyright (c) 2018 Convert (http://www.convert.no/)
 */
namespace Prince\Productattach\Ui\DataProvider\Product;

use Prince\Productattach\Model\ResourceModel\Productattach\Collection;
use Prince\Productattach\Model\ResourceModel\Productattach\CollectionFactory;

class AttachmentDataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);

        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @return Collection
     */
    public function getCollection()
    {
        if (null === $this->collection) {
            /** @var Collection $collection */
            $this->collection = $this->collectionFactory->create();
        }

        return $this->collection;
    }
}
