<?php

namespace Prince\Productattach\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Prince\Productattach\Helper\Data;

class Save extends \Magento\Backend\App\Action
{
    /**
     * @var PostDataProcessor
     */
    protected $dataProcessor;

    /**
     * @var Data
     */
    protected $helper;

    /**
     * @param Action\Context $context
     * @param PostDataProcessor $dataProcessor
     */
    public function __construct(Action\Context $context, PostDataProcessor $dataProcessor, Data $helper)
    {
        $this->dataProcessor = $dataProcessor;
        $this->helper = $helper;
        parent::__construct($context);
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Prince_Productattach::save');
    }

    /**
     * Save action
     *
     * @return void
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            $data = $this->dataProcessor->filter($data);
            $customerGroup = $this->helper->getCustomerGroup($data['customer_group']);
            $store = $this->helper->getStores($data['store']);
            $data['customer_group'] = $customerGroup;
            $data['store'] = $store;
            $model = $this->_objectManager->create('Prince\Productattach\Model\Productattach');
            $id = $this->getRequest()->getParam('productattach_id');
            
            if ($id) {
                $model->load($id);
            }
            
            $model->addData($data);

            if (!$this->dataProcessor->validate($data)) {
                $this->_redirect('*/*/edit', ['productattach_id' => $model->getId(), '_current' => true]);
                return;
            }

            try {
                
                if (isset($_FILES['file']) && $_FILES['file']['name'] != '') {
                    $imageFile = $this->helper->uploadFile('file');
                    $model->setFile($imageFile);
                }
                
                $model->save();
                $this->messageManager->addSuccess(__('Attachment has been saved.'));
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', ['productattach_id' => $model->getId(), '_current' => true]);
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (\Magento\Framework\Model\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the attachment.'));
            }

            $this->_getSession()->setFormData($data);
            $this->_redirect('*/*/edit', ['productattach_id' => $this->getRequest()->getParam('productattach_id')]);
            return;
        }
        $this->_redirect('*/*/');
    }
}
