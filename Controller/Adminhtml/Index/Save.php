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
use Magento\Framework\View\LayoutFactory;

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
     * @var \Prince\Productattach\Model\ProductattachFactory
     */
    private $attachModelFactory;

    /**
     * @var LayoutFactory
     */
    protected $layoutFactory;

    /**
     * @var \Magento\Backend\Model\Session
     */
    private $backSession;

    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $resultJsonFactory;

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
        \Prince\Productattach\Model\ProductattachFactory $attachModelFactory,
        LayoutFactory $layoutFactory,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        Data $helper
    ) {
        $this->dataProcessor = $dataProcessor;
        $this->attachModelFactory = $attachModelFactory;
        $this->layoutFactory = $layoutFactory;
        $this->resultJsonFactory = $resultJsonFactory;
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
        if (!$data) {
            $this->_redirect('*/*/');
            return;
        }

        $data = $this->dataProcessor->filter($data);
        $customerGroup = $this->helper->getCustomerGroup($data['customer_group']);
        $store = $this->helper->getStores($data['store']);
        $data['customer_group'] = $customerGroup;
        $data['store'] = $store;
        /** @var \Prince\Productattach\Model\Productattach $model */
        $model = $this->attachModelFactory->create();
        $id = $this->getRequest()->getParam('productattach_id');

        if ($id) {
            $model->load($id);
        }

        $model->addData($data);

        if (!$this->dataProcessor->validate($data)) {
            $this->_redirect('*/*/edit', ['productattach_id' => $model->getId(), '_current' => true]);
            return;
        }

        try {
            if (isset($_FILES['file']) && $_FILES['file']['name'] != '') {
                $imageFile = $this->helper->uploadFile('file');
                $model->setFile($imageFile);
            }

            $model->save();
            $this->messageManager->addSuccess(__('Attachment has been saved.'));
        } catch (\RuntimeException $e) {
            $this->messageManager->addError($e->getMessage());
            $this->_getSession()->setFormData($data);
        } catch (\Exception $e) {
            $this->messageManager->addException($e, __('Something went wrong while saving the attachment.'));
            $this->_getSession()->setFormData($data);
        }

        $hasError = (bool)$this->messageManager->getMessages()->getCountByType(
            \Magento\Framework\Message\MessageInterface::TYPE_ERROR
        );

        if ($this->getRequest()->getParam('popup')) {
            $model->load($model->getId());
            // to obtain truncated category name
            /** @var $block \Magento\Framework\View\Element\Messages */
            $block = $this->layoutFactory->create()->getMessagesBlock();
            $block->setMessages($this->messageManager->getMessages(true));

            /** @var \Magento\Framework\Controller\Result\Json $resultJson */
            $resultJson = $this->resultJsonFactory->create();
            return $resultJson->setData(
                [
                    'messages' => $block->getGroupedHtml(),
                    'error' => $hasError,
                    'attachment' => $this->helper->format($model),
                ]
            );
        }

        if ($model->getId()) {
            $this->_redirect('*/*/edit', ['productattach_id' => $model->getId(), '_current' => true]);
        } else {
            $this->_redirect('*/*/');
        }
    }
}
