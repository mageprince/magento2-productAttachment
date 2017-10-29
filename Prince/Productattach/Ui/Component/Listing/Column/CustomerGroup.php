<?php

namespace Prince\Productattach\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Customer\Model\Group;

class CustomerGroup extends Column
{
    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        Group $customerGroup,
        array $components = [],
        array $data = []
    ) {
        $this->_customerGroup = $customerGroup;
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
        if (isset($dataSource['data']['items'])) {
            $fieldName = $this->getData('customer_group');
            foreach ($dataSource['data']['items'] as &$items) {
                $groups = explode(',', $items['customer_group']);
                $customers = [];
                foreach ($groups as $key => $group) {
                    $customer = $this->_customerGroup->load($group);
                    $customers[$key] =  $customer->getCustomerGroupCode();
                }
                $items['customer_group'] = implode(' - ', $customers);
            }
        }
        return $dataSource;
    }
}
