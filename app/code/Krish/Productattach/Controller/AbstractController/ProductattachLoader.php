<?php

namespace Krish\Productattach\Controller\AbstractController;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Registry;

class ProductattachLoader implements ProductattachLoaderInterface
{
    /**
     * @var \Krish\Productattach\Model\ProductattachFactory
     */
    protected $productattachFactory;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $registry;

    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $url;

    /**
     * @param \Krish\Productattach\Model\ProductattachFactory $productattachFactory
     * @param OrderViewAuthorizationInterface $orderAuthorization
     * @param Registry $registry
     * @param \Magento\Framework\UrlInterface $url
     */
    public function __construct(
        \Krish\Productattach\Model\ProductattachFactory $productattachFactory,
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
