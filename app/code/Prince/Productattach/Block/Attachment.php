<?php

namespace Prince\Productattach\Block;

/**
 * Productattach content block
 */
class Attachment extends \Magento\Framework\View\Element\Template
{
    /**
     * Productattach collection
     *
     * @var Prince\Productattach\Model\ResourceModel\Productattach\Collection
     */
    protected $_productattachCollection = null;
    
    /**
     * Productattach factory
     *
     * @var \Prince\Productattach\Model\ProductattachFactory
     */
    protected $_productattachCollectionFactory;
    
    /**
     * @var \Prince\Productattach\Helper\Data
     */
    protected $_dataHelper;

    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $_objectManager;

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $_customerSession;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_scopeConfig;
    
    /** 
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Prince\Productattach\Model\ResourceModel\Productattach\CollectionFactory $productattachCollectionFactory
     * @param \Magento\Framework\ObjectManagerInterface $objectmanager
     * @param \Prince\Productattach\Helper\Data $dataHelper
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        \Prince\Productattach\Model\ResourceModel\Productattach\CollectionFactory $productattachCollectionFactory,
        \Magento\Framework\ObjectManagerInterface $objectmanager,
        \Prince\Productattach\Helper\Data $dataHelper,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        array $data = []
    ) {
        $this->_customerSession =$customerSession;
        $this->_productattachCollectionFactory = $productattachCollectionFactory;
        $this->_objectManager = $objectmanager;
        $this->_dataHelper = $dataHelper;
        $this->_scopeConfig = $scopeConfig;
        parent::__construct(
            $context,
            $data
        );
    }
    
    /**
     * Retrieve productattach collection
     *
     * @return Prince\Productattach\Model\ResourceModel\Productattach\Collection
     */
    protected function getCollection()
    {
        $collection = $this->_productattachCollectionFactory->create();
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
        $collection->getSelect()->where("store LIKE '%".$this->_dataHelper->getStoreId()."%'");
        $collection->getSelect()->where("customer_group LIKE '%".$this->getCustomerId()."%'");
        $collection->getSelect()->where("products LIKE '%".$productId."%'");
        return $collection;
    }

    /**
     * Retrive attachment url by attachment
     *
     * @return string
     */
    public function getAttachmentUrl($attachment)
    {
        $url = $this->_dataHelper->getBaseUrl().'/'.$attachment;
        return $url;
    }

    /**
     * Retrive current product id
     *
     * @return number
     */
    public function getCurrentId()
    {
        $product = $this->_objectManager->get('Magento\Framework\Registry')->registry('current_product');
        return $product->getId();
    }

    /**
     * Retrive current customer id
     *
     * @return number
     */
    public function getCustomerId()
    {
        $customerId = $this->_customerSession->getCustomer()->getGroupId();
        return $customerId;
    }

    /**
     * Retrive file icon image
     *
     * @return string
     */
    public function getFileIcon($attachment)
    {
        $fileExt = pathinfo($attachment, PATHINFO_EXTENSION);
        if($fileExt){
            $iconImage = $this->getViewFileUrl('Prince_Productattach::images/'.$fileExt.'.png');
        }else{
            $iconImage = $this->getViewFileUrl('Prince_Productattach::images/unknown.png');
        }
        $fileIcon = "<img src='".$iconImage."' />";
        return $fileIcon;
    }

    /**
     * Retrive file size by attachment
     *
     * @return number
     */
    public function getFileSize($attachment)
    {
        $url = $this->getAttachmentUrl($attachment);
        $fileSize = $this->convertToReadableSize($this->remoteFileSize($url));
        return $fileSize;
    }

    /**
     * Retrive file size by url
     *
     * @return number
     */
    public function remoteFileSize($url)
    {
        $data = get_headers($url, true);
        if (isset($data['Content-Length']))
            return (int) $data['Content-Length'];
    }

    /**
     * Convert size into redable format
     */
    public function convertToReadableSize($size)
    {
      $base = log($size) / log(1024);
      $suffix = array("", "KB", "MB", "GB", "TB");
      $f_base = floor($base);
      return round(pow(1024, $base - floor($base)), 1) . $suffix[$f_base];
    }

    /**
     * Retrive config value
     */
    public function getConfig($config)
    {
        return $this->_scopeConfig->getValue(
            $config, 
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }


}
