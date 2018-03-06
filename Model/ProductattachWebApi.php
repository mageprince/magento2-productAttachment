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
     * @var \Magento\Framework\Api\ExtensibleDataObjectConverter
     */
    protected $_extensibleDataObjectConverter;

    /**
     * @var \Prince\Productattach\Helper\Data
     */
    protected $_dataHelper;

    /**
     * @param Productattach $productAttach
     * @param \Magento\Framework\Api\ExtensibleDataObjectConverter $extensibleDataObjectConverter
     * @param Data\ProductattachTableInterface $productattachTableInterface
     * @param ResourceModel\Productattach\CollectionFactory $productattachCollectionFactory
     */
    public  function __construct(
        \Prince\Productattach\Model\ResourceModel\Productattach $productattach,
        \Prince\Productattach\Model\ProductattachTableFactory $productattachCollectionFactory,
        \Prince\Productattach\Api\Data\ProductattachTableInterface $productattachTableInterface,
        \Magento\Framework\Api\ExtensibleDataObjectConverter $extensibleDataObjectConverter,
        \Prince\Productattach\Helper\Data $dataHelper
    )
    {
        $this->_productattach = $productattach;
        $this->_productattachCollectionFactory = $productattachCollectionFactory;
        $this->_productattachTableInterface = $productattachTableInterface;
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
    ){
        $objectArray = $productattachTableInterface->getData();

        $id = $productattachTableInterface->getId();
        if($id == 0)
            $objectArray["productattach_id"] = null;

        $attachment = $this->_productattachCollectionFactory->create();
        $attachment->setData($objectArray);

        $this->_productattach->load($attachment, $id);

        if($attachment->isObjectNew() == false)
        {
            //UPDATE REC
            $attachment->setName($objectArray["name"]);
            $attachment->setDescription($objectArray["description"]);
            $attachment->setProducts($objectArray["products"]);
            $attachment->setCustomerGroup($objectArray["customer_group"]);
            $attachment->setStore($objectArray["store"]);
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
            }
        }else{
            //file is already on the file system (not cpecified by the fileCOntent element) => just update the record
        }

        //update file path
        $attachment->setFile( $this->_dataHelper->getFilePathForDB($fileName) );

        $fileExt = "";
        $slicedFileName = explode('.', $fileName);
        if(count($slicedFileName) > 1){
            $fileExt = $slicedFileName[count($slicedFileName)-1];
        }
        $attachment->setFileExt($fileExt);

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
    ){
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

    const CUSTOM_PATH = "custom/upload";
}