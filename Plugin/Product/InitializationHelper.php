<?php
/**
 * @author Convert Team
 * @copyright Copyright (c) 2018 Convert (http://www.convert.no/)
 */
namespace Prince\Productattach\Plugin\Product;

class InitializationHelper
{
    /**
     * @var \Prince\Productattach\Model\ProductattachFactory
     */
    protected $attachmentFactory;

    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    protected $request;

    /**
     * @param \Prince\Productattach\Model\ProductattachFactory $attachmentFactory
     * @param \Magento\Framework\App\RequestInterface $request
     */
    public function __construct(
        \Prince\Productattach\Model\ProductattachFactory $attachmentFactory,
        \Magento\Framework\App\RequestInterface $request
    ) {
        $this->attachmentFactory = $attachmentFactory;
        $this->request = $request;
    }

    /**
     * Prepare product to save
     *
     * @param \Magento\Catalog\Controller\Adminhtml\Product\Initialization\Helper $subject
     * @param \Magento\Catalog\Model\Product $product
     * @return \Magento\Catalog\Model\Product
     */
    public function afterInitialize(
        \Magento\Catalog\Controller\Adminhtml\Product\Initialization\Helper $subject,
        \Magento\Catalog\Model\Product $product
    ) {
        $rows = $this->request->getPost('magecomp_attachments') ?: [];

        $extension = $product->getExtensionAttributes();

        $attachments = [];
        foreach ($rows as $row) {
            if (!empty($row['id'])) {
                /** @var \Prince\Productattach\Model\Productattach $attachment */
                $attachment = $this->attachmentFactory->create();
                $attachment->addData($row);
                $attachment->setId($row['id']);
                $attachments[] = $attachment;
            }
        }
        $extension->setMagecompAttachments($attachments);

        $product->setExtensionAttributes($extension);

        return $product;
    }
}
