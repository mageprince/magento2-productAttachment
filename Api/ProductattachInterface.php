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

namespace Prince\Productattach\Api;

interface ProductattachInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getDescription();

    /**
     * @return string
     */
    public function getFile();

    /**
     * @return string
     */
    public function getFileExt();

    /**
     * @return string
     */
    public function getUrl();

    /**
     * @return int
     */
    public function getActive();

    /**
     * @return string
     */
    public function getCreatedAt();

    /**
     * @return string
     */
    public function getPublishedAt();

    /**
     * Retrieve existing extension attributes object or create a new one.
     *
     * @return \Prince\Productattach\Api\Data\ExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     *
     * @param \Prince\Productattach\Api\Data\ExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(\Prince\Productattach\Api\Data\ExtensionInterface $extensionAttributes);

}
