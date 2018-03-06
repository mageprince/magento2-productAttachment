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

use Magento\Framework\Api\SearchCriteriaInterface;

interface FileiconRepositoryInterface
{


    /**
     * Save Fileicon
     * @param \Prince\Productattach\Api\Data\FileiconInterface $fileicon
     * @return \Prince\Productattach\Api\Data\FileiconInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Prince\Productattach\Api\Data\FileiconInterface $fileicon
    );

    /**
     * Retrieve Fileicon
     * @param string $fileiconId
     * @return \Prince\Productattach\Api\Data\FileiconInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($fileiconId);

    /**
     * Retrieve Fileicon matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Prince\Productattach\Api\Data\FileiconSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete Fileicon
     * @param \Prince\Productattach\Api\Data\FileiconInterface $fileicon
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Prince\Productattach\Api\Data\FileiconInterface $fileicon
    );

    /**
     * Delete Fileicon by ID
     * @param string $fileiconId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($fileiconId);
}
