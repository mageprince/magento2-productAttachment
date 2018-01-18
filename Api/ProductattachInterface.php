<?php
namespace Prince\Productattach\Api;
interface ProductattachInterface
{
    /**
     * Update / insert attachment
     * @param \Prince\Productattach\Api\Data\ProductattachTableInterface $productattachTable
     * @param string $filename
     * @param string $fileContent
     * @return int
     */
    public function UpdateInsertAttachment(
        \Prince\Productattach\Api\Data\ProductattachTableInterface $productattachTable,
        $filename,
        $fileContent
    );

    /**
     * Delete the attachment
     * @param int $int
     * @throws NotFoundException
     * @throws \Exception
     * @return bool
     */
    public function DeleteAttachment(
        $int
    );

}