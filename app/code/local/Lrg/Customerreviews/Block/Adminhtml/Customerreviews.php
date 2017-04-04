<?php
/**
 * Customerreviews adminhtml block
 * 
 * @category	Lrg 
 * @package     Lrg_Customerreviews
 * @author      Luis Rivas <lrivasg.8@gmail.com>
 */
class Lrg_Customerreviews_Block_Adminhtml_Customerreviews extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    public function __construct()
    {
        $this->_controller = "adminhtml_customerreviews";
        $this->_blockGroup = "customerreviews";
        $this->_headerText = Mage::helper("customerreviews")->__("Reviews Manager");
        $this->_addButtonLabel = Mage::helper("customerreviews")->__("Add New Review");

        parent::__construct();	
    }

}