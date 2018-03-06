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

interface FileiconInterface
{

    const ICON_IMAGE = 'icon_image';
    const FILEICON_ID = 'fileicon_id';
    const ICON_EXT = 'icon_ext';


    /**
     * Get fileicon_id
     * @return string|null
     */
    public function getFileiconId();

    /**
     * Set fileicon_id
     * @param string $fileicon_id
     * @return \Prince\Productattach\Api\Data\FileiconInterface
     */
    public function setFileiconId($fileiconId);

    /**
     * Get icon_ext
     * @return string|null
     */
    public function getIconExt();

    /**
     * Set icon_ext
     * @param string $icon_ext
     * @return \Prince\Productattach\Api\Data\FileiconInterface
     */
    public function setIconExt($icon_ext);

    /**
     * Get icon_image
     * @return string|null
     */
    public function getIconImage();

    /**
     * Set icon_image
     * @param string $icon_image
     * @return \Prince\Productattach\Api\Data\FileiconInterface
     */
    public function setIconImage($icon_image);
}
