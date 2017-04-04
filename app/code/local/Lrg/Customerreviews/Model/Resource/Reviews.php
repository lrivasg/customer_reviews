<?php

class Lrg_Customerreviews_Model_Resource_Reviews extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('customerreviews/reviews', 'review_id');
    }
}