<?php
namespace Prince\Productattach\Api\Data;
use Magento\Framework\Api;
interface ProductattachTableInterface
{

    /**
     * @return string mixed
     */
    public function getProductAttachId();

    /**
     * @param string $val
     * @return void
     */
    public function setProductAttachId($val);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param  string $val
     * @return void
     */
    public function setName($val);

    /**
     * @return string mixed
     */
    public function getDescription();

    /**
     * @param string $val
     * @return void
     */
    public function setDescription($val);

    /**
     * @return string mixed
     */
    public function getFile();

    /**
     * @param string $val
     * @return void
     */
    public function setFile($val);

    /**
     * @return string mixed
     */
    public function getUrl();

    /**
     * @param string $val
     * @return void
     */
    public function setUrl($val);

    /**
     * @return string mixed
     */
    public function getStore();

    /**
     * @param string $val
     * @return void
     */
    public function setStore($val);

    /**
     * @return string mixed
     */
    public function getCustomerGroup();

    /**
     * @param string $val
     * @return void
     */
    public function setCustomerGroup($val);

    /**
     * @return string mixed
     */
    public function getProducts();

    /**
     * @param string $val
     * @return void
     */
    public function setProducts($val);

    /**
     * @return string mixed
     */
    public function getActive();

    /**
     * @param string $val
     * @return void
     */
    public function setActive($val);
}