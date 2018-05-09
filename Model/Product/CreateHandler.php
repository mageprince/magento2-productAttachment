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
 * Class CreateHandler
 */
class CreateHandler implements ExtensionInterface
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
        /** @var \Prince\Productattach\Model\Productattach[] $attachments */
        $attachments = $entity->getExtensionAttributes()->getPrinceAttachment() ?: [];
        foreach ($attachments as $attachment) {
            $this->attachmentRepository->addProductToAttachment($entity, $attachment);
        }
        
        return $entity;
    }
}
