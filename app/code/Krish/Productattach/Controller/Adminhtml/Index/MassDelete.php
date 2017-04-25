<?php
namespace Krish\Productattach\Controller\Adminhtml\Index;

class MassDelete extends \Magento\Backend\App\Action {

    protected $_filter;

    protected $_collectionFactory;
    
    public function __construct(
        \Magento\Ui\Component\MassAction\Filter $filter,
        \Krish\Productattach\Model\ResourceModel\Productattach\CollectionFactory $collectionFactory,
        \Magento\Backend\App\Action\Context $context
        ) {
        $this->_filter            = $filter;
        $this->_collectionFactory = $collectionFactory;
        parent::__construct($context);
    }

    public function execute() {
        try{ 

            //  print_r($this->_collectionFactory->create()->getData()); exit;
            $logCollection = $this->_filter->getCollection($this->_collectionFactory->create());

            $itemsDeleted = 0;
            foreach ($logCollection as $item) {
                $item->delete();
                $itemsDeleted++;
            }
            $this->messageManager->addSuccess(__('A total of %1 Attachment(s) were deleted.', $itemsDeleted));
        }catch(Exception $e){
            $this->messageManager->addError($e->getMessage());
        }
        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('productattach/index');
    }
}