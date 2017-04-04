<?php
  
class Lrg_Customerreviews_Block_Adminhtml_Customerreviews_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                
        $this->_objectId = 'id';
        $this->_blockGroup = 'customerreviews';
        $this->_controller = 'adminhtml_customerreviews';
  
        $this->_updateButton('save', 'label', Mage::helper('customerreviews')->__('Save Review'));
        $this->_updateButton('delete', 'label', Mage::helper('customerreviews')->__('Delete Review'));
    }
  
    public function getHeaderText()
    {
        if ( Mage::registry('customerreviews_data') && Mage::registry('customerreviews_data')->getId() ) {
            return Mage::helper('customerreviews')->__("Edit Review '%s'", $this->htmlEscape(Mage::registry('customerreviews_data')->getName()));
        } else {
            return Mage::helper('customerreviews')->__('Add Review');
        }
    }
} 