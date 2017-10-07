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

namespace Prince\Productattach\Block\Adminhtml\Productattach\Edit;

/**
 * Class Tabs
 * @package Prince\Productattach\Block\Adminhtml\Productattach\Edit
 */
class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    /**
     * @return void
     */
    public function _construct()
    {
        parent::_construct();
        $this->setId('page_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Attachment Information'));
    }
}
