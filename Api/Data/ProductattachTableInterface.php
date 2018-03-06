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