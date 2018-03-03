<?php


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
