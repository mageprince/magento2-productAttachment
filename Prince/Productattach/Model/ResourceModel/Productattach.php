<?php

/**
 * Mageprince
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @package Prince_Productattach
 */

namespace Prince\Productattach\Model\ResourceModel;

/**
 * Class Productattach
 * @package Prince\Productattach\Model\ResourceModel
 */
class Productattach extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init('prince_productattach', 'productattach_id');
    }
}
