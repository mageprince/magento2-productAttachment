<?php

namespace Prince\Productattach\Controller\AbstractController;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Registry;

class ProductattachLoader implements ProductattachLoaderInterface
{
    /**
     * @var \Prince\Productattach\Model\ProductattachFactory
     */
    private $productattachFactory;

    /**
     * @var \Magento\Framework\Registry
     */
    private $registry;

    /**
     * @var \Magento\Framework\UrlInterface
     */
    private $url;

    /**
     * @param \Prince\Productattach\Model\ProductattachFactory $productattachFactory
     * @param OrderViewAuthorizationInterface $orderAuthorization
     * @param Registry $registry
     * @param \Magento\Framework\UrlInterface $url
     */
    public function __construct(
        \Prince\Productattach\Model\ProductattachFactory $productattachFactory,
        Registry $registry,
        \Magento\Framework\UrlInterface $url
    ) {
        $this->productattachFactory = $productattachFactory;
        $this->registry = $registry;
        $this->url = $url;
    }

    /**
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return bool
     */
    public function load(RequestInterface $request, ResponseInterface $response)
    {
        $id = (int)$request->getParam('id');
        if (!$id) {
            $request->initForward();
            $request->setActionName('noroute');
            $request->setDispatched(false);
            return false;
        }

        $productattach = $this->productattachFactory->create()->load($id);
        $this->registry->register('current_productattach', $productattach);
        return true;
    }
}
