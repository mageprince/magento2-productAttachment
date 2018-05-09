<?php
/**
 * @author Convert Team
 * @copyright Copyright (c) 2018 Convert (http://www.convert.no/)
 */
namespace Prince\Productattach\Ui\DataProvider\Modifier;

use Magento\Ui\Component\Form\Element\ActionDelete;
use Prince\Productattach\Helper\Data;
use Prince\Productattach\Model\AttachmentRepository;
use Magento\Catalog\Model\Locator\LocatorInterface;
use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\AbstractModifier;
use Magento\Framework\Phrase;
use Magento\Framework\Stdlib\ArrayManager;
use Magento\Framework\UrlInterface;
use Magento\Ui\Component;
use Magento\Ui\Component\Container;
use Magento\Ui\Component\DynamicRows;
use Magento\Ui\Component\Form\Element\DataType\Text;
use Magento\Ui\Component\Form\Element\Input;
use Magento\Ui\Component\Form\Field;
use Magento\Ui\Component\Form\Fieldset;
use Magento\Ui\Component\Modal;

/**
 * Class Attachments
 */
class Attachments extends AbstractModifier
{
    /**
     * @var string
     */
    protected static $previousGroup = 'search-engine-optimization';

    /**
     * @var int
     */
    protected static $sortOrder = 90;

    /**
     * @var ArrayManager
     * @since 101.0.0
     */
    protected $arrayManager;

    /**
     * @var AttachmentRepository
     */
    protected $attachmentRepository;

    /**
     * @var Data
     */
    protected $helper;

    /**
     * @var LocatorInterface
     */
    protected $locator;

    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * @var string
     * @since 101.0.0
     */
    protected $scopeName;

    /**
     * @param AttachmentRepository $attachmentRepository
     * @param ArrayManager $arrayManager
     * @param LocatorInterface $locator
     * @param UrlInterface $urlBuilder
     * @param string $scopeName
     */
    public function __construct(
        AttachmentRepository $attachmentRepository,
        ArrayManager $arrayManager,
        Data $helper,
        LocatorInterface $locator,
        UrlInterface $urlBuilder,
        $scopeName = ''
    ) {
        $this->attachmentRepository = $attachmentRepository;
        $this->arrayManager = $arrayManager;
        $this->helper = $helper;
        $this->locator = $locator;
        $this->urlBuilder = $urlBuilder;
        $this->scopeName = $scopeName;
    }

    /**
     * {@inheritdoc}
     */
    public function modifyMeta(array $meta)
    {
        $meta = $this->customizeGrid($meta);
        $meta = $this->customizeSelectExistingAttachment($meta);
        $meta = $this->customizeCreateNewAttachment($meta);

        return $meta;
    }

    public function customizeGrid(array $meta)
    {
        return $this->arrayManager->set(
            'prince_attachment',
            $meta,
            [
                'arguments' => [
                    'data' => [
                        'config' => [
                            'additionalClasses' => 'admin__fieldset-section',
                            'label' => __('Product Attachments'),
                            'collapsible' => true,
                            'opened' => true,
                            'componentType' => Fieldset::NAME,
                            'dataScope' => '',
                            'sortOrder' => $this->getNextGroupSortOrder(
                                $meta,
                                self::$previousGroup,
                                self::$sortOrder
                            ),
                        ],
                    ],
                ],
                'children' => [
                    'add_attachment_header' => [
                        'arguments' => [
                            'data' => [
                                'config' => [
                                    'formElement' => 'container',
                                    'componentType' => Container::NAME,
                                    'label' => false,
                                    'content' => __(
                                        'Provides more information for the products customers purchase by allowing to attach '
                                        . 'multiple downloadable files such as manuals, tutorials, license, videos right '
                                        . 'on your Magento product page.'
                                    ),
                                    'template' => 'ui/form/components/complex',
                                ],
                            ],
                        ],
                    ],
                    'prince_attachment' => [
                        'arguments' => [
                            'data' => [
                                'config' => [
                                    'additionalClasses' => 'admin__field-wide',
                                    'componentType' => DynamicRows::NAME,
                                    'label' => null,
                                    'columnsHeader' => false,
                                    'columnsHeaderAfterRender' => true,
                                    'renderDefaultRecord' => false,
                                    'template' => 'ui/dynamic-rows/templates/grid',
                                    'component' => 'Magento_Ui/js/dynamic-rows/dynamic-rows-grid',
                                    'addButton' => false,
                                    'recordTemplate' => 'record',
                                    'dataScope' => 'data',
                                    'deleteButtonLabel' => __('Remove'),
                                    'dataProvider' => 'attachments_product_listing',
                                    'map' => [
                                        'id' => 'productattach_id',
                                        'name' => 'name',
                                        'description' => 'description',
                                        'url' => 'url',
                                        'customer_group' => 'customer_group',
                                        'store' => 'store',
                                        'active' => 'active',
                                    ],
                                    'links' => [
                                        'insertData' => '${ $.provider }:${ $.dataProvider }'
                                    ],
                                    'sortOrder' => 2,
                                    'dndConfig' => [
                                        'enabled' => false,
                                    ]
                                ],
                            ],
                        ],
                        'children' => [
                            'record' => [
                                'arguments' => [
                                    'data' => [
                                        'config' => [
                                            'componentType' => Container::NAME,
                                            'isTemplate' => true,
                                            'is_collection' => true,
                                            'component' => 'Magento_Ui/js/dynamic-rows/record',
                                            'dataScope' => '',
                                        ],
                                    ],
                                ],
                                'children' => $this->fillMeta(),
                            ],
                        ],
                    ],
                ],
            ]
        );
    }

    /**
     * @param array $meta
     * @return array
     */
    public function customizeSelectExistingAttachment(array $meta)
    {
        $meta = $this->arrayManager->set(
            'prince_attachment/children/add_attachment_header/children/select_attachment_button',
            $meta,
            [
                'arguments' => [
                    'data' => [
                        'config' => [
                            'formElement' => 'container',
                            'componentType' => Container::NAME,
                            'component' => 'Magento_Ui/js/form/components/button',
                            'actions' => [
                                [
                                    'targetName' => $this->scopeName . '.prince_attachment.select_attachment_modal',
                                    'actionName' => 'toggleModal',
                                ],
                                [
                                    'targetName' => $this->scopeName . '.prince_attachment.select_attachment_modal.attachments_product_listing',
                                    'actionName' => 'render',
                                ]
                            ],
                            'title' => __('Select Attachment'),
                            'provider' => null,
                        ],
                    ],
                ],
            ]
        );

        $meta = $this->arrayManager->set(
            'prince_attachment/children/select_attachment_modal',
            $meta,
            [
                'arguments' => [
                    'data' => [
                        'config' => [
                            'componentType' => Modal::NAME,
                            'dataScope' => '',
                            'options' => [
                                'title' => __('Add Attachment'),
                                'buttons' => [
                                    [
                                        'text' => __('Cancel'),
                                        'actions' => [
                                            'closeModal'
                                        ]
                                    ],
                                    [
                                        'text' => __('Add Selected'),
                                        'class' => 'action-primary',
                                        'actions' => [
                                            [
                                                'targetName' => 'index = attachments_product_listing',
                                                'actionName' => 'save'
                                            ],
                                            'closeModal'
                                        ]
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
                'children' => [
                    'select_attachment_button' => [
                        'arguments' => [
                            'data' => [
                                'config' => [
                                    'additionalClasses' => 'admin__field-complex-attributes',
                                    'formElement' => Container::NAME,
                                    'componentType' => Container::NAME,
                                    'content' => __('Select Attachment'),
                                    'label' => false,
                                    'template' => 'ui/form/components/complex',
                                ],
                            ],
                        ],
                    ],
                    'attachments_product_listing' => [
                        'arguments' => [
                            'data' => [
                                'config' => [
                                    'autoRender' => false,
                                    'componentType' => 'insertListing',
                                    'dataScope' => 'attachments_product_listing',
                                    'externalProvider' => 'productattach_grid_index.productattach_grid_index_data_source',
                                    'selectionsProvider' => 'productattach_grid_index.productattach_grid_index.productattach_grid_index_columns.ids',
                                    'ns' => 'productattach_grid_index',
                                    'render_url' => $this->urlBuilder->getUrl('mui/index/render'),
                                    'realTimeLink' => true,
                                    'dataLinks' => [
                                        'imports' => false,
                                        'exports' => true
                                    ],
                                    'behaviourType' => 'simple',
                                    'externalFilterMode' => true,
                                    'imports' => [
                                        'productId' => '${ $.provider }:data.product.current_product_id',
                                        'storeId' => '${ $.provider }:data.product.current_store_id',
                                    ],
                                    'exports' => [
                                        'productId' => '${ $.externalProvider }:params.current_product_id',
                                        'storeId' => '${ $.externalProvider }:params.current_store_id',
                                    ]
                                ],
                            ],
                        ],
                    ],
                ],
            ]
        );

        return $meta;
    }

    /**
     * @param array $meta
     * @return array
     */
    protected function customizeCreateNewAttachment(array $meta)
    {
        $params = [
            'store' => $this->locator->getStore()->getId(),
            'product' => $this->locator->getProduct()->getId(),
            'message_key' => 'messages',
            'popup' => 1,
        ];

        $meta = $this->arrayManager->set(
            'prince_attachment/children/add_attachment_header/children/create_attachment_button',
            $meta,
            [
                'arguments' => [
                    'data' => [
                        'config' => [
                            'formElement' => Container::NAME,
                            'componentType' => Container::NAME,
                            'component' => 'Magento_Ui/js/form/components/button',
                            'additionalClasses' => '',
                            'actions' => [
                                [
                                    'targetName' => 'product_form.product_form.prince_attachment.'
                                        . 'create_new_attachment_modal',
                                    'actionName' => 'toggleModal',
                                ],
                                [
                                    'targetName' => 'product_form.product_form.prince_attachment'
                                        . '.create_new_attachment_modal.product_attachment_add_form',
                                    'actionName' => 'render'
                                ]
                            ],
                            'title' => __('Create New Attachment'),
                            'provider' => null,
                        ],
                    ],
                ],
            ]
        );

        $meta = $this->arrayManager->set(
            'prince_attachment/children/create_new_attachment_modal',
            $meta,
            [
                'arguments' => [
                    'data' => [
                        'config' => [
                            'isTemplate' => false,
                            'componentType' => Component\Modal::NAME,
                            'dataScope' => 'data.new_attachment',
                            'provider' => 'product_form.product_form_data_source',
                            'options' => [
                                'title' => __('New Attachment')
                            ],
                            'imports' => [
                                'state' => '!index=product_attachment_add_form:responseStatus'
                            ],
                        ]
                    ]
                ],
                'children' => [
                    'product_attachment_add_form' => [
                        'arguments' => [
                            'data' => [
                                'config' => [
                                    'label' => __('New Attachment'),
                                    'componentType' => Container::NAME,
                                    'component' => 'Prince_Productattach/js/components/new-attachment-insert-form',
                                    'dataScope' => '',
                                    'update_url' => $this->urlBuilder->getUrl('mui/index/render'),
                                    'render_url' => $this->urlBuilder->getUrl(
                                        'mui/index/render_handle',
                                        [
                                            'handle' => 'product_attachment_edit_form',
                                            'buttons' => 1,
                                        ]
                                    ),
                                    'autoRender' => false,
                                    'ns' => 'product_attachment_add_form',
                                    'externalProvider' => 'product_attachment_add_form'
                                        . '.product_attachment_add_form_data_source',
                                    'toolbarContainer' => '${ $.parentName }',
                                    'formSubmitType' => 'ajax',
                                    'saveUrl' => $this->urlBuilder->getUrl('productattach/index/save', $params),
                                    'validateUrl' => $this->urlBuilder->getUrl(
                                        'productattach/index/validate',
                                        $params
                                    ),
                                    'productId' => $this->locator->getProduct()->getId(),
                                    'exports' => [
                                        'saveUrl' => '${ $.externalProvider }:client.urls.save',
                                        'validateUrl' => '${ $.externalProvider }:client.urls.beforeSave',
                                    ]
                                ]
                            ]
                        ]
                    ]
                ],
            ]
        );

        return $meta;
    }

    /**
     * {@inheritdoc}
     */
    public function modifyData(array $data)
    {
        /** @var \Magento\Catalog\Model\Product $product */
        $product = $this->locator->getProduct();
        $productId = $product->getId();

        if (!$productId) {
            return $data;
        }

        $rows = [];
        $attachments = $this->attachmentRepository->getByProduct($product);
        foreach ($attachments as $attachment) {
            $rows[] = $this->helper->format($attachment);
        }
        $data[$productId]['prince_attachment'] = $rows;

        return $data;
    }

    /**
     * Retrieve meta column
     *
     * @return array
     */
    protected function fillMeta()
    {
        return [
            'id' => $this->getTextColumn('id', false, __('ID'), 10),
            'name' => $this->getTextColumn('name', false, __('Name'), 20),
            'description' => $this->getTextColumn('description', false, __('Description'), 30),
            'url' => $this->getTextColumn('url', false, __('URL'), 40),
            'customer_group' => $this->getTextColumn('customer_group', false, __('Customer Group'), 50),
            'store' => $this->getTextColumn('store', false, __('Store'), 60),
            'active' => [
                'arguments' => [
                    'data' => [
                        'config' => [
                            'componentType' => Field::NAME,
                            'formElement' => Input::NAME,
                            'elementTmpl' => 'Prince_Productattach/dynamic-rows/cells/html',
                            'component' => 'Magento_Ui/js/form/element/text',
                            'dataType' => Text::NAME,
                            'dataScope' => 'active',
                            'fit' => false,
                            'label' => __('Status'),
                            'sortOrder' => 70,
                        ],
                    ],
                ],
            ],
            'actionDelete' => [
                'arguments' => [
                    'data' => [
                        'config' => [
                            'additionalClasses' => 'data-grid-actions-cell',
                            'componentType' => ActionDelete::NAME,
                            'dataType' => Text::NAME,
                            'label' => __('Actions'),
                            'sortOrder' => 80,
                            'fit' => true,
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * Retrieve text column structure
     *
     * @param string $dataScope
     * @param bool $fit
     * @param Phrase $label
     * @param int $sortOrder
     * @return array
     */
    protected function getTextColumn($dataScope, $fit, Phrase $label, $sortOrder)
    {
        $column = [
            'arguments' => [
                'data' => [
                    'config' => [
                        'componentType' => Field::NAME,
                        'formElement' => Input::NAME,
                        'elementTmpl' => 'ui/dynamic-rows/cells/text',
                        'component' => 'Magento_Ui/js/form/element/text',
                        'dataType' => Text::NAME,
                        'dataScope' => $dataScope,
                        'fit' => $fit,
                        'label' => $label,
                        'sortOrder' => $sortOrder,
                    ],
                ],
            ],
        ];

        return $column;
    }
}
