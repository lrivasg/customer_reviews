<?php
 
class Lrg_Customerreviews_Adminhtml_IndexController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        
        $this->loadLayout();
        $block = $this->getLayout()
                        ->createBlock('core/text', 'example-block')
                        ->setText('<h1>Hello World</h1>');

        $this->_addContent($block);
        $this->renderLayout();
    }

}