<?php
namespace Prince\Productattach\Model;

/**
 * @method ${
RESOURCENAME
} getResource()
 * @method ${
RESOURCENAME
}\Collection getCollection()
 */
class ProductattachTable extends
    \Magento\Framework\Model\AbstractModel implements
    \Prince\Productattach\Api\Data\ProductattachTableInterface,
    \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'prince_productattach_productattachtable';
    protected $_cacheTag = 'prince_productattach_productattachtable';
    protected $_eventPrefix = 'prince_productattach_productattachtable';

    protected function _construct()
    {
        $this->_init('Prince\Productattach\Model\ResourceModel\Productattach');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * @return string
     */
    public function getProductAttachId()
    {
        return $this->getData("productattach_id");
    }

    /**
     * @param string $val
     * @return void
     */
    public function setProductAttachId($val)
    {
        $this->setData("productattach_id",$val);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->getData("name");
    }

    /**
     * @param  string $val
     * @return void
     */
    public function setName($val)
    {
        $this->setData("name",$val);
    }
    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->getData("description");
    }

    /**
     * @param  string $val
     * @return void
     */
    public function setDescription($val)
    {
        $this->setData("description",$val);
    }

    /**
     * @return string
     */
    public function getFile()
    {
        return $this->getData("file");
    }

    /**
     * @param  string $val
     * @return void
     */
    public function setFile($val)
    {
        $this->setData("file",$val);
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->getData("url");
    }

    /**
     * @param  string $val
     * @return void
     */
    public function setUrl($val)
    {
        $this->setData("url",$val);
    }

    /**
     * @return string
     */
    public function getStore()
    {
        return $this->getData("store");
    }

    /**
     * @param  string $val
     * @return void
     */
    public function setStore($val)
    {
        $this->setData("store",$val);
    }

    /**
     * @return string
     */
    public function getCustomerGroup()
    {
        return $this->getData("customer_group");
    }

    /**
     * @param  string $val
     * @return void
     */
    public function setCustomerGroup($val)
    {
        $this->setData("customer_group",$val);
    }

    /**
     * @return string
     */
    public function getProducts()
    {
        return $this->getData("products");
    }

    /**
     * @param  string $val
     * @return void
     */
    public function setProducts($val)
    {
        $this->setData("products",$val);
    }

    /**
     * @return string
     */
    public function getActive()
    {
        return $this->getData("active");
    }

    /**
     * @param  string $val
     * @return void
     */
    public function setActive($val)
    {
        $this->setData("active",$val);
    }
}