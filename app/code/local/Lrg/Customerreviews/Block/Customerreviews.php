<?php

class Lrg_Customerreviews_Block_Customerreviews extends Mage_Core_Block_Template 
{
    protected $_reviewsCollection;

	public function _prepareLayout() {
		return parent::_prepareLayout();
	}
        
        public function getCustomerData()
        {
            return Mage::getSingleton('customer/session')->getCustomer();
        }
        protected function getReviewsCollection()
        {
            if (null === $this->_reviewsCollection) {
                $this->_reviewsCollection = Mage::getModel('customerreviews/reviews')->getCollection()
                        ->addFieldToFilter('review_status', 1)
                        ->setOrder('date', 'desc');
            }
            return $this->_reviewsCollection;
        }
}