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

namespace Prince\Productattach\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Prince\Productattach\Helper\Data;

/**
 * Class Save
 * @package Prince\Productattach\Controller\Adminhtml\Index
 */
class Save extends \Magento\Backend\App\Action
{
    /**
     * @var PostDataProcessor
     */
    private $dataProcessor;

    /**
     * @var \Prince\Productattach\Helper\Data
     */
    private $helper;

    /**
     * @var \Prince\Productattach\Model\Productattach
     */
    private $attachModel;

    /**
     * @var \Magento\Backend\Model\Session
     */
    private $backSession;

    /**
     * Save constructor.
     * @param Action\Context $context
     * @param PostDataProcessor $dataProcessor
     * @param \Prince\Productattach\Model\Productattach $attachModel
     * @param Data $helper
     */
    public function __construct(
        Action\Context $context,
        PostDataProcessor $dataProcessor,
        \Prince\Productattach\Model\Productattach $attachModel,
        Data $helper
    ) {
        $this->dataProcessor = $dataProcessor;
        $this->attachModel = $attachModel;
        $this->backSession = $context->getSession();
        $this->helper = $helper;
        parent::__construct($context);
    }

    /**
     * @return bool
     */
    public function _isAllowed()
    {
        return $this->_authorization->isAllowed('Prince_Productattach::save');
    }

    /**
     * Save action
     *
     * @return void
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            $data = $this->dataProcessor->filter($data);
            $customerGroup = $this->helper->getCustomerGroup($data['customer_group']);
            $store = $this->helper->getStores($data['store']);
            $data['customer_group'] = $customerGroup;
            $data['store'] = $store;
            $uploadedFile = '';
            $model = $this->attachModel;
            $id = $this->getRequest()->getParam('productattach_id');
            
            if ($id) {
                $model->load($id);
                $uploadedFile = $model->getFile();
            }
            
            $model->addData($data);

            if (!$this->dataProcessor->validate($data)) {
                $this->_redirect('*/*/edit', ['productattach_id' => $model->getId(), '_current' => true]);
                return;
            }

            try {
                $imageFile = $this->helper->uploadFile('file', $model);
                $model->save();
                $this->messageManager->addSuccess(__('Attachment has been saved.'));
                $this->backSession->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', ['productattach_id' => $model->getId(), '_current' => true]);
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (\Magento\Framework\Model\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the attachment.'));
            }

            $this->_getSession()->setFormData($data);
            $this->_redirect('*/*/edit', ['productattach_id' => $this->getRequest()->getParam('productattach_id')]);
            return;
        }
        $this->_redirect('*/*/');
    }
}
