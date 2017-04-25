<?php

/**
 * Productattach Resource Collection
 */
namespace Krish\Productattach\Model\ResourceModel\Productattach;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    protected $_idFieldName = 'productattach_id';
    /**
     * Resource initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Krish\Productattach\Model\Productattach', 'Krish\Productattach\Model\ResourceModel\Productattach');
    }
}
