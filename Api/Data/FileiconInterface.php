<?php


namespace Prince\Productattach\Api\Data;

interface FileiconInterface
{

    const ICON_IMAGE = 'icon_image';
    const FILEICON_ID = 'fileicon_id';
    const ICON_EXT = 'icon_ext';


    /**
     * Get fileicon_id
     * @return string|null
     */
    public function getFileiconId();

    /**
     * Set fileicon_id
     * @param string $fileicon_id
     * @return \Prince\Productattach\Api\Data\FileiconInterface
     */
    public function setFileiconId($fileiconId);

    /**
     * Get icon_ext
     * @return string|null
     */
    public function getIconExt();

    /**
     * Set icon_ext
     * @param string $icon_ext
     * @return \Prince\Productattach\Api\Data\FileiconInterface
     */
    public function setIconExt($icon_ext);

    /**
     * Get icon_image
     * @return string|null
     */
    public function getIconImage();

    /**
     * Set icon_image
     * @param string $icon_image
     * @return \Prince\Productattach\Api\Data\FileiconInterface
     */
    public function setIconImage($icon_image);
}
