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

namespace Prince\Productattach\Model;

use Prince\Productattach\Api\Api;
use Prince\Productattach\Api\Productattach;
use Prince\Productattach\Api\Data;
use Magento\Framework\Exception\NotFoundException;
use Symfony\Component\Config\Definition\Exception\Exception;

class ProductattachWebApi implements \Prince\Productattach\Api\ProductattachInterface
{
    /**
     * @var \Prince\Productattach\Model\ResourceModel\Productattach
     */
    protected $_productattach;

    /**
     * @var \Prince\Productattach\Model\ResourceModel\Productattach\CollectionFactory
     */
    protected $_productattachCollectionFactory;

    /**
     * @var \Prince\Productattach\Api\Data\ProductattachTableInterface
     */
    protected $_productattachTableInterface;

    /**
     * @var Data\ProductattachTableInterfaceFactory
     */
    protected $_productattachTableInterfaceFactory;

    /**
     * @var \Magento\Framework\Api\ExtensibleDataObjectConverter
     */
    protected $_extensibleDataObjectConverter;

    /**
     * @var \Prince\Productattach\Helper\Data
     */
    protected $_dataHelper;

    /**
     * ProductattachWebApi constructor.
     * @param ResourceModel\Productattach $productattach
     * @param ProductattachTableFactory $productattachCollectionFactory
     * @param Data\ProductattachTableInterface $productattachTableInterface
     * @param Data\ProductattachTableInterfaceFactory $productattachTableInterfaceFactory
     * @param \Magento\Framework\Api\ExtensibleDataObjectConverter $extensibleDataObjectConverter
     * @param \Prince\Productattach\Helper\Data $dataHelper
     */
    public  function __construct(
        \Prince\Productattach\Model\ResourceModel\Productattach $productattach,
        \Prince\Productattach\Model\ProductattachTableFactory $productattachCollectionFactory,
        \Prince\Productattach\Api\Data\ProductattachTableInterface $productattachTableInterface,
        \Prince\Productattach\Api\Data\ProductattachTableInterfaceFactory $productattachTableInterfaceFactory,
        \Magento\Framework\Api\ExtensibleDataObjectConverter $extensibleDataObjectConverter,
        \Prince\Productattach\Helper\Data $dataHelper
    ) {
        $this->_productattach = $productattach;
        $this->_productattachCollectionFactory = $productattachCollectionFactory;
        $this->_productattachTableInterface = $productattachTableInterface;
        $this->_productattachTableInterfaceFactory = $productattachTableInterfaceFactory;
        $this->_extensibleDataObjectConverter = $extensibleDataObjectConverter;
        $this->_dataHelper = $dataHelper;
    }

    /**
     * @param Data\ProductattachTableInterface $productattachTableInterface
     * @param $fileName
     * @param $fileContent
     * @return mixed
     * @throws \Exception
     */
    public function UpdateInsertAttachment(
        \Prince\Productattach\Api\Data\ProductattachTableInterface $productattachTableInterface,
        $fileName,
        $fileContent
    ) {
        $objectArray = $productattachTableInterface->getData();

        $id = $productattachTableInterface->getId();
        if($id == 0)
            $objectArray["productattach_id"] = null;

        $attachment = $this->_productattachCollectionFactory->create();
        $attachment->setData($objectArray);

        $this->_productattach->load($attachment, $id);

        if($attachment->isObjectNew() == false)
        {
            //UPDATE ATTACHMENT RECORD
            if(array_key_exists('name', $objectArray))
                $attachment->setName($objectArray['name']);
            if(array_key_exists('description', $objectArray))
                $attachment->setDescription($objectArray['description']);
            if(array_key_exists('url', $objectArray))
                $attachment->setUrl($objectArray['url']);
            if(array_key_exists('products', $objectArray))
                $attachment->setProducts($objectArray['products']);
            if(array_key_exists('customer_group', $objectArray))
                $attachment->setCustomerGroup($objectArray['customer_group']);
            if(array_key_exists('store', $objectArray))
                $attachment->setStore($objectArray['store']);
            if(array_key_exists('active', $objectArray))
                $attachment->setActive($objectArray['active']);
        }

        //check if file already exists on the file system
        if($fileContent){
            //this is a new file or an updated version of it => check if file already exists on the system
            if($this->_dataHelper->checkIfFileExists($fileName)) {
                //delete file
                $this->_dataHelper->deleteFile($this->_dataHelper->getFileDispersionPath($fileName)."/".$fileName);
            }
            //create file
            if(!$this->_dataHelper->saveFile($fileName, $fileContent)){
                return -1;
            } else {
                //update file path
                $attachment->setFile( $this->_dataHelper->getFilePathForDB($fileName) );

                $fileExt = "";
                $slicedFileName = explode('.', $fileName);
                if(count($slicedFileName) > 1){
                    $fileExt = $slicedFileName[count($slicedFileName)-1];
                }
                $attachment->setFileExt($fileExt);
            }
        } else {
            $attachment->setFileExt('');
        }

        //save attachment record
        $this->_productattach->save($attachment);

        //return the id of the create/updated record
        return $attachment->getId();
    }

    /**
     * @param int $int
     * @throws NotFoundException
     * @throws \Exception
     * @return bool
     */
    public function DeleteAttachment(
        $int
    ) {
        //delete DB record
        $attachment = $this->_productattachCollectionFactory->create();
        $this->_productattach->load($attachment, $int);
        if(!$attachment->getId())
            return false;
        $this->_productattach->delete($attachment);

        //check if this is the last record from the DB linked to this file => if it's true, than delete this file
        /** @var \Prince\Productattach\Model\ResourceModel\Productattach\Collection $collection */
        $collection = $this->_productattachCollectionFactory->create()->getCollection();
        $collection->addFieldToFilter('file', $attachment->getData("file"));
        if($collection->count() == 0){
            //delete file on the file system
            $this->_dataHelper->deleteFile($attachment->getData("file"));
        }

        return true;
    }

    /**
     * @param int $int
     * @return ProductattachTable
     * @throws NotFoundException
     */
    public function GetAttachment(
        $int
    ) {
        $attachment = $this->_productattachCollectionFactory->create();
        $this->_productattach->load($attachment, $int);
        if(!$attachment->getId()) {
            throw new \Magento\Framework\Exception\NotFoundException(
                __('no attachment found')
            );
        }
        $attachResponse = $this->_productattachCollectionFactory->create();
        if($attachment->getData()) {
            $attachResponse->setProductAttachId($attachment->getId());
            $attachResponse->setName($attachment->getName());
            $attachResponse->setDescription($attachment->getDescription());
            $attachResponse->setFile($attachment->getFile());
            $attachResponse->setUrl($attachment->getUrl());
            $attachResponse->setStore($attachment->getStore());
            $attachResponse->setCustomerGroup($attachment->getCustomerGroup());
            $attachResponse->setProducts($attachment->getProducts());
            $attachResponse->setActive($attachment->getActive());
        }

        return $attachResponse;
    }

    const CUSTOM_PATH = "custom/upload";
}