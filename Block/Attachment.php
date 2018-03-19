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

namespace Prince\Productattach\Block;

/**
 * Class Attachment
 * @package Prince\Productattach\Block
 */
class Attachment extends \Magento\Framework\View\Element\Template
{
    /**
     * Productattach collection
     *
     * @var Prince\Productattach\Model\ResourceModel\Productattach\Collection
     */
    private $productattachCollection = null;
    
    /**
     * Productattach factory
     *
     * @var Prince\Productattach\Model\ProductattachFactory
     */
    private $productattachCollectionFactory;

    /**
     * Fileicon factory
     *
     * @var Prince\Productattach\Model\FileiconFactory
     */
    private $fileiconCollectionFactory;
    
    /**
     * @var Prince\Productattach\Helper\Data
     */
    private $dataHelper;

    /**
     * @var Magento\Framework\ObjectManagerInterface
     */
    private $objectManager;

    /**
     * @var Magento\Customer\Model\Session
     */
    private $customerSession;

    /**
     * @var Magento\Framework\App\Config\ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var Magento\Framework\Registry
     */
    private $registry;
    
    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Prince\Productattach\Model\ResourceModel\Productattach\CollectionFactory $productattachCollectionFactory
     * @param \Prince\Productattach\Model\ResourceModel\Fileicon\CollectionFactory $fileiconCollectionFactory
     * @param \Magento\Framework\ObjectManagerInterface $objectmanager
     * @param \Prince\Productattach\Helper\Data $dataHelper
     * @param \Magento\Framework\Registry $registry
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        \Prince\Productattach\Model\ResourceModel\Productattach\CollectionFactory $productattachCollectionFactory,
        \Prince\Productattach\Model\ResourceModel\Fileicon\CollectionFactory $fileiconCollectionFactory,
        \Magento\Framework\ObjectManagerInterface $objectmanager,
        \Prince\Productattach\Helper\Data $dataHelper,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        $this->customerSession =$customerSession;
        $this->productattachCollectionFactory = $productattachCollectionFactory;
        $this->fileiconCollectionFactory = $fileiconCollectionFactory;
        $this->objectManager = $objectmanager;
        $this->dataHelper = $dataHelper;
        $this->scopeConfig = $context->getScopeConfig();
        $this->registry = $registry;
        parent::__construct(
            $context,
            $data
        );
    }
    
    /**
     * Check module is enable or not
     */
    public function isEnable()
    {
        return $this->getConfig('productattach/general/enable');
    }

    /**
     * Retrieve productattach collection
     *
     * @return Prince\Productattach\Model\ResourceModel\Productattach\Collection
     */
    public function getCollection()
    {
        $collection = $this->productattachCollectionFactory->create();
        return $collection;
    }
    
    /**
     * Filter productattach collection by product Id
     *
     * @return collection
     */
    public function getAttachment($productId)
    {
        $collection = $this->getCollection();
        
        $collection->addFieldToFilter(
            'customer_group',
            [
                ['null' => true],
                ['finset' => $this->getCustomerId()]
            ]
        );
        $collection->addFieldToFilter(
            'store',
            [
                ['eq' => 0],
                ['finset' => $this->dataHelper->getStoreId()]
            ]
        );

        $collection->getSelect()->where("products REGEXP '[[:<:]]".$productId."[[:>:]]'");
        
        return $collection;
    }

    /**
     * Retrive attachment url by attachment
     *
     * @return string
     */
    public function getAttachmentUrl($attachment)
    {
        $url = $this->dataHelper->getBaseUrl().$attachment;
        return $url;
    }

    /**
     * Retrive current product id
     *
     * @return number
     */
    public function getCurrentId()
    {
        $product = $this->registry->registry('current_product');
        return $product->getId();
    }

    /**
     * Retrive current customer id
     *
     * @return number
     */
    public function getCustomerId()
    {
        $customerId = $this->customerSession->getCustomer()->getGroupId();
        return $customerId;
    }

    /**
     * Retrive file icon image
     *
     * @return string
     */
    public function getFileIcon($fileExt)
    {
        if ($fileExt) {
            $iconExt = $this->getIconExt($fileExt);
            if($iconExt) {
                $mediaUrl = $this->dataHelper->getMediaUrl();
                $iconImage = $mediaUrl.'fileicon/tmp/icon/'.$iconExt;
            } else {
                $iconImage = $this->getViewFileUrl('Prince_Productattach::images/'.$fileExt.'.png');
            } 
        } else {
            $iconImage = $this->getViewFileUrl('Prince_Productattach::images/unknown.png');
        }
        return $iconImage;
    }

    /**
     * Retrive icon ext name
     *
     * @return string
     */
    public function getIconExt($fileExt)
    {
        $iconCollection = $this->fileiconCollectionFactory->create();
        $iconCollection->addFieldToFilter('icon_ext',$fileExt);
        $icon = $iconCollection->getFirstItem()->getIconImage();
        return $icon;
    }

    /**
     * Retrive link icon image
     *
     * @return string
     */
    public function getLinkIcon()
    {
        $iconImage = $this->getViewFileUrl('Prince_Productattach::images/link.png');
        return $iconImage;
    }

    /**
     * Retrive file size by attachment
     *
     * @return number
     */
    public function getFileSize($attachment)
    {
        $attachmentPath = \Prince\Productattach\Helper\Data::MEDIA_PATH.$attachment;
        $fileSize = $this->dataHelper->getFileSize($attachmentPath);
        return $fileSize;
    }

    /**
     * Retrive config value
     */
    public function getConfig($config)
    {
        return $this->scopeConfig->getValue(
            $config,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Retrive Tab Name
     */
    public function getTabName()
    {
        $tabName = __($this->getConfig('productattach/general/tabname'));
        return $tabName;
    }
}
