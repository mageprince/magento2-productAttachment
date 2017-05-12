<?php
namespace Prince\Productattach\Ui\Component\Listing\Column;

use Magento\Catalog\Helper\Image;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\Component\Listing\Columns\Column;

class FileIcon extends Column
{
    const ALT_FIELD = 'file';

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    protected $_assetRepo;
    
    protected $_dataHelper;


    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param Image $imageHelper
     * @param UrlInterface $urlBuilder
     * @param StoreManagerInterface $storeManager
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        Image $imageHelper,
        UrlInterface $urlBuilder,
        StoreManagerInterface $storeManager,
        \Magento\Framework\View\Asset\Repository $assetRepo,
         \Prince\Productattach\Helper\Data $dataHelper,
        array $components = [],
        array $data = []
    ) {
        $this->storeManager = $storeManager;
        $this->imageHelper = $imageHelper;
        $this->urlBuilder = $urlBuilder;
        $this->_dataHelper = $dataHelper;
         $this->_assetRepo = $assetRepo;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if(isset($dataSource['data']['items'])) {
            //echo "<pre>";
            //print_r($dataSource); exit;
            $fieldName = $this->getData('name');
            //exit;
            foreach($dataSource['data']['items'] as & $item) {
                $file = $item['file'];
                $fileExt = pathinfo($file, PATHINFO_EXTENSION);

                // if($fileExt){
                //     $iconImage = $this->_assetRepo->getUrl('Prince_Productattach::images/'.$fileExt.'.png');
                //     $fileIcon = "<a href=".$this->_dataHelper->getBaseUrl().'/'.$file." target='_blank'><img src='".$iconImage."' /></a>";
                // }else{
                //     $iconImage = $this->_assetRepo->getUrl('Prince_Productattach::images/unknown.png');
                //     $fileIcon = "<img src='".$iconImage."' />";
                // }



                $url = '';
                if($item[$fieldName] != '') {
                    if($fileExt){
                        $url = $this->_assetRepo->getUrl('Prince_Productattach::images/'.$fileExt.'.png');
                    }else{
                        $url = $this->_assetRepo->getUrl('Prince_Productattach::images/unknown.png');
                    }
                    // $url = $this->storeManager->getStore()->getBaseUrl(
                    //     \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
                    // ).'productattach/'.$item[$fieldName];
                    
                }
                $item[$fieldName . '_src'] = $url;
                $item[$fieldName . '_alt'] = $item['name'];
                //$item[$fieldName . '_link'] = $this->urlBuilder->getUrl(
                  //  'book_flip/flip/edit',
                   // ['productattach_id' => $item['productattach_id']]
                //);

                $item[$fieldName . '_link'] = $this->_dataHelper->getBaseUrl().'/'.$file;


                $item[$fieldName . '_orig_src'] = $url;
            }
        }

        return $dataSource;
    }
}