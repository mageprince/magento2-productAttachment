<?php
/**
 * @author Convert Team
 * @copyright Copyright (c) 2018 Convert (http://www.convert.no/)
 */
namespace Prince\Productattach\Model;

use Prince\Productattach\Model\Productattach;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Framework\Exception\NotFoundException;

class AttachmentRepository
{
    /**
     * @var \Prince\Productattach\Model\ProductattachFactory
     */
    protected $attachmentFactory;

    /**
     * @var \Prince\Productattach\Model\ResourceModel\Productattach\CollectionFactory
     */
    protected $collectionFactory;

    /**
     * AttachmentRepository constructor.
     * @param \Prince\Productattach\Model\ProductattachFactory $attachmentFactory
     * @param \Prince\Productattach\Model\ResourceModel\Productattach\CollectionFactory $collectionFactory
     */
    public function __construct(
        \Prince\Productattach\Model\ProductattachFactory $attachmentFactory,
        \Prince\Productattach\Model\ResourceModel\Productattach\CollectionFactory $collectionFactory
    ) {
        $this->attachmentFactory = $attachmentFactory;
        $this->collectionFactory = $collectionFactory;
    }


    /**
     * Loads attachments assigned to product
     *
     * @param ProductInterface $product
     * @return Productattach[]
     */
    public function getByProduct(ProductInterface $product)
    {
        $productId = $product->getId();

        /** @var \Prince\Productattach\Model\ResourceModel\Productattach\Collection $collection */
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter(
            'products',
            [
                ['eq' => $productId],
                ['like' => "$productId&%"],
                ['like' => "%&$productId&%"],
                ['like' => "%&$productId"],
            ]
        );
        return $collection->load()->getItems();
    }

    /**
     * @param ProductInterface $product
     * @param Productattach $attachment
     * @return void
     * @throws NotFoundException
     * @throws \Exception
     */
    public function addProductToAttachment(ProductInterface $product, Productattach $attachment)
    {
        $attachmentId = $attachment->getId();
        $productId = $product->getId();

        /** @var Productattach $attachment */
        $attachment = $this->attachmentFactory->create();
        $attachment->load($attachmentId);
        if (!$attachment->getId()) {
            throw new NotFoundException(__('Attachment not found'));
        }

        $products = $attachment->getData('products');
        $products = explode('&', $products);
        $products = array_filter($products);

        $products[] = $productId;
        $products = array_unique($products);

        $attachment->setProducts(implode('&', $products));

        $attachment->save();
    }

    /**
     * @param ProductInterface $product
     * @param Productattach $attachment
     * @return void
     * @throws NotFoundException
     * @throws \Exception
     */
    public function removeProductFromAttachment(ProductInterface $product, Productattach $attachment)
    {
        $attachmentId = $attachment->getId();
        $productId = $product->getId();

        /** @var Productattach $attachment */
        $attachment = $this->attachmentFactory->create();
        $attachment->load($attachmentId);
        if (!$attachment->getId()) {
            throw new NotFoundException(__('Attachment not found'));
        }

        $products = $attachment->getData('products');
        $products = explode('&', $products);
        $products = array_filter($products);

        $pos = array_search($productId, $products);
        if (false !== $pos) {
            unset($products[$pos]);
        }

        $attachment->setProducts(implode('&', $products));

        $attachment->save();
    }
}
