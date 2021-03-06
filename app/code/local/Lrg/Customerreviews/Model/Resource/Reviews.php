<?php
/**
 * Customerreviews resource reviews
 * 
 * @category	Lrg 
 * @package     Lrg_Customerreviews
 * @author      Luis Rivas <lrivasg.8@gmail.com>
 */
class Lrg_Customerreviews_Model_Resource_Reviews extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('customerreviews/reviews', 'review_id');
    }
}