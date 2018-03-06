<?php

namespace Prince\Productattach\Api\Data;

interface FileiconSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * Get productattach list.
     * @return \Prince\Productattach\Api\Data\FileiconInterface[]
     */
    public function getItems();

    /**
     * Set test list.
     * @param \Prince\Productattach\Api\Data\FileiconInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}