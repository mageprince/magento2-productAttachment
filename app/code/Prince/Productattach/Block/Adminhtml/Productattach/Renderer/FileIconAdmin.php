<?php

namespace Prince\Productattach\Block\Adminhtml\Productattach\Renderer;
 
use Magento\Framework\DataObject;
 
class FileIconAdmin extends \Magento\Framework\Data\Form\Element\AbstractElement
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

    public function getElementHtml()
    {
        $file = $this->getValue();
        $fileIcon = '';
        if($file){
            
            $fileExt = pathinfo($file, PATHINFO_EXTENSION);
        
            if($fileExt){
                 $iconImage = $this->_assetRepo->getUrl('Prince_Productattach::images/'.$fileExt.'.png');
                 $url = $this->_dataHelper->getBaseUrl().'/'.$file;
                 $fileIcon = "<a href=".$url." target='_blank'><img src='".$iconImage."' /><h2>Download Here</h2></a>";
            }else{
                 $iconImage = $this->_assetRepo->getUrl('Prince_Productattach::images/unknown.png');
                 $fileIcon = "<img src='".$iconImage."' />";
            }
        }
        return $fileIcon;
    }

}