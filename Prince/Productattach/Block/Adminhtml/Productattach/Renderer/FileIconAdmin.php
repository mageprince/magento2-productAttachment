<?php

namespace Prince\Productattach\Block\Adminhtml\Productattach\Renderer;
 
use Magento\Framework\DataObject;
 
class FileIconAdmin extends \Magento\Framework\Data\Form\Element\AbstractElement
{

    /**
     * @var \Magento\Framework\View\Asset\Repository
     */
    private $assetRepo;

    /**
     * @var \Prince\Productattach\Helper\Data
     */
    private $dataHelper;

    /**
     * @var \Prince\Productattach\Helper\Data
     */
    private $helper;

    /**
     * @var \Magento\Framework\UrlInterface
     */
    private $urlBuider;

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    private $coreRegistry = null;

    /**
     * @param \Magento\Framework\View\Asset\Repository $assetRepo
     * @param \Prince\Productattach\Helper\Data $dataHelper
     * @param \Magento\Backend\Helper\Data $helper
     * @param \Magento\Framework\UrlInterface $urlBuilder
     */
    public function __construct(
        \Magento\Framework\View\Asset\Repository $assetRepo,
        \Prince\Productattach\Helper\Data $dataHelper,
        \Magento\Backend\Helper\Data $helper,
        \Magento\Framework\UrlInterface $urlBuilder,
        \Magento\Framework\Registry $registry
    ) {
        $this->dataHelper = $dataHelper;
        $this->assetRepo = $assetRepo;
        $this->helper = $helper;
        $this->urlBuilder = $urlBuilder;
        $this->coreRegistry = $registry;
    }
 
    /**
     * get customer group name
     * @param  DataObject $row
     * @return string
     */
    public function getElementHtml()
    {
        $fileIcon = '<h3>No File Uploded</h3>';
        $file = $this->getValue();
        if ($file) {
            $fileExt = pathinfo($file, PATHINFO_EXTENSION);
            if ($fileExt) {
                $iconImage = $this->assetRepo->getUrl(
                    'Prince_Productattach::images/'.$fileExt.'.png'
                );
                $url = $this->dataHelper->getBaseUrl().'/'.$file;
                $fileIcon = "<a href=".$url." target='_blank'>
                    <img src='".$iconImage."' style='float: left;' />
                    <div>OPEN FILE</div></a>";
            } else {
                 $iconImage = $this->assetRepo->getUrl('Prince_Productattach::images/unknown.png');
                 $fileIcon = "<img src='".$iconImage."' style='float: left;' />";
            }
            $attachId = $this->coreRegistry->registry('productattach_id');
            $fileIcon .= "<a href='".$this->urlBuilder->getUrl(
                'productattach/index/deletefile', $param = ['productattach_id' => $attachId])."'>
                <div style='color:red;'>DELETE FILE</div></a>";
        }
        return $fileIcon;
    }
}
