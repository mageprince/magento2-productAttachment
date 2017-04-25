<?php
/**
 * Adminhtml productattach list block
 *
 */
namespace Krish\Productattach\Block\Adminhtml;

class Productattach extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * Constructor
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_controller = 'adminhtml_productattach';
        $this->_blockGroup = 'Krish_Productattach';
        $this->_headerText = __('Product Attachments');
        $this->_addButtonLabel = __('Add New Attachment');
        parent::_construct();
        if ($this->_isAllowedAction('Krish_Productattach::save')) {
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
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
}
