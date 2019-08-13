<?php

/**
 * My own options
 *
 */
class Airlaunch_Estoreiq_Model_Fontoptions
{

    /**
     * Options getter
     *
     * @return array
     */
	 
		// arimo
		// asap
		// asul
		// cabin
		// cabincondensed
		// droidsans
		// droidserif
		// francoisone
		// lato
		// lobster
		// opensans
		// oswald
		// ptsans
		// ptserif
		// ubuntu
		// ubuntucondensed
		
		
    public function toOptionArray()
    {
        return array(
			array('value' => 'opensans', 'label'=>Mage::helper('adminhtml')->__('Open Sans (recommended)')),
            array('value' => 'arimo', 'label'=>Mage::helper('adminhtml')->__('Arimo')),
            array('value' => 'asap', 'label'=>Mage::helper('adminhtml')->__('Asap')),
            array('value' => 'asul', 'label'=>Mage::helper('adminhtml')->__('Asul')),
			array('value' => 'cabin', 'label'=>Mage::helper('adminhtml')->__('Cabin')),
			array('value' => 'cabincondensed', 'label'=>Mage::helper('adminhtml')->__('Cabin Condensed')),
			array('value' => 'droidsans', 'label'=>Mage::helper('adminhtml')->__('Droid Sans')),
			array('value' => 'droidserif', 'label'=>Mage::helper('adminhtml')->__('Droid Serif')),
			array('value' => 'francoisone', 'label'=>Mage::helper('adminhtml')->__('Francoisone')),
			array('value' => 'lato', 'label'=>Mage::helper('adminhtml')->__('Lato')),
			array('value' => 'lobster', 'label'=>Mage::helper('adminhtml')->__('Lobster')),
			array('value' => 'oswald', 'label'=>Mage::helper('adminhtml')->__('Oswald')),
			array('value' => 'ptsans', 'label'=>Mage::helper('adminhtml')->__('Pt Sans')),
			array('value' => 'ptserif', 'label'=>Mage::helper('adminhtml')->__('Pt Serif')),
			array('value' => 'ubuntu', 'label'=>Mage::helper('adminhtml')->__('Ubuntu')),
			array('value' => 'ubuntucondensed', 'label'=>Mage::helper('adminhtml')->__('Ubuntu Condensed')),
        );
    }

}

?>
