<?php

/**
 * MagePrince
 * Copyright (C) 2018 Mageprince
 *
 * NOTICE OF LICENSE
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see http://opensource.org/licenses/gpl-3.0.html
 *
 * @category MagePrince
 * @package Prince_Productattach
 * @copyright Copyright (c) 2018 MagePrince
 * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License,version 3 (GPL-3.0)
 * @author MagePrince
 */

namespace Prince\Productattach\Block\Adminhtml\Productattach\Edit\Tab;

/**
 * Class Main
 * @package Prince\Productattach\Block\Adminhtml\Productattach\Edit\Tab
 */
class Main extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    /**
     * @var \Magento\Store\Model\System\Store
     */
    private $systemStore;

    /**
     * @var \Magento\Customer\Model\ResourceModel\Group\Collection
     */
    private $customerCollection;

    /**
     * Main constructor.
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Store\Model\System\Store $systemStore
     * @param \Magento\Customer\Model\ResourceModel\Group\Collection $customerCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Store\Model\System\Store $systemStore,
        \Magento\Customer\Model\ResourceModel\Group\Collection $customerCollection,
        array $data = []
    ) {
        $this->systemStore = $systemStore;
        $this->customerCollection = $customerCollection;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form
     *
     * @return $this
     */
    public function _prepareForm()
    {
        
        $model = $this->_coreRegistry->registry('productattach');

        /*
         * Checking if user have permissions to save information
         */
        if ($this->_isAllowedAction('Prince_Productattach::save')) {
            $isElementDisabled = false;
        } else {
            $isElementDisabled = true;
        }

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();

        $form->setHtmlIdPrefix('productattach_main_');

        $fieldset = $form->addFieldset('base_fieldset',
            ['legend' => __('Productattach Information')]
        );

        $customerGroup = $this->customerCollection->toOptionArray();

        if ($model->getId()) {
            $fieldset->addField('productattach_id', 'hidden', ['name' => 'productattach_id']);
        }

        $fieldset->addField(
            'name',
            'text',
            [
                'name' => 'name',
                'label' => __('Attachment Name'),
                'title' => __('Attachment Name'),
                'required' => true,
                'disabled' => $isElementDisabled
            ]
        );

        $fieldset->addField(
            'description',
            'textarea',
            [
                'name' => 'description',
                'label' => __('Description'),
                'title' => __('Description'),
                'disabled' => $isElementDisabled
            ]
        );
        
        $fieldset->addField(
            'files',
            'file',
            [
                'name' => 'file',
                'label' => __('File'),
                'title' => __('File'),
                'required' => false,
                'note' => 'File size must be < 2M. You can increse limit from php.ini.',
                'disabled' => $isElementDisabled
            ]
        );

        $fieldset->addType(
            'uploadedfile',
            '\Prince\Productattach\Block\Adminhtml\Productattach\Renderer\FileIconAdmin'
        );

        $fieldset->addField(
            'file',
            'uploadedfile',
            [
                'name'  => 'uploadedfile',
                'label' => __('Uploaded File'),
                'title' => __('Uploaded File'),
               
            ]
        );

        $fieldset->addField(
            'url',
            'text',
            [
                'name' => 'url',
                'label' => __('URL'),
                'title' => __('URL'),
                'required' => false,
                'disabled' => $isElementDisabled,
                'note' => 'Upload file or Enter url'
            ]
        );

        $fieldset->addField(
            'customer_group',
            'multiselect',
            [
                'name' => 'customer_group[]',
                'label' => __('Customer Group'),
                'title' => __('Customer Group'),
                'required' => true,
                'value' => [0,1,2,3],
                'values' => $customerGroup,
                'disabled' => $isElementDisabled
            ]
        );

        $fieldset->addField(
            'store',
            'multiselect',
            [
                'name' => 'store[]',
                'label' => __('Store'),
                'title' => __('Store'),
                'required' => true,
                'value' => [0,1],
                'values' => $this->systemStore->getStoreValuesForForm(false, true),
                'disabled' => $isElementDisabled
            ]
        );

        $fieldset->addField(
            'active',
            'select',
            [
                'name' => 'active',
                'label' => __('Active'),
                'title' => __('Active'),
                'value' => 1,
                'options' => ['1' => __('Yes'), '0' => __('No')],
                'disabled' => $isElementDisabled
            ]
        );

        $this->_eventManager->dispatch('adminhtml_productattach_edit_tab_main_prepare_form', ['form' => $form]);

        if ($model->getId()) {
            $form->setValues($model->getData());
        }
        
        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * Prepare label for tab
     *
     * @return string
     */
    public function getTabLabel()
    {
        return __('Attachment Information');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return __('Attachment Information');
    }

    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return false;
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
