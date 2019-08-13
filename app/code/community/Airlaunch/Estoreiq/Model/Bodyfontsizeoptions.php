<?php

/**
 * My own options
 *
 */
class Airlaunch_Estoreiq_Model_Bodyfontsizeoptions
{

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
			array('value' => 'regular', 'label'=>Mage::helper('adminhtml')->__('Regular')),
            array('value' => 'small', 'label'=>Mage::helper('adminhtml')->__('Small')),
            array('value' => 'large', 'label'=>Mage::helper('adminhtml')->__('Large')),
        );
    }

}

?>
