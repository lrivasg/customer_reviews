<?php

class Lrg_Customerreviews_Model_Resource_Reminders extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('customerreviews/reminders', 'reminder_id');
    }
}