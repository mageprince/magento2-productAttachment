<?php


namespace Prince\Productattach\Model\ResourceModel\Fileicon;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            'Prince\Productattach\Model\Fileicon',
            'Prince\Productattach\Model\ResourceModel\Fileicon'
        );
    }
}
