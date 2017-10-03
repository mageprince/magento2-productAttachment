<?php
/**
 * Adminhtml productattach list block
 *
 */
namespace Prince\Productattach\Block\Adminhtml;

class Productattach extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * Constructor
     *
     * @return void
     */
    public function _construct()
    {
        $this->_controller = 'adminhtml_productattach';
        $this->_blockGroup = 'Prince_Productattach';
        $this->_headerText = __('Product Attachments');
        $this->_addButtonLabel = __('Add New Attachment');
        parent::_construct();
        if ($this->_isAllowedAction('Prince_Productattach::save')) {
            $this->buttonList->update('add', 'label', __('Add New Attachment'));
        } else {
            $this->buttonList->remove('add');
        }
    }
    
    /**
     * Check permission for passed action
     *
     * @param string $resourceId
     * @return bool
     */
    public function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
}
