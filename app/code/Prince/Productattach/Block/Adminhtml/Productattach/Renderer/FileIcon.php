<?php

namespace Prince\Productattach\Block\Adminhtml\Productattach\Renderer;
 
use Magento\Framework\DataObject;
 
class FileIcon extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer
{

    /**
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     */
      protected $_assetRepo;
      protected $_dataHelper;

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