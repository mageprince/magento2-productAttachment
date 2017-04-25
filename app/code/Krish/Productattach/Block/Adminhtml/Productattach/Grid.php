<?php
namespace Krish\Productattach\Block\Adminhtml\Productattach;

/**
 * Adminhtml Productattach grid
 */
class Grid extends \Magento\Backend\Block\Widget\Grid\Extended
{
    /**
     * @var \Krish\Productattach\Model\ResourceModel\Productattach\CollectionFactory
     */
    protected $_collectionFactory;

    /**
     * @var \Krish\Productattach\Model\Productattach
     */
    protected $_productattach;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param \Krish\Productattach\Model\Productattach $productattachPage
     * @param \Krish\Productattach\Model\ResourceModel\Productattach\CollectionFactory $collectionFactory
     * @param \Magento\Core\Model\PageLayout\Config\Builder $pageLayoutBuilder
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Krish\Productattach\Model\Productattach $productattach,
        \Krish\Productattach\Model\ResourceModel\Productattach\CollectionFactory $collectionFactory,
        array $data = []
    ) {
        $this->_collectionFactory = $collectionFactory;
        $this->_productattach = $productattach;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('productattachGrid');
        $this->setDefaultSort('productattach_id');
        $this->setDefaultDir('ASC');
        $this->setUseAjax(true);
        $this->setSaveParametersInSession(true);
    }

    /**
     * Prepare collection
     *
     * @return \Magento\Backend\Block\Widget\Grid
     */
    protected function _prepareCollection()
    {
        $collection = $this->_collectionFactory->create();
        /* @var $collection \Krish\Productattach\Model\ResourceModel\Productattach\Collection */
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    /**
     * Prepare columns
     *
     * @return \Magento\Backend\Block\Widget\Grid\Extended
     */
    protected function _prepareColumns()
    {
        $this->addColumn('productattach_id', [
            'header'    => __('ID'),
            'index'     => 'productattach_id',
        ]);
        
        $this->addColumn(
            'name', 
            [
                'header' => __('Name'), 
                'index' => 'name'
            ]);

        $this->addColumn(
            'description', 
            [
                'header' => __('Description'), 
                'index' => 'description']
            );

        $this->addColumn(
            'file', 
            [
                'header' => __('File'), 
                'index' => 'file',
                'renderer' => 'Krish\Productattach\Block\Adminhtml\Productattach\Renderer\FileIcon'
            ]);
        
        /*$this->addColumn(
            'url', 
            [
                'header' => __('Url'), 
                'index' => 'url'
            ]);*/

        $this->addColumn(
            'customer_group', 
            [
                'header' => __('Customer Group'), 
                'index' => 'customer_group',
                'renderer' => 'Krish\Productattach\Block\Adminhtml\Productattach\Renderer\Group'
            ]);

        $this->addColumn(
            'store', 
            [
                'header' => __('Store '), 
                'index' => 'store',
                'renderer' => 'Krish\Productattach\Block\Adminhtml\Productattach\Renderer\Store'
            ]);

        /*$this->addColumn(
            'products', 
            [
                'header' => __('Assigned Products'), 
                'width' => '50px',
                'type'  => 'number',
                'index' => 'products'
            ]);
        */
        $this->addColumn(
            'active', 
            [
                'header' => __('Active'), 
                'index' => 'active',
                'renderer' => 'Krish\Productattach\Block\Adminhtml\Productattach\Renderer\Active'
            ]);
        
        /*$this->addColumn(
            'published_at',
            [
                'header' => __('Published On'),
                'index' => 'published_at',
                'type' => 'date',
                'header_css_class' => 'col-date',
                'column_css_class' => 'col-date'
            ]
        );
        
        $this->addColumn(
            'created_at',
            [
                'header' => __('Created'),
                'index' => 'created_at',
                'type' => 'datetime',
                'header_css_class' => 'col-date',
                'column_css_class' => 'col-date'
            ]
        );*/
        
        $this->addColumn(
            'action',
            [
                'header' => __('Edit'),
                'type' => 'action',
                'getter' => 'getId',
                'actions' => [
                    [
                        'caption' => __('Edit'),
                        'class' => 'action-secondary',
                        'url' => [
                            'base' => '*/*/edit',
                            'params' => ['store' => $this->getRequest()->getParam('store')]
                        ],
                        'field' => 'productattach_id'
                    ]
                ],
                'sortable' => false,
                'filter' => false,
                'css_class' => 'scalable action-secondary',
                'header_css_class' => 'col-action',
                'column_css_class' => 'col-action'
            ]
        );

        return parent::_prepareColumns();
    }

    /**
     * Row click url
     *
     * @param \Magento\Framework\Object $row
     * @return string
     */
    public function getRowUrl($row)
    {
        return false;
    }

    /**
     * Get grid url
     *
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', ['_current' => true]);
    }
}
