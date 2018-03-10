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
 * Class DeleteHandler
 */
class DeleteHandler implements ExtensionInterface
{
    /**
     * @var AttachmentRepository
     */
    protected $attachmentRepository;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * @param AttachmentRepository $attachmentRepository
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(AttachmentRepository $attachmentRepository, \Psr\Log\LoggerInterface $logger)
    {
        $this->attachmentRepository = $attachmentRepository;
        $this->logger = $logger;
    }

    /**
     * @param ProductInterface $entity
     * @param array $arguments
     * @return ProductInterface
     */
    public function execute($entity, $arguments = [])
    {
        $attachments = $this->attachmentRepository->getByProduct($entity);
        foreach ($attachments as $attachment) {
            try {
                $this->attachmentRepository->removeProductFromAttachment($entity, $attachment);
            } catch (\Exception $e) {
                // not a problem, deleting product anyway
                $this->logger->error($e);
            }
        }

        return $entity;
    }
}
