<?php
/**
 * Customerreviews adminhtml block edit tab form
 * 
 * @category	Lrg 
 * @package     Lrg_Customerreviews
 * @author      Luis Rivas <lrivasg.8@gmail.com>
 */
class Lrg_Customerreviews_Block_Adminhtml_Customerreviews_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('customerreviews_form', array('legend'=>Mage::helper('customerreviews')->__('Review information')));
        
        $fieldset->addField('name', 'text', array(
            'label'     => Mage::helper('customerreviews')->__('Name'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'name',
        ));
        $fieldset->addField('email', 'text', array(
            'label'     => Mage::helper('customerreviews')->__('Email'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'email',
        ));
  
        $fieldset->addField('review_status', 'select', array(
            'label'     => Mage::helper('customerreviews')->__('Status'),
            'name'      => 'review_status',
            'values'    => Mage::getSingleton('customerreviews/reviews')->getStatuses()
        ));
        
        $fieldset->addField('message', 'editor', array(
            'name'      => 'message',
            'label'     => Mage::helper('customerreviews')->__('Message'),
            'title'     => Mage::helper('customerreviews')->__('Message'),
            'style'     => 'width:98%; height:400px;',
            'wysiwyg'   => false,
            'required'  => true,
        ));
        
        if ( Mage::getSingleton('adminhtml/session')->getCustomerreviewsData() ) 
        {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getCustomerreviewsData());
            Mage::getSingleton('adminhtml/session')->setCustomerreviewsData(null);
        } elseif ( Mage::registry('customerreviews_data') ) {
            $form->setValues(Mage::registry('customerreviews_data')->getData());
        }
        return parent::_prepareForm();
    }
}