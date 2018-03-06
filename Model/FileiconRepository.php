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

namespace Prince\Productattach\Model;

use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotSaveException;
use Prince\Productattach\Model\ResourceModel\Fileicon as ResourceFileicon;
use Magento\Framework\Reflection\DataObjectProcessor;
use Prince\Productattach\Api\Data\FileiconSearchResultsInterfaceFactory;
use Prince\Productattach\Model\ResourceModel\Fileicon\CollectionFactory as FileiconCollectionFactory;
use Magento\Framework\Api\SortOrder;
use Prince\Productattach\Api\FileiconRepositoryInterface;
use Prince\Productattach\Api\Data\FileiconInterfaceFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Api\DataObjectHelper;

class FileiconRepository implements fileiconRepositoryInterface
{

    private $storeManager;

    protected $dataObjectProcessor;

    protected $dataObjectHelper;

    protected $searchResultsFactory;

    protected $resource;

    protected $fileiconCollectionFactory;

    protected $fileiconFactory;

    protected $dataFileiconFactory;


    /**
     * @param ResourceFileicon $resource
     * @param FileiconFactory $fileiconFactory
     * @param FileiconInterfaceFactory $dataFileiconFactory
     * @param FileiconCollectionFactory $fileiconCollectionFactory
     * @param FileiconSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        ResourceFileicon $resource,
        FileiconFactory $fileiconFactory,
        FileiconInterfaceFactory $dataFileiconFactory,
        FileiconCollectionFactory $fileiconCollectionFactory,
        FileiconSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager
    ) {
        $this->resource = $resource;
        $this->fileiconFactory = $fileiconFactory;
        $this->fileiconCollectionFactory = $fileiconCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataFileiconFactory = $dataFileiconFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
    }

    /**
     * {@inheritdoc}
     */
    public function save(
        \Prince\Productattach\Api\Data\FileiconInterface $fileicon
    ) {
        /* if (empty($fileicon->getStoreId())) {
            $storeId = $this->storeManager->getStore()->getId();
            $fileicon->setStoreId($storeId);
        } */
        try {
            $fileicon->getResource()->save($fileicon);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the fileicon: %1',
                $exception->getMessage()
            ));
        }
        return $fileicon;
    }

    /**
     * {@inheritdoc}
     */
    public function getById($fileiconId)
    {
        $fileicon = $this->fileiconFactory->create();
        $fileicon->getResource()->load($fileicon, $fileiconId);
        if (!$fileicon->getId()) {
            throw new NoSuchEntityException(__('Fileicon with id "%1" does not exist.', $fileiconId));
        }
        return $fileicon;
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->fileiconCollectionFactory->create();
        foreach ($criteria->getFilterGroups() as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                if ($filter->getField() === 'store_id') {
                    $collection->addStoreFilter($filter->getValue(), false);
                    continue;
                }
                $condition = $filter->getConditionType() ?: 'eq';
                $collection->addFieldToFilter($filter->getField(), [$condition => $filter->getValue()]);
            }
        }
        
        $sortOrders = $criteria->getSortOrders();
        if ($sortOrders) {
            /** @var SortOrder $sortOrder */
            foreach ($sortOrders as $sortOrder) {
                $collection->addOrder(
                    $sortOrder->getField(),
                    ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        }
        $collection->setCurPage($criteria->getCurrentPage());
        $collection->setPageSize($criteria->getPageSize());
        
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setTotalCount($collection->getSize());
        $searchResults->setItems($collection->getItems());
        return $searchResults;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(
        \Prince\Productattach\Api\Data\FileiconInterface $fileicon
    ) {
        try {
            $fileicon->getResource()->delete($fileicon);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the Fileicon: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($fileiconId)
    {
        return $this->delete($this->getById($fileiconId));
    }
}
