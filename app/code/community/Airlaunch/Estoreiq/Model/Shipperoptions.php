<?php

/**
 * My own options
 *
 */
class Airlaunch_Estoreiq_Model_Shipperoptions
{

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array('value' => 'auspost', 'label'=>Mage::helper('adminhtml')->__('Australia Post')),
        );
    }

}

?>
