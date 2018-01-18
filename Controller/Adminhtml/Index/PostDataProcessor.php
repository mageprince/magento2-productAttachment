<?php

namespace Prince\Productattach\Controller\Adminhtml\Index;

/**
 * Class PostDataProcessor
 * @package Prince\Productattach\Controller\Adminhtml\Index
 */
class PostDataProcessor
{
    /**
     * @var \Magento\Framework\Stdlib\DateTime\Filter\Date
     */
    private $dateFilter;

    /**
     * @var \Magento\Framework\Message\ManagerInterface
     */
    private $messageManager;

    /**
     * PostDataProcessor constructor.
     * @param \Magento\Framework\Stdlib\DateTime\Filter\Date $dateFilter
     * @param \Magento\Framework\Message\ManagerInterface $messageManager
     */
    public function __construct(
        \Magento\Framework\Stdlib\DateTime\Filter\Date $dateFilter,
        \Magento\Framework\Message\ManagerInterface $messageManager
    ) {
        $this->dateFilter = $dateFilter;
        $this->messageManager = $messageManager;
    }

    /**
     * Filtering posted data. Converting localized data if needed
     *
     * @param array $data
     * @return array
     */
    public function filter($data)
    {
        $inputFilter = new \Zend_Filter_Input(
            ['published_at' => $this->dateFilter],
            [],
            $data
        );
        $data = $inputFilter->getUnescaped();
        return $data;
    }

    /**
     * Validate post data
     *
     * @param array $data
     * @return bool     Return FALSE if someone item is invalid
     */
    public function validate()
    {
        $errorNo = true;
        return $errorNo;
    }
}
