<?php
/**
 * Customerreviews reviews model
 * 
 * @category	Lrg 
 * @package     Lrg_Customerreviews
 * @author      Luis Rivas <lrivasg.8@gmail.com>
 */
class Lrg_Customerreviews_Model_Reviews extends Mage_Core_Model_Abstract
{
    const STATUS_APPROVED	= 1;
    const STATUS_PENDING	= 0;
 

    protected function _construct()
    {
        $this->_init('customerreviews/reviews');
        parent::_construct();
    }
    
    public function getStatuses()
    {
        return array(
            self::STATUS_APPROVED    => Mage::helper('customerreviews')->__('Approved'),
            self::STATUS_PENDING   => Mage::helper('customerreviews')->__('Pending')
        );
    }

    
}