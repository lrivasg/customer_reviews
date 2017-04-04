<?php
/**
 * 
 * @category	Lrg 
 * @package     Lrg_Customerreviews
 * @author      Luis Rivas <lrivasg.8@gmail.com>
 */
class Lrg_Customerreviews_Model_Adminhtml_System_Config_Source_Days
{
    public function toOptionArray()
    {
        $options = array();
        $days = range(1, 9);
        if (!empty($days)) {
            foreach ($days as $day) {
                $options[]= array('value'=>$day, 'label'=>Mage::helper('customerreviews')->__($day));
            }
        }
        return $options;
    }
}