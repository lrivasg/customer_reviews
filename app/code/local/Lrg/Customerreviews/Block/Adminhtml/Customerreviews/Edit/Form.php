<?php
/**
 * Customerreviews adminhtml block edit form
 * 
 * @category	Lrg 
 * @package     Lrg_Customerreviews
 * @author      Luis Rivas <lrivasg.8@gmail.com>
 */  
class Lrg_Customerreviews_Block_Adminhtml_Customerreviews_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(array(
                'id' => 'edit_form',
                'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('review_id'))),
                'method' => 'post',
             )
        );
  
        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }
} 