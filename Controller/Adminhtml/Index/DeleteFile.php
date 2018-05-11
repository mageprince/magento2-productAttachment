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

class DeleteFile extends \Magento\Backend\App\Action
{
    /**
     * @var \Prince\Productattach\Model\Productattach
     */
    private $attachModel;

    /**
     * @var \Magento\Framework\Filesystem\Driver\File
     */
    private $file;

    /**
     * @var \Magento\Framework\Filesystem
     */
    private $fileSystem;

    /**
     * @param \Magento\Backend\App\Action $context
     * @param \Prince\Productattach\Model\Productattach $attachModel
     * @param \Magento\Framework\Filesystem\Driver\File $file
     * @param \Magento\Framework\Filesystem $fileSystem
     */
    public function __construct(
        Action\Context $context,
        \Prince\Productattach\Model\Productattach $attachModel,
        \Magento\Framework\Filesystem\Driver\File $file,
        \Magento\Framework\Filesystem $fileSystem
    ) {
        $this->attachModel = $attachModel;
        $this->file = $file;
        $this->fileSystem = $fileSystem;
        parent::__construct($context);
    }

    /**
     * {@inheritdoc}
     */
    public function _isAllowed()
    {
        return $this->_authorization->isAllowed('Prince_Productattach::delete');
    }

    /**
     * Delete action
     *
     * @return void
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('productattach_id');
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                $model = $this->attachModel;
                $model->load($id);
                $currentFile = $model->getFile();
                $mediaDirectory = $this->fileSystem
                    ->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);
                $fileRootDir = $mediaDirectory->getAbsolutePath().'productattach';
                if ($this->file->isExists($fileRootDir . $currentFile)) {
                    $this->file->deleteFile($fileRootDir . $currentFile);
                    $model->setFile('');
                    $model->save();
                    $this->messageManager->addSuccess(__('The file has been deleted.'));
                }
                return $resultRedirect->setPath('*/*/edit', ['productattach_id' => $id]);
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['productattach_id' => $id]);
            }
        }
    }
}
