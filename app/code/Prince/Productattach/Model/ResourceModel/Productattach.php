<?php

namespace Prince\Productattach\Model\ResourceModel;

/**
 * Productattach Resource Model
 */
class Productattach extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Prince_productattach', 'productattach_id');
    }
}
