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

namespace Prince\Productattach\Helper;

use Magento\Framework\App\Filesystem\DirectoryList;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * Path to store config where count of productattach posts per page is stored
     *
     * @var string
     */
    const XML_PATH_ITEMS_PER_PAGE     = 'productattach/view/items_per_page';
    
    /**
     * Media path to extension images
     *
     * @var string
     */
    const MEDIA_PATH    = 'productattach';

    /**
     * @var \Magento\Framework\Filesystem\Directory\WriteInterface
     */
    private $mediaDirectory;

    /**
     * @var \Magento\Framework\Filesystem
     */
    private $filesystem;

    /**
     * File Uploader factory
     *
     * @var \Magento\Core\Model\File\UploaderFactory
     */
    private $fileUploaderFactory;
    
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var \Magento\Backend\Model\UrlInterface
     */
    private $backendUrl;

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Backend\Model\UrlInterface $backendUrl
     * @param \Magento\Framework\Filesystem $filesystem
     * @param \Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Backend\Model\UrlInterface $backendUrl,
        \Magento\Framework\Filesystem $filesystem,
        \Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->backendUrl = $backendUrl;
        $this->filesystem = $filesystem;
        $this->mediaDirectory = $filesystem->getDirectoryWrite(DirectoryList::MEDIA);
        $this->fileUploaderFactory = $fileUploaderFactory;
        $this->storeManager = $storeManager;
        parent::__construct($context);
    }
    
    /**
     * Upload image and return uploaded image file name or false
     *
     * @throws Mage_Core_Exception
     * @param string $scope the request key for file
     * @return bool|string
     */
    public function uploadFile($scope, $model)
    {
        try {
            $uploader = $this->fileUploaderFactory->create(['fileId' => $scope]);
            $uploader->setAllowedExtensions($this->getAllowedExt());
            $uploader->setAllowRenameFiles(true);
            $uploader->setFilesDispersion(true);
            $uploader->setAllowCreateFolders(true);
            
            if ($uploader->save($this->getBaseDir())) {
                $model->setFile($uploader->getUploadedFileName());
                $model->setFileExt($uploader->getFileExtension());
            }
        } catch (\Exception $e) {

        }

        return $model;
    }

    /**
     * Look on the file system if this file is present, according to the dispersion principle
     * @param $fileName
     * @return bool
     */
    public function checkIfFileExists($fileName){
        return file_exists($this->getDispersionFolderAbsolutePath($fileName)."/".$fileName);
    }

    /**
     * Save file-content to the file on the file-system
     * @param $filename
     * @param $fileContent
     * @return string
     */
    public function saveFile($filename, $fileContent){
        if ($fileContent != "") {
            try {
                $folderAbsolutePath = $this->getDispersionFolderAbsolutePath($filename);
                if (!file_exists($folderAbsolutePath)) {
                    //create folder
                    mkdir($folderAbsolutePath, 0777, true);
                }
                // create file
                file_put_contents($folderAbsolutePath."/".$filename, base64_decode($fileContent));
                return true;
            } catch (\Exception $e) {
                return false;
            }
        }else{
            return false;
        }
    }

    /**
     * Return the base media directory for Productattach Item images
     *
     * @return string
     */
    public function getBaseDir()
    {
        $path = $this->filesystem->getDirectoryRead(
            DirectoryList::MEDIA
        )->getAbsolutePath(self::MEDIA_PATH);
        return $path;
    }
    
    /**
     * Return the Base URL for Productattach Item images
     *
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->storeManager->getStore()->getBaseUrl(
            \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
        ) . self::MEDIA_PATH;
    }
    
    /**
     * Return the number of items per page
     *
     * @return int
     */
    public function getProductattachPerPage()
    {
        return abs((int)$this->getScopeConfig()
            ->getValue(self::XML_PATH_ITEMS_PER_PAGE, \Magento\Store\Model\ScopeInterface::SCOPE_STORE)
        );
    }

    /**
     * Return current store Id
     *
     * @return Int
     */
    public function getStoreId()
    {
        return $this->storeManager->getStore()->getId();
    }

    public function getProductsGridUrl()
    {
        return $this->backendUrl->getUrl('productattach/index/products', ['_current' => true]);
    }

    /**
     * Return customer groups
     */
    public function getCustomerGroup($customers)
    {
        $customers = implode(',', $customers);
        return $customers;
    }

    /**
     * Return stores
     */
    public function getStores($store)
    {
        $store = implode(',', $store);
        return $store;
    }

    /**
     * Return the path pof the file that will be save in the database
     * @param $fileName filename with file-extension
     * @return string
     */
    public function getFilePathForDB($fileName)
    {
        return ltrim($this->getFileDispersionPath($fileName), '/') ."/". $fileName;
    }

    /**
     * Return the path to the file acording to the dispersion principle (first and second letter)
     * Example file.tyt => f/i/file.txt
     * @param $fileName
     * @return string
     */
    public function getFileDispersionPath($fileName)
    {
        return \Magento\MediaStorage\Model\File\Uploader::getDispretionPath($fileName);
    }

    /**
     * Delete the file in the folder media folder of product attachment
     * @param $fileName filename that will be used to generate the full abosulte path (dispersion)
     */
    public function deleteFile($filepathInMediaFolder)
    {
        $exts = explode('.', $filepathInMediaFolder);
        $ext = "";
        if(count($exts)){
            $ext = $exts[count($exts)-1];
        }
        if( in_array($ext, $this->getAllowedExt()) &&
            strpos($filepathInMediaFolder,"..") === false ) {
            $finalPath = $this->getProductAttachMediaFolderAbsolutePath()."/".$filepathInMediaFolder;
            if(file_exists($finalPath)){
                unlink($finalPath);
            }
        }
    }

    /**
     * Return the media folder absolute path
     * @return string
     */
    private function getProductAttachMediaFolderAbsolutePath()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $fileSystem = $objectManager->create('\Magento\Framework\Filesystem');
        $mediaPath = $fileSystem->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA)->getAbsolutePath();
        return $mediaPath . self::MEDIA_PATH;
    }

    /**
     * Return the dispersion folder absoluite path for the given filename
     * @param $filename
     * @return string
     */
    public function getDispersionFolderAbsolutePath($filename)
    {
        return $this->getProductAttachMediaFolderAbsolutePath()."/".$this->getFileDispersionPath($filename);
    }
    
    /**
     * Return the allowed file extensions
     * @return array
     */
    public function getAllowedExt()
    {
        return ['pdf','pptx', 'xls', 'xlsx', 'flash', 'mp3', 'docx', 'doc', 'zip', 'jpg', 'jpeg', 'png', 'gif', 'ini', 'readme', 'avi', 'csv', 'txt', 'wma', 'mpg', 'flv'];
    }

    /**
     * Return mediaurl
     * @return string
     */
    public function getMediaUrl()
    {
        $mediaUrl = $this->storeManager-> getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA );
        return $mediaUrl;
    }

    /**
     * Retrive file size by attachment
     *
     * @return number
     */
    public function getFileSize($file)
    {
        $fileSize = $this->mediaDirectory->stat($file)['size'];
        $readableSize = $this->convertToReadableSize($fileSize);
        return $readableSize;
    }

    /**
     * Convert size into readable format
     */
    public function convertToReadableSize($size)
    {
        $base = log($size) / log(1024);
        $suffix = ["", " KB", " MB", " GB", " TB"];
        $f_base = floor($base);
        return round(pow(1024, $base - floor($base)), 1) . $suffix[$f_base];
    }

}
