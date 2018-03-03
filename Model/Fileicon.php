<?php


namespace Prince\Productattach\Model;

use Prince\Productattach\Api\Data\FileiconInterface;

class Fileicon extends \Magento\Framework\Model\AbstractModel implements FileiconInterface
{

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Prince\Productattach\Model\ResourceModel\Fileicon');
    }

    /**
     * Get fileicon_id
     * @return string
     */
    public function getFileiconId()
    {
        return $this->getData(self::FILEICON_ID);
    }

    /**
     * Set fileicon_id
     * @param string $fileiconId
     * @return \Prince\Productattach\Api\Data\FileiconInterface
     */
    public function setFileiconId($fileiconId)
    {
        return $this->setData(self::FILEICON_ID, $fileiconId);
    }

    /**
     * Get icon_ext
     * @return string
     */
    public function getIconExt()
    {
        return $this->getData(self::ICON_EXT);
    }

    /**
     * Set icon_ext
     * @param string $icon_ext
     * @return \Prince\Productattach\Api\Data\FileiconInterface
     */
    public function setIconExt($icon_ext)
    {
        return $this->setData(self::ICON_EXT, $icon_ext);
    }

    /**
     * Get icon_image
     * @return string
     */
    public function getIconImage()
    {
        return $this->getData(self::ICON_IMAGE);
    }

    /**
     * Set icon_image
     * @param string $icon_image
     * @return \Prince\Productattach\Api\Data\FileiconInterface
     */
    public function setIconImage($icon_image)
    {
        return $this->setData(self::ICON_IMAGE, $icon_image);
    }
}
