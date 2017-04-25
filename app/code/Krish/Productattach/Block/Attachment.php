<?php

namespace Krish\Productattach\Block;

/**
 * Productattach content block
 */
class Attachment extends \Magento\Framework\View\Element\Template
{
    /**
     * Productattach collection
     *
     * @var Krish\Productattach\Model\ResourceModel\Productattach\Collection
     */
    protected $_productattachCollection = null;
    
    /**
     * Productattach factory
     *
     * @var \Krish\Productattach\Model\ProductattachFactory
     */
    protected $_productattachCollectionFactory;
    
    /** @var \Krish\Productattach\Helper\Data */
    protected $_dataHelper;

    protected $_objectManager;

    protected $_customerSession;


    
    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Krish\Productattach\Model\ResourceModel\Productattach\CollectionFactory $productattachCollectionFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        \Krish\Productattach\Model\ResourceModel\Productattach\CollectionFactory $productattachCollectionFactory,
        \Magento\Framework\ObjectManagerInterface $objectmanager,
        \Krish\Productattach\Helper\Data $dataHelper,
        array $data = []
    ) {
        $this->_productattachCollectionFactory = $productattachCollectionFactory;
        $this->_objectManager = $objectmanager;
        $this->_customerSession =$customerSession;
        $this->_dataHelper = $dataHelper;
        parent::__construct(
            $context,
            $data
        );
    }
    
    /**
     * Retrieve productattach collection
     *
     * @return Krish\Productattach\Model\ResourceModel\Productattach\Collection
     */
    protected function getCollection()
    {
        $collection = $this->_productattachCollectionFactory->create();
        return $collection;
    }
    
    public function getAttachment($productId)
    {
        $collection = $this->getCollection();

        //echo "<pre>";
        //print_r($collection->getData()); exit;
        //$collection->getSelect()->where( " FIND_IN_SET('".$this->_dataHelper->getStoreId()."',store) " );
        //$collection->getSelect()->where( " FIND_IN_SET('".$this->getCustomerId()."',customer_group) " );
        //$collection->getSelect()->where( " FIND_IN_SET('".$productId."',products) " );
        $collection->getSelect()->where( " store LIKE '%".$this->_dataHelper->getStoreId()."%' " );
        $collection->getSelect()->where( " customer_group LIKE '%".$this->getCustomerId()."%' " );
        $collection->getSelect()->where( " products LIKE '%".$productId."%' " );
        
        return $collection;
    }

    public function getAttachmentUrl($attachment)
    {
        $url = $this->_dataHelper->getBaseUrl().'/'.$attachment;
        return $url;
    }

    public function getCurrentId()
    {
        $product = $this->_objectManager->get('Magento\Framework\Registry')->registry('current_product');
        return $product->getId();
    }

    public function getCustomerId()
    {
        $customerId = $this->_customerSession->getCustomer()->getGroupId();
        return $customerId;
    }

    public function getFileIcon($attachment)
    {
        $fileExt = pathinfo($attachment, PATHINFO_EXTENSION);
        if($fileExt){
            $iconImage = $this->getViewFileUrl('Krish_Productattach::images/'.$fileExt.'.png');
        }else{
            $iconImage = $this->getViewFileUrl('Krish_Productattach::images/unknown.png');
        }
        $fileIcon = "<img src='".$iconImage."' />";
        return $fileIcon;
    }

    public function getFileSize($attachment)
    {
        $url = $this->getAttachmentUrl($attachment);
        $fileSize = $this->convertToReadableSize($this->remoteFileSize($url));
        return $fileSize;
    }

    function remoteFileSize($url)
    {
        $data = get_headers($url, true);
        if (isset($data['Content-Length']))
            return (int) $data['Content-Length'];
    }

    function convertToReadableSize($size)
    {
      $base = log($size) / log(1024);
      $suffix = array("", "KB", "MB", "GB", "TB");
      $f_base = floor($base);
      return round(pow(1024, $base - floor($base)), 1) . $suffix[$f_base];
    }

}
