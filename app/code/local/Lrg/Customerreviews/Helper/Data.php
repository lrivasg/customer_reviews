<?php
/**
 * Customerreviews data helper
 * 
 * @category	Lrg 
 * @package     Lrg_Customerreviews
 * @author      Luis Rivas <lrivasg.8@gmail.com>
 */
class Lrg_Customerreviews_Helper_Data extends Mage_Core_Helper_Abstract
{
    const XML_PATH_EMAIL_TEMPLATE   = 'customer_reviews/general_settings/email_template';
    const XML_PATH_EMAIL_SENDER     = 'customer_reviews/general_settings/sender_email_identity';
    const XML_PATH_ACTIVE           = 'customer_reviews/general_settings/enable';
    const XML_DAYS_AFTER_ORDER      = 'customer_reviews/general_settings/days';

    /**
     * Check is extension enabled
     *
     * @return boolean
     */
    public function isCustomerReviewsEnabled($store = null)
    {
        return Mage::getStoreConfigFlag(self::XML_PATH_ACTIVE, $store);
    }
    
    public function getConfDaysAfterOrder($store = null)
    {
        $days = Mage::getStoreConfig(self::XML_DAYS_AFTER_ORDER, $store);
        $days = $days*24*60*60;
        return $days;
    }
    
    /**
     * Check if review has been reviewed
     *
     */
    public function isReviewed($orderId)
    {
        $collection = Mage::getModel('customerreviews/reviews')->getCollection()
                ->addFieldToFilter('order_id', $orderId);
        
        if ($collection->count()) {
            Mage::getSingleton('customer/session')->addError(Mage::helper('customerreviews')->__('Your purchase has already been reviewed!'));                   
            return true;
        } else {
            return false;
        }
    }

    /**
     * check is match number of days after order placed with config number of days
     */
    public function matchDaysAfterOrder($reminder)
    {
         if (strtotime(now()) >= strtotime($reminder->getSentAt())) {
            return true;
         } else {
            return false;
         }
    }
    public function sendReminderReviewEmail($reminder, $remindernow = null)
    {
        //check is extension enabled
        if (!$this->isCustomerReviewsEnabled()) {
             return;
        }
        /**
         * Check days and status reminder
         */
        if (!$this->matchDaysAfterOrder($reminder) && $reminder->getRemiderStatus() == 0) {
            return;
        }
        $customerId = $reminder->getCustomerId();
        if (!$customerId) {
            return false;
        }
        $customer = Mage::getModel('customer/customer')->load($customerId);
        $customerEmail = $reminder->getCustomerEmail();
        $firstName = $customer->getFirstname();
        $orderId = $reminder->getOrderId();
        $incrementId = Mage::getResourceModel('sales/order')->getIncrementId($orderId);
               
        $translate = Mage::getSingleton('core/translate');
        $translate->setTranslateInline(false);
        try {
            $mailTemplate = Mage::getModel('core/email_template');

            $template = Mage::getStoreConfig(self::XML_PATH_EMAIL_TEMPLATE, Mage::app()->getStore()->getId());

            $mailSender = Mage::getStoreConfig(self::XML_PATH_EMAIL_SENDER, Mage::app()->getStore()->getId());
            
            $mailTemplate->setDesignConfig(array('area'=>'frontend', 'store'=>Mage::app()->getStore()->getId()))
                ->sendTransactional(
                $template,
                $mailSender,
                $customerEmail,
                $firstName,
                array(
                    'firstName' => $firstName,
                    'incrementId' => $incrementId,
                    'orderId' => $orderId
                )
            );
            
            if (!$mailTemplate->getSentSuccess()) {
                throw new Exception();
            }
                
            $translate->setTranslateInline(true);
            return true;
        } catch (Exception $ex) {
            $translate->setTranslateInline(true);
            return false;
        }
    }
}
