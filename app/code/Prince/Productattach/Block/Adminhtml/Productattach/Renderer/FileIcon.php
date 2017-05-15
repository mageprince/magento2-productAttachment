<?php

namespace Prince\Productattach\Block\Adminhtml\Productattach\Renderer;
 
use Magento\Framework\DataObject;
 
class FileIcon extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer
{

    /**
     * @var \Magento\Framework\View\Asset\Repository
     */
    protected $_assetRepo;
    
    /**
     * @var \Prince\Productattach\Helper\Data
     */
    protected $_dataHelper;

    /**
     * @param \Magento\Framework\View\Asset\Repository $assetRepo
     * @param \Prince\Productattach\Helper\Data $dataHelper
     */
    public function __construct( 
         \Magento\Framework\View\Asset\Repository $assetRepo,
         \Prince\Productattach\Helper\Data $dataHelper
    ) {
        $this->_dataHelper = $dataHelper;
        $this->_assetRepo = $assetRepo;
    }
 
    /**
     * get customer group name
     * @param  DataObject $row
     * @return string
     */
    public function render(DataObject $row)
    {
        $file = $row->getFile();
        $fileExt = pathinfo($file, PATHINFO_EXTENSION);

        if($fileExt){
            $iconImage = $this->_assetRepo->getUrl('Prince_Productattach::images/'.$fileExt.'.png');
            $fileIcon = "<a href=".$this->_dataHelper->getBaseUrl().'/'.$file." target='_blank'><img src='".$iconImage."' /></a>";
        }else{
            $iconImage = $this->_assetRepo->getUrl('Prince_Productattach::images/unknown.png');
            $fileIcon = "<img src='".$iconImage."' />";
        }
        
        return $fileIcon;
    }
}
