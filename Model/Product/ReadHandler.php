<?php
/**
 * @author Convert Team
 * @copyright Copyright (c) 2018 Convert (http://www.convert.no/)
 */
namespace Prince\Productattach\Model\Product;

use Prince\Productattach\Model\AttachmentRepository;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Framework\EntityManager\Operation\ExtensionInterface;

/**
 * Class ReadHandler
 */
class ReadHandler implements ExtensionInterface
{
    /**
     * @var AttachmentRepository
     */
    protected $attachmentRepository;

    /**
     * @param AttachmentRepository $attachmentRepository
     */
    public function __construct(AttachmentRepository $attachmentRepository)
    {
        $this->attachmentRepository = $attachmentRepository;
    }

    /**
     * @param ProductInterface $entity
     * @param array $arguments
     * @return ProductInterface
     */
    public function execute($entity, $arguments = [])
    {
        $entityExtension = $entity->getExtensionAttributes();
        $attachments = $this->attachmentRepository->getByProduct($entity);
        if ($attachments) {
            $entityExtension->setPrinceAttachment($attachments);
        }
        $entity->setExtensionAttributes($entityExtension);
        return $entity;
    }
}
