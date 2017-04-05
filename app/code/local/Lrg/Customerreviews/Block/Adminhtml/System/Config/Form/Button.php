<?php
/**
 * 
 * @category	Lrg 
 * @package     Lrg_Customerreviews
 * @author      Luis Rivas <lrivasg.8@gmail.com>
 */
class Lrg_Customerreviews_Block_Adminhtml_System_Config_Form_Button extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('customerreviews/run.phtml');
    }
    public function getAjaxUrl()
    {
        $data = $this->getRequest()->getPost();
        if ($data['send']) {
            Mage::dispatchEvent('send_reminders');
        }
        
    }
    
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {  
        return $this->_toHtml();
    }     
        
    public function getButtonHtml(){
        $button = $this->getLayout()->createBlock('adminhtml/widget_button')
            ->setData(array(
                'id'        => 'sendreminders_button',
                'label'     => $this->helper('customerreviews')->__('Send now'),
                'onclick'   => 'javascript:sendreminders(); return false;'
            ));
        return $button->toHtml();
    }
    
}