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
 * Class UpdateHandler
 */
class UpdateHandler implements ExtensionInterface
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
     * @throws \Exception
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute($entity, $arguments = [])
    {
        $attachments = [];
        foreach ((array)$entity->getExtensionAttributes()->getPrinceAttachment() as $attachment) {
            $attachments[$attachment->getId()] = $attachment;
        }

        $oldAttachments = [];
        foreach ($this->attachmentRepository->getByProduct($entity) as $attachment) {
            $oldAttachments[$attachment->getId()] = $attachment;
        }

        $added = array_diff_key($attachments, $oldAttachments);
        $deleted = array_diff_key($oldAttachments, $attachments);

        foreach ($added as $attachment) {
            $this->attachmentRepository->addProductToAttachment($entity, $attachment);
        }
        foreach ($deleted as $attachment) {
            $this->attachmentRepository->removeProductFromAttachment($entity, $attachment);
        }

        return $entity;
    }
}
