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

    /**
     * @var \Magento\Framework\View\Asset\Repository
     */
    protected $_assetRepo;
    
    /**
     * @var \Prince\Productattach\Helper\Data
     */
    protected $_dataHelper;


    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param Image $imageHelper
     * @param UrlInterface $urlBuilder
     * @param StoreManagerInterface $storeManager
     * @param \Magento\Framework\View\Asset\Repository $assetRepo
     * @param \Prince\Productattach\Helper\Data $dataHelper
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
            $fieldName = $this->getData('name');
            foreach($dataSource['data']['items'] as & $item) {
                $file = $item['file'];
                $fileExt = pathinfo($file, PATHINFO_EXTENSION);
                $url = '';
                
                if($item[$fieldName] != '') {
                    if($fileExt){
                        $url = $this->_assetRepo->getUrl('Prince_Productattach::images/'.$fileExt.'.png');
                    }else{
                        $url = $this->_assetRepo->getUrl('Prince_Productattach::images/unknown.png');
                    }
                }

                $item[$fieldName . '_src'] = $url;
                $item[$fieldName . '_alt'] = $item['name'];
                $item[$fieldName . '_link'] = $this->_dataHelper->getBaseUrl().'/'.$file;
                $item[$fieldName . '_orig_src'] = $url;
            }
        }
        return $dataSource;
    }
}
