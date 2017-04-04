<?php

class Lrg_Customerreviews_Model_Resource_Reminders_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('customerreviews/reminders');
    }
}