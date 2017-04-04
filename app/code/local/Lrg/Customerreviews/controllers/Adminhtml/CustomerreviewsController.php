<?php
/**
 * Customerreviews customerreviews controller
 * 
 * @category	Lrg 
 * @package     Lrg_Customerreviews
 * @author      Luis Rivas <lrivasg.8@gmail.com>
 */
class Lrg_Customerreviews_Adminhtml_CustomerreviewsController extends Mage_Adminhtml_Controller_Action
{
  
    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('customerreviews/reviews')
            ->_addBreadcrumb(Mage::helper('adminhtml')->__('Reviews Manager'), Mage::helper('adminhtml')->__('Review Manager'));
        return $this;
    }  
    
    public function indexAction() {
        $this->_initAction();      
        $this->_addContent($this->getLayout()->createBlock('customerreviews/adminhtml_customerreviews'));
        $this->renderLayout();
    }
  
    public function editAction()
    {
        $customerreviewsId     = $this->getRequest()->getParam('review_id');
        $customerreviewsModel  = Mage::getModel('customerreviews/reviews')->load($customerreviewsId);
  
        if ($customerreviewsModel->getId() || $customerreviewsId == 0) {
  
            Mage::register('customerreviews_data', $customerreviewsModel);
  
            $this->loadLayout();
            $this->_setActiveMenu('customerreviews/reviews');
            
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Review Manager'), Mage::helper('adminhtml')->__('Review Manager'));
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Review News'), Mage::helper('adminhtml')->__('Review News'));
            
            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
            
            $this->_addContent($this->getLayout()->createBlock('customerreviews/adminhtml_customerreviews_edit'))
                 ->_addLeft($this->getLayout()->createBlock('customerreviews/adminhtml_customerreviews_edit_tabs'));
                
            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('customerreviews')->__('Review does not exist'));
            $this->_redirect('*/*/');
        }
    }
    
    public function newAction()
    {
        $this->_forward('edit');
    }
    
    public function saveAction() {
        if ($data = $this->getRequest()->getPost()) {
            
            $customerreviewsModel = Mage::getModel('customerreviews/reviews');		
            $customerreviewsModel->setData($data)->setId($this->getRequest()->getParam('id'));
			
            try {
                if (!$customerreviewsModel->getId()) {
                    $customerreviewsModel->setDate(now());
                }
                $customerreviewsModel->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('customerreviews')->__('Review was successfully saved'));
                Mage::getSingleton('adminhtml/session')->setCustomerreviewsData(false);

                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setCustomerreviewsData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('customerreviews')->__('Unable to find review to save'));
        $this->_redirect('*/*/');
    }
    
    public function deleteAction()
    {
        if ( $this->getRequest()->getParam('review_id') > 0 ) {
            try {
                $customerreviewsModel = Mage::getModel('customerreviews/reviews');
                
                $customerreviewsModel->setId($this->getRequest()->getParam('review_id'))->delete();
                    
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Review was successfully deleted'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('review_id')));
            }
        }
        $this->_redirect('*/*/');
    }
    
    public function massDeleteAction() {
        $reviewsIds = $this->getRequest()->getParam('customerreviews');
        if (!is_array($reviewsIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($reviewsIds as $reviewId) {
                    $review = Mage::getModel('customerreviews/reviews')->load($reviewId);
                    $review->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Total of %d record(s) were successfully deleted', count($reviewsIds)));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
    
    public function massStatusAction()
    {
        $reviewsIds = $this->getRequest()->getParam('customerreviews');
        if (!is_array($reviewsIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($reviewsIds as $reviewId) {
                    $review = Mage::getSingleton('customerreviews/reviews')
                        ->load($reviewId)
                        ->setReviewStatus($this->getRequest()->getParam('review_status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess($this->__('Total of %d record(s) were successfully updated', count($reviewsIds)));
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
               $this->getLayout()->createBlock('customerreviews/adminhtml_customerreviews_grid')->toHtml()
        );
    }
} 
