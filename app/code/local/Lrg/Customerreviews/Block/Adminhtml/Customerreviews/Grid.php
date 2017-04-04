<?php
/**
 * Customerreviews adminhtml block grid
 * 
 * @category	Lrg 
 * @package     Lrg_Customerreviews
 * @author      Luis Rivas <lrivasg.8@gmail.com>
 */
class Lrg_Customerreviews_Block_Adminhtml_Customerreviews_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('reviewsGrid');
        $this->setDefaultSort('review_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('customerreviews/reviews')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('review_id', array(
            'header'   => Mage::helper('customerreviews')->__('Id'),
            'index'    => 'review_id',
            'width'    => 50
        ));

        $this->addColumn('review_status', array(
            'header'   => Mage::helper('customerreviews')->__('Status'),
            'index'    => 'review_status',
            'type'     => 'options',
            'width'    => 80,
            'options'   => Mage::getSingleton('customerreviews/reviews')->getStatuses()
        ));

        $this->addColumn('name', array(
            'header'   => Mage::helper('customerreviews')->__('Name'),
            'index'    => 'name',
            'width'    => 200
        ));

        $this->addColumn('email', array(
            'header'   => Mage::helper('customerreviews')->__('Email'),
            'index'    => 'email',
            'width'    => 200
        ));
        
        $this->addColumn('rating_delivery', array(
            'header'   => Mage::helper('customerreviews')->__('Rating delivery'),
            'index'    => 'rating_delivery',
            'width'    => 10,
        ));
        
        $this->addColumn('rating_product', array(
            'header'   => Mage::helper('customerreviews')->__('Rating product'),
            'index'    => 'rating_product',
            'width'    => 10,
        ));
        
        $this->addColumn('rating_customer_support', array(
            'header'   => Mage::helper('customerreviews')->__('Rating customer support'),
            'index'    => 'rating_customer_support',
            'width'    => 10,
        ));
        $this->addColumn('message', array(
            'header'   => Mage::helper('customerreviews')->__('Message'),
            'index'    => 'message',
            'width'    => 600,
        ));

        $this->addColumn('date', array(
            'header'   => Mage::helper('customerreviews')->__('Created Date'),
            'index'    => 'date',
            'width'    => 150,
            'type' => 'datetime'
        ));
        
        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('review_id');
        $this->getMassactionBlock()->setFormFieldName('customerreviews');

        
        $this->getMassactionBlock()->addItem('delete', array(
             'label'=> Mage::helper('catalog')->__('Delete'),
             'url'  => $this->getUrl('*/*/massDelete'),
             'confirm' => Mage::helper('catalog')->__('Are you sure?')
        ));



        $statuses = Mage::getSingleton('customerreviews/reviews')->getStatuses();

        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('customerreviews')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                'visibility' => array(
                    'name' => 'review_status',
                    'type' => 'select',
                    'class' => 'required-entry',
                    'label' => Mage::helper('customerreviews')->__('Status'),
                    'values' => $statuses
                 )
             )
        ));
   
        return $this;
    }

    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }

    protected function _filterStoreCondition($collection, $column)
    {
        if (!$value = $column->getFilter()->getValue()) {
            return;
        }
        $this->getCollection()->addStoreFilter($value);
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('review_id' => $row->getReviewId()));
    }
    
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }
 
}