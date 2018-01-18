<?php

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
