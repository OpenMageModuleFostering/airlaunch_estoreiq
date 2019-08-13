<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category   Mage
 * @package    Mage_Sales
 * @copyright  Copyright (c) 2008 Irubin Consulting Inc. DBA Varien (http://www.varien.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


/**
 * Sales Order Invoice PDF model
 *
 * @category   Mage
 * @package    Mage_Sales
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Airlaunch_Estoreiq_Model_Invoice extends Airlaunch_Estoreiq_Model_Abstract
{
    public function getPdf($invoices = array())
    {
        $this->_beforeGetPdf();
        $this->_initRenderer('invoice');
		
		$selected_font = Mage::getStoreConfig('estoreiq_options/messages/estoreiq_font_selected');
		
		if($selected_font == 'courier') {
			$the_font = Zend_Pdf_font::fontWithName(Zend_pdf_font::FONT_COURIER);
		}
		else if($selected_font == 'times') {
			$the_font = Zend_Pdf_font::fontWithName(Zend_pdf_font::FONT_TIMES);
		}
		else  {
			$the_font = Zend_Pdf_font::fontWithName(Zend_pdf_font::FONT_HELVETICA);
		}
		
        $pdf = new Zend_Pdf();
        $style = new Zend_Pdf_Style();
        //$this->_setFontBold($style, 10);
		
		
		 
		 
        foreach ($invoices as $invoice) {
            $page = $pdf->newPage(Zend_Pdf_Page::SIZE_A4);
            $pdf->pages[] = $page;

            $order = $invoice->getOrder();
			
			$page->setFont($the_font, 10);
			
			
            /* Add image */
            $this->insertLogo($page, $invoice->getStore());

            
			
			/* Add address */
            $this->insertAddress($page, $invoice->getStore());
			
			

            /* Add head */
            $this->insertOrder($page, $order, Mage::getStoreConfigFlag(self::XML_PATH_SALES_PDF_INVOICE_PUT_ORDER_ID, $order->getStoreId()));

            
            
            
			
			 /* Add image 2 */
            $this->insertLogo2($page, $invoice->getStore());
			
			
			
            $page->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
            //$this->_setFontBold($style, 26);
			
			$page->setFont($the_font, 24);
            $page->drawText('TAX INVOICE (regular invoice)', 335, 580, 'UTF-8');
			
			
            /* Add Barcode (custom: Matt Johnson 2008-06-13)*/
            /* convertToBarcodeString resides in extended abstract.php file*/
            $barcodeString = $this->convertToBarcodeString($order->getRealOrderId());
			
			

            $page->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
            $page->setFont(Zend_Pdf_Font::fontWithPath(dirname(__FILE__)  . '/' . 'Code128bWin.ttf'), 22);
			
			
			$qr_code_activated = Mage::getStoreConfig('estoreiq_options/messages/estoreiq_qr_detection_code_enabled');
			
			if($qr_code_activated == '1') {
				$page->drawText($barcodeString, 420, 755, 'CP1252');
            }
            
            
			$this->y -= 50;
			
			
            $page->setFillColor(new Zend_Pdf_Color_RGB(0, 0, 0));
            $this->_setFontRegular($page);
            //$page->drawText(Mage::helper('sales')->__('Invoice # ') . $invoice->getIncrementId(), 35, 780, 'UTF-8');

            /* Add table */
            $page->setFillColor(new Zend_Pdf_Color_RGB(0.93, 0.92, 0.92));
            $page->setLineColor(new Zend_Pdf_Color_GrayScale(0.5));
            $page->setLineWidth(0.5);

            //$page->drawRectangle(25, $this->y, 570, $this->y -15);
            $this->y -=10;

            /* Add table head */
            $page->setFillColor(new Zend_Pdf_Color_RGB(0.4, 0.4, 0.4));
            $page->drawText(Mage::helper('sales')->__('Product').$qr_code_activated, 35, $this->y, 'UTF-8');
            //$page->drawText(Mage::helper('sales')->__('SKU'), 240, $this->y, 'UTF-8');
            $page->drawText(Mage::helper('sales')->__('Price'), 380, $this->y, 'UTF-8');
            $page->drawText(Mage::helper('sales')->__('QTY'), 430, $this->y, 'UTF-8');
            $page->drawText(Mage::helper('sales')->__('Tax'), 480, $this->y, 'UTF-8');
            $page->drawText(Mage::helper('sales')->__('Subtotal'), 535, $this->y, 'UTF-8');

            $this->y -=15;

            $page->setFillColor(new Zend_Pdf_Color_GrayScale(0));

            /* Add body */
            foreach ($invoice->getAllItems() as $item){
                if ($item->getOrderItem()->getParentItem()) {
                    continue;
                }

                $shift = array();
                if ($this->y<15) {
                    /* Add new table head */
                    $page = $pdf->newPage(Zend_Pdf_Page::SIZE_A4);
                    $pdf->pages[] = $page;
                    $this->y = 800;

                    $this->_setFontRegular($page);
                    $page->setFillColor(new Zend_Pdf_Color_RGB(0.93, 0.92, 0.92));
                    $page->setLineColor(new Zend_Pdf_Color_GrayScale(0.5));
                    $page->setLineWidth(0.5);
                    //$page->drawRectangle(25, $this->y, 570, $this->y-15);
                    $this->y -=10;

                    $page->setFillColor(new Zend_Pdf_Color_RGB(0.4, 0.4, 0.4));
                    $page->drawText(Mage::helper('sales')->__('Product'), 35, $this->y, 'UTF-8');
                    //$page->drawText(Mage::helper('sales')->__('SKU'), 240, $this->y, 'UTF-8');
                    $page->drawText(Mage::helper('sales')->__('Price'), 380, $this->y, 'UTF-8');
                    $page->drawText(Mage::helper('sales')->__('QTY'), 430, $this->y, 'UTF-8');
                    $page->drawText(Mage::helper('sales')->__('Tax'), 480, $this->y, 'UTF-8');
                    $page->drawText(Mage::helper('sales')->__('Subtotal'), 535, $this->y, 'UTF-8');

                    $page->setFillColor(new Zend_Pdf_Color_GrayScale(0));
                    $this->y -=20;
                }
				

                /* Draw item */
                $this->_drawItem($item, $page, $order);
            }

            /* Add totals */
            $this->insertTotals($page, $invoice);
        }

        $this->_afterGetPdf();

        return $pdf;
    }
}
