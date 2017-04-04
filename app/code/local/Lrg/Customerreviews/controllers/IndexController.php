<?php
/**
 * 
 * @category	Lrg 
 * @package     Lrg_Customerreviews
 * @author      Luis Rivas <lrivasg.8@gmail.com>
 */
class Lrg_Customerreviews_IndexController extends Mage_Core_Controller_Front_Action 
{
    
    const XML_PATH_ACTIVE = 'customer_reviews/general_settings/enable';

    public function preDispatch()
    {
        parent::preDispatch();

        if( !Mage::getStoreConfigFlag(self::XML_PATH_ACTIVE) ) {
            $this->norouteAction();
        }
    }
    public function indexAction() {
		$this->loadLayout();
		$this->renderLayout();
	}
    public function newAction()
    {
        $customer_session = Mage::getSingleton('customer/session');
        if ($customer_session->isLoggedIn()) {
            
            $isReviewed = Mage::Helper('customerreviews')->isReviewed($this->getRequest()->getParam('order_id'));
            
            if ($isReviewed) {
                $this->_redirect('customer/account');
            } else {
                $this->loadLayout();
                $this->renderLayout();
            }
        } else {
            $this->_redirect('customer/account/login');
        }
        
    }
    public function postAction()
    {
        $data = $this->getRequest()->getPost();
        if (isset($data)) {
            try {
                if (!($data['name']) || !($data['email']) || !($data['message'])) { 
                    Mage::getSingleton('customer/session')->addError(Mage::helper('customerreviews')->__('Please, fill all required fields.'));                   
                } else {

                    $customerreviewsModel = Mage::getModel('customerreviews/reviews');
                    $timeStamp = time();
                    $customerreviewsModel->setOrderId($data['order_id']);
                    $customerreviewsModel->setReviewStatus(0);
                    $customerreviewsModel->setDate($timeStamp);
                    $customerreviewsModel->setName($data['name']);
                    $customerreviewsModel->setEmail($data['email']);
                    $customerreviewsModel->setRatingDelivery($data['rating_delivery']);
                    $customerreviewsModel->setRatingProduct($data['rating_product']);
                    $customerreviewsModel->setRatingCustomerSupport($data['rating_customer_support']);
                    $customerreviewsModel->setMessage($data['message']);
                    $customerreviewsModel->save();
                    Mage::getSingleton('customer/session')->addSuccess(Mage::helper('customerreviews')->__('Your review has been accepted for moderation. Thank you!'));
                    $this->_redirect('');                 
                }
            } catch (Exception $e) {
                Mage::getSingleton('customer/session')->addError($e->getMessage());
                return;
            }
        }
    }

}