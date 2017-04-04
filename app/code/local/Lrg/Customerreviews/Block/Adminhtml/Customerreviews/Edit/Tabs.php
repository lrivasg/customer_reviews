 <?php
/**
 * Customerreviews adminhtml block edit tabs
 * 
 * @category	Lrg 
 * @package     Lrg_Customerreviews
 * @author      Luis Rivas <lrivasg.8@gmail.com>
 */
class Lrg_Customerreviews_Block_Adminhtml_Customerreviews_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
  
    public function __construct()
    {
        parent::__construct();
        $this->setId('customerreviews_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('customerreviews')->__('Review Information'));
    }
  
    protected function _beforeToHtml()
    {
        $this->addTab('form_section', array(
            'label'     => Mage::helper('customerreviews')->__('Review Information'),
            'title'     => Mage::helper('customerreviews')->__('Review Information'),
            'content'   => $this->getLayout()->createBlock('customerreviews/adminhtml_customerreviews_edit_tab_form')->toHtml(),
        ));
        
        return parent::_beforeToHtml();
    }
}