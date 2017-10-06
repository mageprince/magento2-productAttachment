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
    private $productattachCollection = null;
    
    /**
     * Productattach factory
     *
     * @var Prince\Productattach\Model\ProductattachFactory
     */
    private $productattachCollectionFactory;
    
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
     * @param \Magento\Framework\ObjectManagerInterface $objectmanager
     * @param \Prince\Productattach\Helper\Data $dataHelper
     * @param \Magento\Framework\Registry $registry
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        \Prince\Productattach\Model\ResourceModel\Productattach\CollectionFactory $productattachCollectionFactory,
        \Magento\Framework\ObjectManagerInterface $objectmanager,
        \Prince\Productattach\Helper\Data $dataHelper,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        $this->customerSession =$customerSession;
        $this->productattachCollectionFactory = $productattachCollectionFactory;
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
        $collection->getSelect()->where("store LIKE '%".$this->dataHelper->getStoreId()."%'");
        $collection->getSelect()->where("customer_group LIKE '%".$this->getCustomerId()."%'");
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
        $url = $this->dataHelper->getBaseUrl().'/'.$attachment;
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
            $iconImage = $this->getViewFileUrl('Prince_Productattach::images/'.$fileExt.'.png');
        } else {
            $iconImage = $this->getViewFileUrl('Prince_Productattach::images/unknown.png');
        }
        return $iconImage;
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
        $suffix = ["", " KB", " MB", " GB", " TB"];
        $f_base = floor($base);
        return round(pow(1024, $base - floor($base)), 1) . $suffix[$f_base];
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
