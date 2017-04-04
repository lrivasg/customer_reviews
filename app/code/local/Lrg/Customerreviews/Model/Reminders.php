<?php
/**
 * Customerreviews revimders model
 * 
 * @category	Lrg 
 * @package     Lrg_Customerreviews
 * @author      Luis Rivas <lrivasg.8@gmail.com>
 */
class Lrg_Customerreviews_Model_Reminders extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('customerreviews/reminders');
        parent::_construct();
    }   
}