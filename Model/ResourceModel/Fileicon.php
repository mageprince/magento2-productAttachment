<?php


namespace Prince\Productattach\Model\ResourceModel;

class Fileicon extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('prince_productattach_fileicon', 'fileicon_id');
    }
}
