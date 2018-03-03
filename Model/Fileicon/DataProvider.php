<?php


namespace Prince\Productattach\Model\Fileicon;

use Prince\Productattach\Model\ResourceModel\Fileicon\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Store\Model\StoreManagerInterface;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{

    protected $loadedData;
    protected $collection;

    protected $dataPersistor;


    /**
     * Constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        DataPersistorInterface $dataPersistor,
        StoreManagerInterface $storeManager,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->storeManager = $storeManager;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $model) {
            $this->loadedData[$model->getFileiconId()] = $model->getData();
            if ($model->getIconImage()) {
                $m['icon_image'][0]['name'] = $model->getIconImage();
                $m['icon_image'][0]['url'] = $this->getMediaUrl().$model->getIconImage();
                $fullData = $this->loadedData;
                $this->loadedData[$model->getFileiconId()] = array_merge($fullData[$model->getFileiconId()], $m);
            }
        }
        $data = $this->dataPersistor->get('prince_productattach_fileicon');
        
        if (!empty($data)) {
            $model = $this->collection->getNewEmptyItem();
            $model->setData($data);
            $this->loadedData[$model->getFileiconId()] = $model->getData();
            $this->dataPersistor->clear('prince_productattach_fileicon');
        }
        
        return $this->loadedData;
    }

    public function getMediaUrl()
    {
        $mediaUrl = $this->storeManager->getStore()
            ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA).'fileicon/tmp/icon/';
        return $mediaUrl;
    }
}
