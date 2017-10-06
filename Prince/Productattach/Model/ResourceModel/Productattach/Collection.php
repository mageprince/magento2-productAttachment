<?php

/**
 * Productattach Resource Collection
 */
namespace Prince\Productattach\Model\ResourceModel\Productattach;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    protected $_idFieldName = 'productattach_id';

    /**
     * Resource initialization
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init(
            'Prince\Productattach\Model\Productattach',
            'Prince\Productattach\Model\ResourceModel\Productattach'
        );
    }
}
