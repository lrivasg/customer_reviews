<?php

class Lrg_Customerreviews_Model_Observer
{
    
    public function addReminderReview($observer)
    {
        $event = $observer->getEvent();
        $orderIds = $event->getOrderIds();
        $timeStamp = time();
        if (!empty($orderIds) && is_array($orderIds)) {
            
            if (count($orderIds)>1) {
                foreach ($orderIds as $orderId) {
                    $order = Mage::getModel('sales/order')->load($orderId);
                    $customerId = $order->getCustomerId();
                    if (empty($customerId)) {
                        continue;
                    }
                    $customerremindersModel = Mage::getModel('customerreviews/reminders');
                    $customerremindersModel->setReminderStatus(0);
                    $customerremindersModel->setOrderId($orderIds[0]);
                    $customerremindersModel->setCustomerEmail($order->getCustomerEmail());
                    $customerremindersModel->setSentAt($timeStamp + Mage::Helper('customerreviews/data')->getConfDaysAfterOrder());
                    $customerremindersModel->setCreatedAt($timeStamp);
                    $customerremindersModel->save();
                }
                
            }else{
                $order = Mage::getModel('sales/order')->load($orderIds[0]);
                $customerId = $order->getCustomerId();
                if (empty($customerId)) {
                    return false;
                }
                $customerremindersModel = Mage::getModel('customerreviews/reminders');
                $customerremindersModel->setReminderStatus(0);
                $customerremindersModel->setOrderId($orderIds[0]);
                $customerremindersModel->setCustomerId($customerId);
                $customerremindersModel->setCustomerEmail($order->getCustomerEmail());
                $customerremindersModel->setSentAt($timeStamp + Mage::Helper('customerreviews/data')->getConfDaysAfterOrder());
                $customerremindersModel->setCreatedAt($timeStamp);
                $customerremindersModel->save();
            }
        }
    }
    
    /**
     * Cron job method
     *
     * @param Mage_Cron_Model_Schedule $schedule
     */
    public function sendReminderReview(Mage_Cron_Model_Schedule $schedule)
    {
        Mage::log('Entra en el CRON!', null, 'observercron.log',true);

        //get all records to send reminder
        $collection = Mage::getModel('customerreviews/reminders')->getCollection()
                ->addFieldToFilter('reminder_status', 0);
        
        if ($collection->count() > 0) {
            foreach ($collection as $reminder) {
                $customerEmail = $reminder->getCustomerEmail();
                $status = $reminder->getReminderStatus();            
                
                //send mail to customer
                $isMailSent = Mage::Helper('customerreviews/data')->sendReminderReviewEmail($reminder);
                
                //update reminder in data base
                if ($isMailSent) {
                    $reminder->setReminderStatus(1);
                    $reminder->setUpdatedAt($timeStamp);
                    $reminder->save();
                }
            }            
        }
    }
}
