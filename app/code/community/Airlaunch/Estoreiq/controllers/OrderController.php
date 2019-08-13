<?php

class Airlaunch_Estoreiq_OrderController extends Mage_Sales_Controller_Abstract {    


	public function pdfRmaAction() {
		$orderIds = $this->getRequest()->getPost('order_ids');
		
		$orderIds = explode(',',$orderIds);
		
        $flag = false;
        if (!empty($orderIds)) {
            foreach ($orderIds as $orderId) {
			
			
				// prepare our invoices
                $invoices = Mage::getResourceModel('sales/order_invoice_collection')
                    ->setOrderFilter($orderId)
                    ->load();
					
                if ($invoices->getSize() > 0) {
				
                    $flag = true;
                    if (!isset($pdf)){
					
                        $pdf = $this->getPdf($invoices);
						
                    } else {
					
                        $pages = $this->getPdf($invoices);
                        $pdf->pages = array_merge ($pdf->pages, $pages->pages);
						
                    }
					
                }
				
				
				
            }
            if ($flag) {
                return $this->_prepareDownloadResponse(
                    'customised-pdf-'.Mage::getSingleton('core/date')->date('Y-m-d_H-i-s').'.pdf', $pdf->render(),
                    'application/pdf'
                );
            } else {
              //  $this->_getSession()->addError($this->__('There are no printable documents related to selected orders.'));
               // $this->_redirect('*/*/');
            }
        }
        //$this->_redirect('*/*/');
	}

	
	
	
	
	
	
	
	
	/////////////////////////////////////////
	// PDF OBJECT
	
	
	
	 /**
     * Draw header for item table
     *
     * @param Zend_Pdf_Page $page
     * @return void
     */
    protected function _drawHeader(Zend_Pdf_Page $page)
    {
	
		
		
        /* Add table head */
        $this->_setFontRegular($page, 10);
        $page->setFillColor(new Zend_Pdf_Color_GrayScale(0.92));
        $page->setLineColor(new Zend_Pdf_Color_GrayScale(0.5));
        $page->setLineWidth(0.5);
        $page->drawRectangle(25, $this->y, 570, $this->y -15);
        $this->y -= 10;
        $page->setFillColor(new Zend_Pdf_Color_GrayScale(0));

        //columns headers
        $lines[0][] = array(
            'text' => Mage::helper('sales')->__('Products'),
            'feed' => 25
        );

        $lines[0][] = array(
            'text'  => Mage::helper('sales')->__('SKU'),
            'feed'  => 290,
            'align' => 'right'
        );

        $lines[0][] = array(
            'text'  => Mage::helper('sales')->__('Qty'),
            'feed'  => 435,
            'align' => 'right'
        );

        $lines[0][] = array(
            'text'  => Mage::helper('sales')->__('Price'),
            'feed'  => 360,
            'align' => 'right'
        );

        $lines[0][] = array(
            'text'  => Mage::helper('sales')->__('Tax'),
            'feed'  => 495,
            'align' => 'right'
        );

        $lines[0][] = array(
            'text'  => Mage::helper('sales')->__('Subtotal'),
            'feed'  => 565,
            'align' => 'right'
        );

        $lineBlock = array(
            'lines'  => $lines,
            'height' => 5
        );

        $this->drawLineBlocks($page, array($lineBlock), array('table_header' => true));
        $page->setFillColor(new Zend_Pdf_Color_GrayScale(0));
        $this->y -= 20;
    }

   

    /**
     * Return PDF document
     *
     * @param  array $invoices
     * @return Zend_Pdf
     */
    public function getPdf($invoices = array())
    {
	
        $this->_beforeGetPdf();
        $this->_initRenderer('invoice');
		
		
		// Get our Font from settings		
		$selected_font = Mage::getStoreConfig('estoreiq_options/messages/estoreiq_font_selected');
		
		if($selected_font == 'opensans') {	$font = Zend_Pdf_Font::fontWithPath(dirname(__FILE__)  . '/fonts/opensans/' . 'OpenSans-Regular.ttf');	}
		else if($selected_font == 'arimo') {	$font = Zend_Pdf_Font::fontWithPath(dirname(__FILE__)  . '/fonts/arimo/' . 'Arimo-Regular.ttf');	}
		else if($selected_font == 'asap') {	$font = Zend_Pdf_Font::fontWithPath(dirname(__FILE__)  . '/fonts/asap/' . 'Asap-Regular.ttf');	}
		else if($selected_font == 'asul') {	$font = Zend_Pdf_Font::fontWithPath(dirname(__FILE__)  . '/fonts/asul/' . 'Asul-Regular.ttf');	}
		else if($selected_font == 'cabin') {	$font = Zend_Pdf_Font::fontWithPath(dirname(__FILE__)  . '/fonts/cabin/' . 'Cabin-Regular.ttf');	}
		else if($selected_font == 'cabincondensed') {	$font = Zend_Pdf_Font::fontWithPath(dirname(__FILE__)  . '/fonts/cabincondensed/' . 'CabinCondensed-Regular.ttf');	}
		else if($selected_font == 'droidsans') {	$font = Zend_Pdf_Font::fontWithPath(dirname(__FILE__)  . '/fonts/droid/' . 'DroidSansMono-Regular.ttf');	}
		else if($selected_font == 'droidserif') {	$font = Zend_Pdf_Font::fontWithPath(dirname(__FILE__)  . '/fonts/droid/' . 'DroidSerif-Regular.ttf');	}
		else if($selected_font == 'francoisone') {	$font = Zend_Pdf_Font::fontWithPath(dirname(__FILE__)  . '/fonts/francoisone/' . 'FrancoisOne.ttf');	}
		else if($selected_font == 'lato') {	$font = Zend_Pdf_Font::fontWithPath(dirname(__FILE__)  . '/fonts/lato/' . 'Lato-Regular.ttf');	}
		else if($selected_font == 'latoblack') {	$font = Zend_Pdf_Font::fontWithPath(dirname(__FILE__)  . '/fonts/lato/' . 'Lato-Black.ttf');	}
		else if($selected_font == 'lobster') {	$font = Zend_Pdf_Font::fontWithPath(dirname(__FILE__)  . '/fonts/lobster/' . 'Lobster.ttf');	}
		else if($selected_font == 'oswald') {	$font = Zend_Pdf_Font::fontWithPath(dirname(__FILE__)  . '/fonts/oswald/' . 'Oswald-Regular.ttf');	}
		else if($selected_font == 'ptsans') {	$font = Zend_Pdf_Font::fontWithPath(dirname(__FILE__)  . '/fonts/ptsans/' . 'PT_Sans-Web-Regular.ttf');	}
		else if($selected_font == 'ptserif') {	$font = Zend_Pdf_Font::fontWithPath(dirname(__FILE__)  . '/fonts/ptserif/' . 'PT_Serif-Web-Regular.ttf');	}
		else if($selected_font == 'ubuntu') {	$font = Zend_Pdf_Font::fontWithPath(dirname(__FILE__)  . '/fonts/ubuntu/' . 'Ubuntu-Regular.ttf');	}
		else if($selected_font == 'ubuntucondensed') {	$font = Zend_Pdf_Font::fontWithPath(dirname(__FILE__)  . '/fonts/ubuntu/' . 'UbuntuCondensed-Regular.ttf');	}
		else  {	$font = Zend_Pdf_Font::fontWithPath(dirname(__FILE__)  . '/fonts/opensans/' . 'OpenSans-Regular.ttf');	}		

		

        $pdf = new Zend_Pdf();
        $this->_setPdf($pdf);
        $style = new Zend_Pdf_Style();
        $this->_setFontBold($style, 10);
		//$this->setFont($font, 10);

        foreach ($invoices as $invoice) {
            if ($invoice->getStoreId()) {
                Mage::app()->getLocale()->emulate($invoice->getStoreId());
                Mage::app()->setCurrentStore($invoice->getStoreId());
            }
            $page  = $this->newPage();
			
			
			// Font from settings
			$size=10;
			$selected_headingsize = Mage::getStoreConfig('estoreiq_options/messages/estoreiq_heading_font_size_selected');

			if($selected_headingsize == 'small') {
				$size -= 1;
			}
			else if($selected_headingsize == 'large') {
				$size += 1;
			}
			
			$page->setFont($font, $size);
			
			
            $order = $invoice->getOrder();
            /* Add image */
           
			
			
			$this->y = 815;
			
			
			
			
			// drawRectangle ( LEFT OFFSET, TOP OFFSET, RIGHT OFFSET, BOTTOM OFFSET )
			
			// --- PAGE SIZE ---
			// 595 WIDTH
			// 842 HEIGHT

			
			$white = new Zend_Pdf_Color_GrayScale(1);
			$lightgrey = new Zend_Pdf_Color_GrayScale(0.2);
			$black = new Zend_Pdf_Color_GrayScale(0.0);
			
			$page->setLineWidth(0.1);
			$page->setFillColor($white);
			$page->setLineColor($lightgrey);
			
			//$page->drawRectangle(3, 810, 228, 687);
			
			
			
			//$page->drawRectangle(228, 734, 595, 601);
			
			
			
			//$page->drawRectangle(0, 580, 600, 581);
			
			//$page->setFillColor($white);
			//$page->setLineColor($black);
			//$page->drawRectangle(1, 200, 594, 1);
			
			
			$this->insertLogo($page, $invoice->getStore());
			
			$this->insertLogo2($page, $invoice->getStore());
			
			
			$this->insertLogo3($page, $invoice->getStore());
			
			$size=10;
			$selected_headingsize = Mage::getStoreConfig('estoreiq_options/messages/estoreiq_heading_font_size_selected');

			if($selected_headingsize == 'small') {
				$size -= 1;
			}
			else if($selected_headingsize == 'large') {
				$size += 1;
			}
			
			$page->setFont($font, $size);
			
			$page->setFont($font, $size);
			
			$page->setFillColor($black);
           // $page->drawText('AREA 1', 68, 715, 'UTF-8');
		   
		   
		   
		   
		   
			// Add Barcode
            $barcodeString = $this->convertToBarcodeString($order->getRealOrderId());
			
			
			
			$qr_code_activated = Mage::getStoreConfig('estoreiq_options/messages/estoreiq_qr_detection_code_enabled');
			
			
				
			$page->setFillColor(new Zend_Pdf_Color_Grayscale(0, 0, 0));
			$page->setFont(Zend_Pdf_Font::fontWithPath(dirname(__FILE__)  . '/' . 'Code128bWin.ttf'), 22);
				
				
				
			if($qr_code_activated == '1') {
				$page->drawText($barcodeString, 400, 785, 'CP1252');
				
				
			
				// QR CODE
				

            }
			
			
			$this->_setFontRegular($page);
			
			
			$size=11;
			$selected_bodysize = Mage::getStoreConfig('estoreiq_options/messages/estoreiq_body_font_size_selected');

			if($selected_bodysize == 'small') {
				$size -= 1;
			}
			else if($selected_bodysize == 'large') {
				$size += 1;
			}
			
			$page->setFont($font, $size);
			
			
			// small label text
			$page->setFillColor(new Zend_Pdf_Color_GrayScale(0.1));
            $page->setLineColor(new Zend_Pdf_Color_GrayScale(0.1));
			
			$selected_smallmessage = Mage::getStoreConfig('estoreiq_options/messages/estoreiq_smallmessage');
			$selected_smallmessage2 = Mage::getStoreConfig('estoreiq_options/messages/estoreiq_smallmessage2');
			
			$page->drawText($selected_smallmessage, 35, 740, 'UTF-8');
			
			
			$page->drawText($selected_smallmessage2, 35, 725, 'UTF-8');
			
			
			
			// big label text
			/*
			$page->setFillColor(new Zend_Pdf_Color_GrayScale(0.1));
            $page->setLineColor(new Zend_Pdf_Color_GrayScale(0.1));
			$page->drawText('Firstname Lastname', 	280, 700, 'UTF-8');
			$page->drawText('Address 1', 			280, 685, 'UTF-8');
			$page->drawText('State, 3000', 			280, 670, 'UTF-8');
			$page->drawText('Country', 				280, 655, 'UTF-8');
			$page->drawText('T: 0400000000', 		280, 640, 'UTF-8');
			*/
			
						
			
			// tear off top text
			$page->setFont($font, 14);
			
			$selected_tearoffmessage = Mage::getStoreConfig('estoreiq_options/messages/estoreiq_tearoffmessage');
			
			$page->drawText($selected_tearoffmessage, 	345, 530, 'UTF-8');
			
			
			
			// footer message
			$selected_headersize = Mage::getStoreConfig('estoreiq_options/messages/estoreiq_header_font_size_selected');

			if($selected_headersize == 'small') {
				$size -= 1;
			}
			else if($selected_headersize == 'large') {
				$size += 1;
			}
			$page->setFont($font, $size);
			
			$selected_takeiteasymessage = Mage::getStoreConfig('estoreiq_options/messages/estoreiq_takeiteasymessage');

			$page->drawText($selected_takeiteasymessage, 	25, 25, 'UTF-8');

			
			
			
			$page->setFont($font, 11);
			
			
			$this->y -= 100;
			
			
			// Headings
            //$page->drawText(Mage::helper('sales')->__('Invoice # ') . $invoice->getIncrementId(), 25, 780, 'UTF-8');
			
			
			
			
			
            /* Add table */
            $page->setFillColor(new Zend_Pdf_Color_GrayScale(0.1));
            $page->setLineColor(new Zend_Pdf_Color_GrayScale(0.1));
            $page->setLineWidth(0.5);

            //$page->drawRectangle(25, $this->y, 570, $this->y -15);
            $this->y -=10;

            /* Add table head */
         
            $page->drawText(Mage::helper('sales')->__('Product'), 25, $this->y, 'UTF-8');
            $page->drawText(Mage::helper('sales')->__('SKU'), 240, $this->y, 'UTF-8');
            $page->drawText(Mage::helper('sales')->__('Price'), 368, $this->y, 'UTF-8');
            $page->drawText(Mage::helper('sales')->__('QTY'), 425, $this->y, 'UTF-8');
            $page->drawText(Mage::helper('sales')->__('Tax'), 475, $this->y, 'UTF-8');
            $page->drawText(Mage::helper('sales')->__('Subtotal'), 528, $this->y, 'UTF-8');
			
			$this->y -= 12;
			
			$page->setFillColor(new Zend_Pdf_Color_GrayScale(0.9));
            $page->setLineColor(new Zend_Pdf_Color_GrayScale(0.9));
            $page->setLineWidth(0.5);
            $page->drawRectangle(25, $this->y, 570, $this->y);
					
					
					
			$page->setFillColor(new Zend_Pdf_Color_GrayScale(0.1));
            $page->setLineColor(new Zend_Pdf_Color_GrayScale(0.1));
			
			
			$this->y -= 38;
			
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
                    $page->setFillColor(new Zend_Pdf_Color_GrayScale(0.2));
                    $page->setLineColor(new Zend_Pdf_Color_GrayScale(0.2));
                    $page->setLineWidth(0.5);
                    //$page->drawRectangle(25, $this->y, 570, $this->y-15);
                    $this->y -=10;

                    $page->setFillColor(new Zend_Pdf_Color_GrayScale(0.4));
                    $page->drawText(Mage::helper('sales')->__('Product'), 25, $this->y, 'UTF-8');
                    $page->drawText(Mage::helper('sales')->__('SKU'), 240, $this->y, 'UTF-8');
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
			
			
			$this->y -=10;
			
			
			$page->setFillColor(new Zend_Pdf_Color_GrayScale(0.9));
            $page->setLineColor(new Zend_Pdf_Color_GrayScale(0.9));
            $page->setLineWidth(0.5);
            $page->drawRectangle(25, $this->y, 570, $this->y);
			
			$page->setFillColor(new Zend_Pdf_Color_GrayScale(0.1));
            $page->setLineColor(new Zend_Pdf_Color_GrayScale(0.1));
			
			
			// Add totals
            $this->insertTotals($page, $invoice);
            if ($invoice->getStoreId()) {
                Mage::app()->getLocale()->revert();
            }
			
			
			
			
			// Add order ID and date to tear off top left
			$page->drawText(
                Mage::helper('sales')->__('Order #: ') . $order->getRealOrderId(), 25, 485, 'UTF-8'
            );
			
			
			$page->drawText(
				Mage::helper('sales')->__('Date: ') . Mage::helper('core')->formatDate(
					$order->getCreatedAtStoreDate(), 'medium', false
				),
				25,
				470,
				'UTF-8'
			);
			
			
			// Add shipping address to big label
			if ($obj instanceof Mage_Sales_Model_Order) {
				$shipment = null;
				$order = $obj;
			} elseif ($obj instanceof Mage_Sales_Model_Order_Shipment) {
				$shipment = $obj;
				$order = $shipment->getOrder();
			}
			
			
			/* Billing Address */
			$billingAddress = $this->_formatAddress($order->getBillingAddress()->format('pdf'));

			/* Payment */
			$paymentInfo = Mage::helper('payment')->getInfoBlock($order->getPayment())
				->setIsSecureMode(true)
				->toPdf();
			$paymentInfo = htmlspecialchars_decode($paymentInfo, ENT_QUOTES);
			$payment = explode('{{pdf_row_separator}}', $paymentInfo);
			foreach ($payment as $key=>$value){
				if (strip_tags(trim($value)) == '') {
					unset($payment[$key]);
				}
			}
			reset($payment);

			/* Shipping Address and Method */
			if (!$order->getIsVirtual()) {
				/* Shipping Address */
				$shippingAddress = $this->_formatAddress($order->getShippingAddress()->format('pdf'));
				$shippingMethod  = $order->getShippingDescription();
			}
			
			
			
			$size=11;
			$selected_bodysize = Mage::getStoreConfig('estoreiq_options/messages/estoreiq_body_font_size_selected');

			if($selected_bodysize == 'small') {
				$size -= 3;
			}
			else if($selected_bodysize == 'large') {
				$size -= 1;
			}
			else {
				$size -= 2;
			}
			
			$page->setFont($font, $size);
			
			
			if (!$order->getIsVirtual()) {
				$this->y = 715;
				foreach ($shippingAddress as $value){
					if ($value!=='') {
						$text = array();
						foreach (Mage::helper('core/string')->str_split($value, 45, true, true) as $_value) {
							$text[] = $_value;
						}
						foreach ($text as $part) {
						
							if(strpos($part,'F:') == false) { 
								$page->drawText(strip_tags(ltrim($part)), 285, $this->y, 'UTF-8');
								$this->y -= 14;
							}
						
						}
					}
				}


				

			}
		
			
		
		
			//$page->drawText('AREA 2', 396, 665, 'UTF-8');
			
			
            /* Add address */
           // $this->insertAddress($page, $invoice->getStore());
            /* Add head */
            //$this->insertOrder(
                //$page,
                //$order,
                //Mage::getStoreConfigFlag(self::XML_PATH_SALES_PDF_INVOICE_PUT_ORDER_ID, $order->getStoreId())
           // );
            /* Add document text and number */
            //$this->insertDocumentNumber(
               // $page,
               // Mage::helper('sales')->__('Invoice # ') . $invoice->getIncrementId()
            //);
            /* Add table */
            //$this->_drawHeader($page);
            /* Add body */
            //foreach ($invoice->getAllItems() as $item){
                //if ($item->getOrderItem()->getParentItem()) {
                   // continue;
               // }
                /* Draw item */
               // $this->_drawItem($item, $page, $order);
               // $page = end($pdf->pages);
           // }
          
        }
        $this->_afterGetPdf();
        return $pdf;
    }

    /**
     * Create new page and assign to PDF object
     *
     * @param  array $settings
     * @return Zend_Pdf_Page
     */
    public function newPage(array $settings = array())
    {
        /* Add new table head */
        $page = $this->_getPdf()->newPage(Zend_Pdf_Page::SIZE_A4);
        $this->_getPdf()->pages[] = $page;
        $this->y = 800;
        if (!empty($settings['table_header'])) {
            $this->_drawHeader($page);
        }
        return $page;
    }
	
	
	
	
	
	
	
	
	
	
	
	/////////////////////////////////////////
	// ABSTRACT OBJECT
	
	
	
	/**
     * Y coordinate
     *
     * @var int
     */
    public $y;

    /**
     * Item renderers with render type key
     *
     * model    => the model name
     * renderer => the renderer model
     *
     * @var array
     */
    protected $_renderers = array();

    /**
     * Predefined constants
     */
    const XML_PATH_SALES_PDF_INVOICE_PUT_ORDER_ID       = 'sales_pdf/invoice/put_order_id';
    const XML_PATH_SALES_PDF_SHIPMENT_PUT_ORDER_ID      = 'sales_pdf/shipment/put_order_id';
    const XML_PATH_SALES_PDF_CREDITMEMO_PUT_ORDER_ID    = 'sales_pdf/creditmemo/put_order_id';

    /**
     * Zend PDF object
     *
     * @var Zend_Pdf
     */
    protected $_pdf;

    /**
     * Default total model
     *
     * @var string
     */
    protected $_defaultTotalModel = 'sales/order_pdf_total_default';

    /**
     * Retrieve PDF
     *
     * @return Zend_Pdf
     */

    /**
     * Returns the total width in points of the string using the specified font and
     * size.
     *
     * This is not the most efficient way to perform this calculation. I'm
     * concentrating optimization efforts on the upcoming layout manager class.
     * Similar calculations exist inside the layout manager class, but widths are
     * generally calculated only after determining line fragments.
     *
     * @param  string $string
     * @param  Zend_Pdf_Resource_Font $font
     * @param  float $fontSize Font size in points
     * @return float
     */
    public function widthForStringUsingFontSize($string, $font, $fontSize)
    {
        $drawingString = '"libiconv"' == ICONV_IMPL ?
            iconv('UTF-8', 'UTF-16BE//IGNORE', $string) :
            @iconv('UTF-8', 'UTF-16BE', $string);

        $characters = array();
        for ($i = 0; $i < strlen($drawingString); $i++) {
            $characters[] = (ord($drawingString[$i++]) << 8) | ord($drawingString[$i]);
        }
        $glyphs = $font->glyphNumbersForCharacters($characters);
        $widths = $font->widthsForGlyphs($glyphs);
        $stringWidth = (array_sum($widths) / $font->getUnitsPerEm()) * $fontSize;
        return $stringWidth;

    }

    /**
     * Calculate coordinates to draw something in a column aligned to the right
     *
     * @param  string $string
     * @param  int $x
     * @param  int $columnWidth
     * @param  Zend_Pdf_Resource_Font $font
     * @param  int $fontSize
     * @param  int $padding
     * @return int
     */
    public function getAlignRight($string, $x, $columnWidth, Zend_Pdf_Resource_Font $font, $fontSize, $padding = 5)
    {
        $width = $this->widthForStringUsingFontSize($string, $font, $fontSize);
        return $x + $columnWidth - $width - $padding;
    }

    /**
     * Calculate coordinates to draw something in a column aligned to the center
     *
     * @param  string $string
     * @param  int $x
     * @param  int $columnWidth
     * @param  Zend_Pdf_Resource_Font $font
     * @param  int $fontSize
     * @return int
     */
    public function getAlignCenter($string, $x, $columnWidth, Zend_Pdf_Resource_Font $font, $fontSize)
    {
        $width = $this->widthForStringUsingFontSize($string, $font, $fontSize);
        return $x + round(($columnWidth - $width) / 2);
    }

    /**
     * Insert logo to pdf page
     *
     * @param Zend_Pdf_Page $page
     * @param null $store
     */
    protected function insertLogo(&$page, $store = null)
    {
        $this->y = $this->y ? $this->y : 815;
		
		
		// Get logo from Settings
		$eye_logo_image = Mage::getStoreConfig('estoreiq_options/messages/estoreiq_logo');
		$image =	 Mage::getBaseDir('media') . '/estoreiq-logo/' . $eye_logo_image;
        //$image = Mage::getStoreConfig('sales/identity/logo', $store);
		
		
		
		
        if ($eye_logo_image) {
           
            if (is_file($image)) {
                $image       = Zend_Pdf_Image::imageWithPath($image);
                $top         = 800; //top border of the page
                $widthLimit  = 180; //half of the page width //270
                $heightLimit = 40; //assuming the image is not a "skyscraper" //270
                $width       = $image->getPixelWidth();
                $height      = $image->getPixelHeight();

                //preserving aspect ratio (proportions)
                $ratio = $width / $height;
                if ($ratio > 1 && $width > $widthLimit) {
                    $width  = $widthLimit;
                    $height = $width / $ratio;
                } elseif ($ratio < 1 && $height > $heightLimit) {
                    $height = $heightLimit;
                    $width  = $height * $ratio;
                } elseif ($ratio == 1 && $height > $heightLimit) {
                    $height = $heightLimit;
                    $width  = $widthLimit;
                }

                $y1 = $top - $height;
                $y2 = $top;
                $x1 = 25;
                $x2 = $x1 + $width;

                //coordinates after transformation are rounded by Zend
                $page->drawImage($image, $x1, $y1, $x2, $y2);
				
			
                $this->y = $y1 - 10;
            }
        }
		
		
		
		
		
    }
	
	
	
	 /**
     * Insert logo2 to pdf page
     *
     * @param Zend_Pdf_Page $page
     * @param null $store
     */
    protected function insertLogo2(&$page, $store = null)
    {
       
		
       $eye_logo_image = Mage::getStoreConfig('estoreiq_options/messages/estoreiq_logo2');
		
	   $image =	 Mage::getBaseDir('media') . '/estoreiq-logo/' . $eye_logo_image;
		
        if ($eye_logo_image) {
        
            if (is_file($image)) {
                $image       = Zend_Pdf_Image::imageWithPath($image);
                $top         = 575; //top border of the page
                $widthLimit  = 180; //half of the page width
                $heightLimit = 40; //assuming the image is not a "skyscraper"
                $width       = $image->getPixelWidth();
                $height      = $image->getPixelHeight();

                //preserving aspect ratio (proportions)
                $ratio = $width / $height;
                if ($ratio > 1 && $width > $widthLimit) {
                    $width  = $widthLimit;
                    $height = $width / $ratio;
                } elseif ($ratio < 1 && $height > $heightLimit) {
                    $height = $heightLimit;
                    $width  = $height * $ratio;
                } elseif ($ratio == 1 && $height > $heightLimit) {
                    $height = $heightLimit;
                    $width  = $widthLimit;
                }

                $y1 = $top - $height;
                $y2 = $top;
                $x1 = 25;
                $x2 = $x1 + $width;

                //coordinates after transformation are rounded by Zend
                $page->drawImage($image, $x1, $y1, $x2, $y2);

                $this->y = $y1 - 10;
            }
        }
    }
	
	
		 /**
     * Insert logo2 to pdf page
     *
     * @param Zend_Pdf_Page $page
     * @param null $store
     */
    protected function insertLogo3(&$page, $store = null)
    {
       
		
       $eye_logo_image = Mage::getStoreConfig('estoreiq_options/messages/estoreiq_logo3');
		
	   $image =	 Mage::getBaseDir('media') . '/estoreiq-logo/' . $eye_logo_image;
		
        if ($eye_logo_image) {
        
            if (is_file($image)) {
                $image       = Zend_Pdf_Image::imageWithPath($image);
                $top         = 75; //top border of the page
                $widthLimit  = 120; //half of the page width
                $heightLimit = 20; //assuming the image is not a "skyscraper"
                $width       = $image->getPixelWidth();
                $height      = $image->getPixelHeight();

                //preserving aspect ratio (proportions)
                $ratio = $width / $height;
                if ($ratio > 1 && $width > $widthLimit) {
                    $width  = $widthLimit;
                    $height = $width / $ratio;
                } elseif ($ratio < 1 && $height > $heightLimit) {
                    $height = $heightLimit;
                    $width  = $height * $ratio;
                } elseif ($ratio == 1 && $height > $heightLimit) {
                    $height = $heightLimit;
                    $width  = $widthLimit;
                }

                $y1 = $top - $height;
                $y2 = $top;
                $x1 = 25;
                $x2 = $x1 + $width;

                //coordinates after transformation are rounded by Zend
                $page->drawImage($image, $x1, $y1, $x2, $y2);

               
            }
        }
    }
	
	
	

    /**
     * Insert address to pdf page
     *
     * @param Zend_Pdf_Page $page
     * @param null $store
     */
    protected function insertAddress(&$page, $store = null)
    {
        $page->setFillColor(new Zend_Pdf_Color_GrayScale(0));
        $font = $this->_setFontRegular($page, 10);
        $page->setLineWidth(0);
        $this->y = $this->y ? $this->y : 815;
        $top = 815;
        foreach (explode("\n", Mage::getStoreConfig('sales/identity/address', $store)) as $value){
            if ($value !== '') {
                $value = preg_replace('/<br[^>]*>/i', "\n", $value);
                foreach (Mage::helper('core/string')->str_split($value, 45, true, true) as $_value) {
                    $page->drawText(trim(strip_tags($_value)),
                        $this->getAlignRight($_value, 130, 440, $font, 10),
                        $top,
                        'UTF-8');
                    $top -= 10;
                }
            }
        }
        $this->y = ($this->y > $top) ? $top : $this->y;
    }

    /**
     * Format address
     *
     * @param  string $address
     * @return array
     */
    protected function _formatAddress($address)
    {
        $return = array();
        foreach (explode('|', $address) as $str) {
            foreach (Mage::helper('core/string')->str_split($str, 45, true, true) as $part) {
                if (empty($part)) {
                    continue;
                }
                $return[] = $part;
            }
        }
        return $return;
    }

    /**
     * Calculate address height
     *
     * @param  array $address
     * @return int Height
     */
    protected function _calcAddressHeight($address)
    {
        $y = 0;
        foreach ($address as $value){
            if ($value !== '') {
                $text = array();
                foreach (Mage::helper('core/string')->str_split($value, 55, true, true) as $_value) {
                    $text[] = $_value;
                }
                foreach ($text as $part) {
                    $y += 15;
                }
            }
        }
        return $y;
    }

    /**
     * Insert order to pdf page
     *
     * @param Zend_Pdf_Page $page
     * @param Mage_Sales_Model_Order $obj
     * @param bool $putOrderId
     */
    protected function insertOrder(&$page, $obj, $putOrderId = true)
    {
        if ($obj instanceof Mage_Sales_Model_Order) {
            $shipment = null;
            $order = $obj;
        } elseif ($obj instanceof Mage_Sales_Model_Order_Shipment) {
            $shipment = $obj;
            $order = $shipment->getOrder();
        }

       // $this->y = $this->y ? $this->y : 815;
       
        //$page->setFillColor(new Zend_Pdf_Color_GrayScale(0.45));
        //$page->setLineColor(new Zend_Pdf_Color_GrayScale(0.45));
        //$page->drawRectangle(25, $top, 570, $top - 55);
       // $page->setFillColor(new Zend_Pdf_Color_GrayScale(1));
      //  $this->setDocHeaderCoordinates(array(25, $top, 570, $top - 55));
        $this->_setFontRegular($page, 10);

        if ($putOrderId) {
            $page->drawText(
                Mage::helper('sales')->__('Order #: ') . $order->getRealOrderId(), 25, 485, 'UTF-8'
            );
        }
        $page->drawText(
            Mage::helper('sales')->__('Date: ') . Mage::helper('core')->formatDate(
                $order->getCreatedAtStoreDate(), 'medium', false
            ),
            25,
            470,
            'UTF-8'
        );
		
		
	
			

		
		
        $top -= 10;
        $page->setFillColor(new Zend_Pdf_Color_GrayScale(0.92));
        $page->setLineColor(new Zend_Pdf_Color_GrayScale(0.5));
        $page->setLineWidth(0.5);
        $page->drawRectangle(25, $top, 275, ($top - 25));
        $page->drawRectangle(275, $top, 570, ($top - 25));

        /* Calculate blocks info */

        /* Billing Address */
        $billingAddress = $this->_formatAddress($order->getBillingAddress()->format('pdf'));

        /* Payment */
        $paymentInfo = Mage::helper('payment')->getInfoBlock($order->getPayment())
            ->setIsSecureMode(true)
            ->toPdf();
        $paymentInfo = htmlspecialchars_decode($paymentInfo, ENT_QUOTES);
        $payment = explode('{{pdf_row_separator}}', $paymentInfo);
        foreach ($payment as $key=>$value){
            if (strip_tags(trim($value)) == '') {
                unset($payment[$key]);
            }
        }
        reset($payment);

        /* Shipping Address and Method */
        if (!$order->getIsVirtual()) {
            /* Shipping Address */
            $shippingAddress = $this->_formatAddress($order->getShippingAddress()->format('pdf'));
            $shippingMethod  = $order->getShippingDescription();
        }

        $page->setFillColor(new Zend_Pdf_Color_GrayScale(0));
        $this->_setFontBold($page, 12);
        $page->drawText(Mage::helper('sales')->__('Sold to:'), 25, ($top - 15), 'UTF-8');

        if (!$order->getIsVirtual()) {
            $page->drawText(Mage::helper('sales')->__('Ship to:'), 285, ($top - 15), 'UTF-8');
        } else {
            $page->drawText(Mage::helper('sales')->__('Payment Method:'), 285, ($top - 15), 'UTF-8');
        }

        $addressesHeight = $this->_calcAddressHeight($billingAddress);
        if (isset($shippingAddress)) {
            $addressesHeight = max($addressesHeight, $this->_calcAddressHeight($shippingAddress));
        }

        $page->setFillColor(new Zend_Pdf_Color_GrayScale(1));
        $page->drawRectangle(25, ($top - 25), 570, $top - 33 - $addressesHeight);
        $page->setFillColor(new Zend_Pdf_Color_GrayScale(0));
        $this->_setFontRegular($page, 10);
        $this->y = $top - 40;
        $addressesStartY = $this->y;

        foreach ($billingAddress as $value){
            if ($value !== '') {
                $text = array();
                foreach (Mage::helper('core/string')->str_split($value, 45, true, true) as $_value) {
                    $text[] = $_value;
                }
                foreach ($text as $part) {
                    $page->drawText(strip_tags(ltrim($part)), 25, $this->y, 'UTF-8');
                    $this->y -= 15;
                }
            }
        }

        $addressesEndY = $this->y;

        if (!$order->getIsVirtual()) {
            $this->y = $addressesStartY;
            foreach ($shippingAddress as $value){
                if ($value!=='') {
                    $text = array();
                    foreach (Mage::helper('core/string')->str_split($value, 45, true, true) as $_value) {
                        $text[] = $_value;
                    }
                    foreach ($text as $part) {
                        $page->drawText(strip_tags(ltrim($part)), 285, $this->y, 'UTF-8');
                        $this->y -= 15;
                    }
                }
            }

            $addressesEndY = min($addressesEndY, $this->y);
            $this->y = $addressesEndY;

            $page->setFillColor(new Zend_Pdf_Color_GrayScale(0.92));
            $page->setLineWidth(0.5);
            $page->drawRectangle(25, $this->y, 275, $this->y-25);
            $page->drawRectangle(275, $this->y, 570, $this->y-25);

            $this->y -= 15;
            $this->_setFontBold($page, 12);
            $page->setFillColor(new Zend_Pdf_Color_GrayScale(0));
            $page->drawText(Mage::helper('sales')->__('Payment Method'), 25, $this->y, 'UTF-8');
            $page->drawText(Mage::helper('sales')->__('Shipping Method:'), 285, $this->y , 'UTF-8');

            $this->y -=10;
            $page->setFillColor(new Zend_Pdf_Color_GrayScale(1));

            $this->_setFontRegular($page, 10);
            $page->setFillColor(new Zend_Pdf_Color_GrayScale(0));

            $paymentLeft = 25;
            $yPayments   = $this->y - 15;
        }
        else {
            $yPayments   = $addressesStartY;
            $paymentLeft = 285;
        }

        foreach ($payment as $value){
            if (trim($value) != '') {
                //Printing "Payment Method" lines
                $value = preg_replace('/<br[^>]*>/i', "\n", $value);
                foreach (Mage::helper('core/string')->str_split($value, 45, true, true) as $_value) {
                    $page->drawText(strip_tags(trim($_value)), $paymentLeft, $yPayments, 'UTF-8');
                    $yPayments -= 15;
                }
            }
        }

        if ($order->getIsVirtual()) {
            // replacement of Shipments-Payments rectangle block
            $yPayments = min($addressesEndY, $yPayments);
            $page->drawLine(25,  ($top - 25), 25,  $yPayments);
            $page->drawLine(570, ($top - 25), 570, $yPayments);
            $page->drawLine(25,  $yPayments,  570, $yPayments);

            $this->y = $yPayments - 15;
        } else {
            $topMargin    = 15;
            $methodStartY = $this->y;
            $this->y     -= 15;

            foreach (Mage::helper('core/string')->str_split($shippingMethod, 45, true, true) as $_value) {
                $page->drawText(strip_tags(trim($_value)), 285, $this->y, 'UTF-8');
                $this->y -= 15;
            }

            $yShipments = $this->y;
            $totalShippingChargesText = "(" . Mage::helper('sales')->__('Total Shipping Charges') . " "
                . $order->formatPriceTxt($order->getShippingAmount()) . ")";

            $page->drawText($totalShippingChargesText, 285, $yShipments - $topMargin, 'UTF-8');
            $yShipments -= $topMargin + 10;

            $tracks = array();
            if ($shipment) {
                $tracks = $shipment->getAllTracks();
            }
            if (count($tracks)) {
                $page->setFillColor(new Zend_Pdf_Color_GrayScale(0.92));
                $page->setLineWidth(0.5);
                $page->drawRectangle(285, $yShipments, 510, $yShipments - 10);
                $page->drawLine(400, $yShipments, 400, $yShipments - 10);
                //$page->drawLine(510, $yShipments, 510, $yShipments - 10);

                $this->_setFontRegular($page, 9);
                $page->setFillColor(new Zend_Pdf_Color_GrayScale(0));
                //$page->drawText(Mage::helper('sales')->__('Carrier'), 290, $yShipments - 7 , 'UTF-8');
                $page->drawText(Mage::helper('sales')->__('Title'), 290, $yShipments - 7, 'UTF-8');
                $page->drawText(Mage::helper('sales')->__('Number'), 410, $yShipments - 7, 'UTF-8');

                $yShipments -= 20;
                $this->_setFontRegular($page, 8);
                foreach ($tracks as $track) {

                    $CarrierCode = $track->getCarrierCode();
                    if ($CarrierCode != 'custom') {
                        $carrier = Mage::getSingleton('shipping/config')->getCarrierInstance($CarrierCode);
                        $carrierTitle = $carrier->getConfigData('title');
                    } else {
                        $carrierTitle = Mage::helper('sales')->__('Custom Value');
                    }

                    //$truncatedCarrierTitle = substr($carrierTitle, 0, 35) . (strlen($carrierTitle) > 35 ? '...' : '');
                    $maxTitleLen = 45;
                    $endOfTitle = strlen($track->getTitle()) > $maxTitleLen ? '...' : '';
                    $truncatedTitle = substr($track->getTitle(), 0, $maxTitleLen) . $endOfTitle;
                    //$page->drawText($truncatedCarrierTitle, 285, $yShipments , 'UTF-8');
                    $page->drawText($truncatedTitle, 292, $yShipments , 'UTF-8');
                    $page->drawText($track->getNumber(), 410, $yShipments , 'UTF-8');
                    $yShipments -= $topMargin - 5;
                }
            } else {
                $yShipments -= $topMargin - 5;
            }

            $currentY = min($yPayments, $yShipments);

            // replacement of Shipments-Payments rectangle block
            $page->drawLine(25,  $methodStartY, 25,  $currentY); //left
            $page->drawLine(25,  $currentY,     570, $currentY); //bottom
            $page->drawLine(570, $currentY,     570, $methodStartY); //right

            $this->y = $currentY;
            $this->y -= 15;
        }
    }

    /**
     * Insert title and number for concrete document type
     *
     * @param  Zend_Pdf_Page $page
     * @param  string $text
     * @return void
     */
    public function insertDocumentNumber(Zend_Pdf_Page $page, $text)
    {
        $page->setFillColor(new Zend_Pdf_Color_GrayScale(1));
        $this->_setFontRegular($page, 10);
        $docHeader = 0; //$this->getDocHeaderCoordinates();
        $page->drawText($text, 25, $docHeader[1] - 15, 'UTF-8');
    }

    /**
     * Sort totals list
     *
     * @param  array $a
     * @param  array $b
     * @return int
     */
    protected function _sortTotalsList($a, $b) {
        if (!isset($a['sort_order']) || !isset($b['sort_order'])) {
            return 0;
        }

        if ($a['sort_order'] == $b['sort_order']) {
            return 0;
        }

        return ($a['sort_order'] > $b['sort_order']) ? 1 : -1;
    }

    /**
     * Return total list
     *
     * @param  Mage_Sales_Model_Abstract $source
     * @return array
     */
    protected function _getTotalsList($source)
    {
        $totals = Mage::getConfig()->getNode('global/pdf/totals')->asArray();
        usort($totals, array($this, '_sortTotalsList'));
        $totalModels = array();
        foreach ($totals as $index => $totalInfo) {
            if (!empty($totalInfo['model'])) {
                $totalModel = Mage::getModel($totalInfo['model']);
                if ($totalModel instanceof Mage_Sales_Model_Order_Pdf_Total_Default) {
                    $totalInfo['model'] = $totalModel;
                } else {
                    Mage::throwException(
                        Mage::helper('sales')->__('PDF total model should extend Mage_Sales_Model_Order_Pdf_Total_Default')
                    );
                }
            } else {
                $totalModel = Mage::getModel($this->_defaultTotalModel);
            }
            $totalModel->setData($totalInfo);
            $totalModels[] = $totalModel;
        }

        return $totalModels;
    }

    /**
     * Insert totals to pdf page
     *
     * @param  Zend_Pdf_Page $page
     * @param  Mage_Sales_Model_Abstract $source
     * @return Zend_Pdf_Page
     */
    protected function insertTotals($page, $source){
        $order = $source->getOrder();
        $totals = $this->_getTotalsList($source);
        $lineBlock = array(
            'lines'  => array(),
            'height' => 15
        );
        foreach ($totals as $total) {
            $total->setOrder($order)
                ->setSource($source);

            if ($total->canDisplay()) {
                $total->setFontSize(10);
                foreach ($total->getTotalsForDisplay() as $totalData) {
                    $lineBlock['lines'][] = array(
                        array(
                            'text'      => $totalData['label'],
                            'feed'      => 475,
                            'align'     => 'right',
                            'font_size' => $totalData['font_size'],
                            'font'      => 'bold'
                        ),
                        array(
                            'text'      => $totalData['amount'],
                            'feed'      => 565,
                            'align'     => 'right',
                            'font_size' => $totalData['font_size'],
                            'font'      => 'bold'
                        ),
                    );
                }
            }
        }

        $this->y -= 20;
        $page = $this->drawLineBlocks($page, array($lineBlock));
        return $page;
    }

    /**
     * Parse item description
     *
     * @param  Varien_Object $item
     * @return array
     */
    protected function _parseItemDescription($item)
    {
        $matches = array();
        $description = $item->getDescription();
        if (preg_match_all('/<li.*?>(.*?)<\/li>/i', $description, $matches)) {
            return $matches[1];
        }

        return array($description);
    }

    /**
     * Before getPdf processing
     */
    protected function _beforeGetPdf() {
        $translate = Mage::getSingleton('core/translate');
        /* @var $translate Mage_Core_Model_Translate */
        $translate->setTranslateInline(false);
    }

    /**
     * After getPdf processing
     */
    protected function _afterGetPdf() {
        $translate = Mage::getSingleton('core/translate');
        /* @var $translate Mage_Core_Model_Translate */
        $translate->setTranslateInline(true);
    }

    /**
     * Format option value process
     *
     * @param  array|string $value
     * @param  Mage_Sales_Model_Order $order
     * @return string
     */
    protected function _formatOptionValue($value, $order)
    {
        $resultValue = '';
        if (is_array($value)) {
            if (isset($value['qty'])) {
                $resultValue .= sprintf('%d', $value['qty']) . ' x ';
            }

            $resultValue .= $value['title'];

            if (isset($value['price'])) {
                $resultValue .= " " . $order->formatPrice($value['price']);
            }
            return  $resultValue;
        } else {
            return $value;
        }
    }

    /**
     * Initialize renderer process
     *
     * @param string $type
     */
    protected function _initRenderer($type)
    {
        $node = Mage::getConfig()->getNode('global/pdf/' . $type);
        foreach ($node->children() as $renderer) {
            $this->_renderers[$renderer->getName()] = array(
                'model'     => (string)$renderer,
                'renderer'  => null
            );
        }
    }

    /**
     * Retrieve renderer model
     *
     * @param  string $type
     * @throws Mage_Core_Exception
     * @return Mage_Sales_Model_Order_Pdf_Items_Abstract
     */
    protected function _getRenderer($type)
    {
        if (!isset($this->_renderers[$type])) {
            $type = 'default';
        }

        if (!isset($this->_renderers[$type])) {
            Mage::throwException(Mage::helper('sales')->__('Invalid renderer model'));
        }

        if (is_null($this->_renderers[$type]['renderer'])) {
            $this->_renderers[$type]['renderer'] = Mage::getSingleton($this->_renderers[$type]['model']);
        }

        return $this->_renderers[$type]['renderer'];
    }

    /**
     * Public method of protected @see _getRenderer()
     *
     * Retrieve renderer model
     *
     * @param  string $type
     * @return Mage_Sales_Model_Order_Pdf_Items_Abstract
     */
    public function getRenderer($type)
    {
        return $this->_getRenderer($type);
    }

    /**
     * Draw Item process
     *
     * @param  Varien_Object $item
     * @param  Zend_Pdf_Page $page
     * @param  Mage_Sales_Model_Order $order
     * @return Zend_Pdf_Page
     */
    protected function _drawItem(Varien_Object $item, Zend_Pdf_Page $page, Mage_Sales_Model_Order $order)
    {
        $type = $item->getOrderItem()->getProductType();
        $renderer = $this->_getRenderer($type);
        $renderer->setOrder($order);
        $renderer->setItem($item);
        $renderer->setPdf($this);
        $renderer->setPage($page);
        $renderer->setRenderedModel($this);

        $renderer->draw();

        return $renderer->getPage();
    }

    /**
     * Set font as regular
     *
     * @param  Zend_Pdf_Page $object
     * @param  int $size
     * @return Zend_Pdf_Resource_Font
     */
    protected function _setFontRegular($object, $size = 7)
    {
	
		$selected_headingsize = Mage::getStoreConfig('estoreiq_options/messages/estoreiq_heading_font_size_selected');

		if($selected_headingsize == 'small') {
			$size -= 1;
		}
		else if($selected_headingsize == 'large') {
			$size += 1;
		}
		
					
		// Get our Font from settings		
		$selected_font = Mage::getStoreConfig('estoreiq_options/messages/estoreiq_font_selected');
		
		if($selected_font == 'opensans') {	$font = Zend_Pdf_Font::fontWithPath(dirname(__FILE__)  . '/fonts/opensans/' . 'OpenSans-Regular.ttf');	}
		else if($selected_font == 'arimo') {	$font = Zend_Pdf_Font::fontWithPath(dirname(__FILE__)  . '/fonts/arimo/' . 'Arimo-Regular.ttf');	}
		else if($selected_font == 'asap') {	$font = Zend_Pdf_Font::fontWithPath(dirname(__FILE__)  . '/fonts/asap/' . 'Asap-Regular.ttf');	}
		else if($selected_font == 'asul') {	$font = Zend_Pdf_Font::fontWithPath(dirname(__FILE__)  . '/fonts/asul/' . 'Asul-Regular.ttf');	}
		else if($selected_font == 'cabin') {	$font = Zend_Pdf_Font::fontWithPath(dirname(__FILE__)  . '/fonts/cabin/' . 'Cabin-Regular.ttf');	}
		else if($selected_font == 'cabincondensed') {	$font = Zend_Pdf_Font::fontWithPath(dirname(__FILE__)  . '/fonts/cabincondensed/' . 'CabinCondensed-Regular.ttf');	}
		else if($selected_font == 'droidsans') {	$font = Zend_Pdf_Font::fontWithPath(dirname(__FILE__)  . '/fonts/droid/' . 'DroidSansMono-Regular.ttf');	}
		else if($selected_font == 'droidserif') {	$font = Zend_Pdf_Font::fontWithPath(dirname(__FILE__)  . '/fonts/droid/' . 'DroidSerif-Regular.ttf');	}
		else if($selected_font == 'francoisone') {	$font = Zend_Pdf_Font::fontWithPath(dirname(__FILE__)  . '/fonts/francoisone/' . 'FrancoisOne.ttf');	}
		else if($selected_font == 'lato') {	$font = Zend_Pdf_Font::fontWithPath(dirname(__FILE__)  . '/fonts/lato/' . 'Lato-Regular.ttf');	}
		else if($selected_font == 'latoblack') {	$font = Zend_Pdf_Font::fontWithPath(dirname(__FILE__)  . '/fonts/lato/' . 'Lato-Black.ttf');	}
		else if($selected_font == 'lobster') {	$font = Zend_Pdf_Font::fontWithPath(dirname(__FILE__)  . '/fonts/lobster/' . 'Lobster.ttf');	}
		else if($selected_font == 'oswald') {	$font = Zend_Pdf_Font::fontWithPath(dirname(__FILE__)  . '/fonts/oswald/' . 'Oswald-Regular.ttf');	}
		else if($selected_font == 'ptsans') {	$font = Zend_Pdf_Font::fontWithPath(dirname(__FILE__)  . '/fonts/ptsans/' . 'PT_Sans-Web-Regular.ttf');	}
		else if($selected_font == 'ptserif') {	$font = Zend_Pdf_Font::fontWithPath(dirname(__FILE__)  . '/fonts/ptserif/' . 'PT_Serif-Web-Regular.ttf');	}
		else if($selected_font == 'ubuntu') {	$font = Zend_Pdf_Font::fontWithPath(dirname(__FILE__)  . '/fonts/ubuntu/' . 'Ubuntu-Regular.ttf');	}
		else if($selected_font == 'ubuntucondensed') {	$font = Zend_Pdf_Font::fontWithPath(dirname(__FILE__)  . '/fonts/ubuntu/' . 'UbuntuCondensed-Regular.ttf');	}
		else  {	$font = Zend_Pdf_Font::fontWithPath(dirname(__FILE__)  . '/fonts/opensans/' . 'OpenSans-Regular.ttf');	}	
		
		
        $object->setFont($font, $size);
        return $font;
    }

    /**
     * Set font as bold
     *
     * @param  Zend_Pdf_Page $object
     * @param  int $size
     * @return Zend_Pdf_Resource_Font
     */
    protected function _setFontBold($object, $size = 7)
    {
        
		$selected_headingsize = Mage::getStoreConfig('estoreiq_options/messages/estoreiq_heading_font_size_selected');

		if($selected_headingsize == 'small') {
			$size -= 1;
		}
		else if($selected_headingsize == 'large') {
			$size += 1;
		}
		
		// Get our Font from settings		
		$selected_font = Mage::getStoreConfig('estoreiq_options/messages/estoreiq_font_selected');
		
		if($selected_font == 'opensans') {	$font = Zend_Pdf_Font::fontWithPath(dirname(__FILE__)  . '/fonts/opensans/' . 'OpenSans-Regular.ttf');	}
		else if($selected_font == 'arimo') {	$font = Zend_Pdf_Font::fontWithPath(dirname(__FILE__)  . '/fonts/arimo/' . 'Arimo-Regular.ttf');	}
		else if($selected_font == 'asap') {	$font = Zend_Pdf_Font::fontWithPath(dirname(__FILE__)  . '/fonts/asap/' . 'Asap-Regular.ttf');	}
		else if($selected_font == 'asul') {	$font = Zend_Pdf_Font::fontWithPath(dirname(__FILE__)  . '/fonts/asul/' . 'Asul-Regular.ttf');	}
		else if($selected_font == 'cabin') {	$font = Zend_Pdf_Font::fontWithPath(dirname(__FILE__)  . '/fonts/cabin/' . 'Cabin-Regular.ttf');	}
		else if($selected_font == 'cabincondensed') {	$font = Zend_Pdf_Font::fontWithPath(dirname(__FILE__)  . '/fonts/cabincondensed/' . 'CabinCondensed-Regular.ttf');	}
		else if($selected_font == 'droidsans') {	$font = Zend_Pdf_Font::fontWithPath(dirname(__FILE__)  . '/fonts/droid/' . 'DroidSansMono-Regular.ttf');	}
		else if($selected_font == 'droidserif') {	$font = Zend_Pdf_Font::fontWithPath(dirname(__FILE__)  . '/fonts/droid/' . 'DroidSerif-Regular.ttf');	}
		else if($selected_font == 'francoisone') {	$font = Zend_Pdf_Font::fontWithPath(dirname(__FILE__)  . '/fonts/francoisone/' . 'FrancoisOne.ttf');	}
		else if($selected_font == 'lato') {	$font = Zend_Pdf_Font::fontWithPath(dirname(__FILE__)  . '/fonts/lato/' . 'Lato-Regular.ttf');	}
		else if($selected_font == 'lobster') {	$font = Zend_Pdf_Font::fontWithPath(dirname(__FILE__)  . '/fonts/lobster/' . 'Lobster.ttf');	}
		else if($selected_font == 'oswald') {	$font = Zend_Pdf_Font::fontWithPath(dirname(__FILE__)  . '/fonts/oswald/' . 'Oswald-Regular.ttf');	}
		else if($selected_font == 'ptsans') {	$font = Zend_Pdf_Font::fontWithPath(dirname(__FILE__)  . '/fonts/ptsans/' . 'PT_Sans-Web-Regular.ttf');	}
		else if($selected_font == 'ptserif') {	$font = Zend_Pdf_Font::fontWithPath(dirname(__FILE__)  . '/fonts/ptserif/' . 'PT_Serif-Web-Regular.ttf');	}
		else if($selected_font == 'ubuntu') {	$font = Zend_Pdf_Font::fontWithPath(dirname(__FILE__)  . '/fonts/ubuntu/' . 'Ubuntu-Regular.ttf');	}
		else if($selected_font == 'ubuntucondensed') {	$font = Zend_Pdf_Font::fontWithPath(dirname(__FILE__)  . '/fonts/ubuntu/' . 'UbuntuCondensed-Regular.ttf');	}
		else  {	$font = Zend_Pdf_Font::fontWithPath(dirname(__FILE__)  . '/fonts/opensans/' . 'OpenSans-Regular.ttf');	}	
		

		
		
        $object->setFont($font, $size);
        return $font;
    }

    /**
     * Set font as italic
     *
     * @param  Zend_Pdf_Page $object
     * @param  int $size
     * @return Zend_Pdf_Resource_Font
     */
    protected function _setFontItalic($object, $size = 7)
    {
	
		$selected_headingsize = Mage::getStoreConfig('estoreiq_options/messages/estoreiq_heading_font_size_selected');

		if($selected_headingsize == 'small') {
			$size -= 1;
		}
		else if($selected_headingsize == 'large') {
			$size += 1;
		}
		
		
        // Get our Font from settings		
		$selected_font = Mage::getStoreConfig('estoreiq_options/messages/estoreiq_font_selected');
		
		if($selected_font == 'opensans') {	$font = Zend_Pdf_Font::fontWithPath(dirname(__FILE__)  . '/fonts/opensans/' . 'OpenSans-Regular.ttf');	}
		else if($selected_font == 'arimo') {	$font = Zend_Pdf_Font::fontWithPath(dirname(__FILE__)  . '/fonts/arimo/' . 'Arimo-Regular.ttf');	}
		else if($selected_font == 'asap') {	$font = Zend_Pdf_Font::fontWithPath(dirname(__FILE__)  . '/fonts/asap/' . 'Asap-Regular.ttf');	}
		else if($selected_font == 'asul') {	$font = Zend_Pdf_Font::fontWithPath(dirname(__FILE__)  . '/fonts/asul/' . 'Asul-Regular.ttf');	}
		else if($selected_font == 'cabin') {	$font = Zend_Pdf_Font::fontWithPath(dirname(__FILE__)  . '/fonts/cabin/' . 'Cabin-Regular.ttf');	}
		else if($selected_font == 'cabincondensed') {	$font = Zend_Pdf_Font::fontWithPath(dirname(__FILE__)  . '/fonts/cabincondensed/' . 'CabinCondensed-Regular.ttf');	}
		else if($selected_font == 'droidsans') {	$font = Zend_Pdf_Font::fontWithPath(dirname(__FILE__)  . '/fonts/droid/' . 'DroidSansMono-Regular.ttf');	}
		else if($selected_font == 'droidserif') {	$font = Zend_Pdf_Font::fontWithPath(dirname(__FILE__)  . '/fonts/droid/' . 'DroidSerif-Regular.ttf');	}
		else if($selected_font == 'francoisone') {	$font = Zend_Pdf_Font::fontWithPath(dirname(__FILE__)  . '/fonts/francoisone/' . 'FrancoisOne.ttf');	}
		else if($selected_font == 'lato') {	$font = Zend_Pdf_Font::fontWithPath(dirname(__FILE__)  . '/fonts/lato/' . 'Lato-Regular.ttf');	}
		else if($selected_font == 'latoblack') {	$font = Zend_Pdf_Font::fontWithPath(dirname(__FILE__)  . '/fonts/lato/' . 'Lato-Black.ttf');	}
		else if($selected_font == 'lobster') {	$font = Zend_Pdf_Font::fontWithPath(dirname(__FILE__)  . '/fonts/lobster/' . 'Lobster.ttf');	}
		else if($selected_font == 'oswald') {	$font = Zend_Pdf_Font::fontWithPath(dirname(__FILE__)  . '/fonts/oswald/' . 'Oswald-Regular.ttf');	}
		else if($selected_font == 'ptsans') {	$font = Zend_Pdf_Font::fontWithPath(dirname(__FILE__)  . '/fonts/ptsans/' . 'PT_Sans-Web-Regular.ttf');	}
		else if($selected_font == 'ptserif') {	$font = Zend_Pdf_Font::fontWithPath(dirname(__FILE__)  . '/fonts/ptserif/' . 'PT_Serif-Web-Regular.ttf');	}
		else if($selected_font == 'ubuntu') {	$font = Zend_Pdf_Font::fontWithPath(dirname(__FILE__)  . '/fonts/ubuntu/' . 'Ubuntu-Regular.ttf');	}
		else if($selected_font == 'ubuntucondensed') {	$font = Zend_Pdf_Font::fontWithPath(dirname(__FILE__)  . '/fonts/ubuntu/' . 'UbuntuCondensed-Regular.ttf');	}
		else  {	$font = Zend_Pdf_Font::fontWithPath(dirname(__FILE__)  . '/fonts/opensans/' . 'OpenSans-Regular.ttf');	}		
		
        $object->setFont($font, $size);
        return $font;
    }

    /**
     * Set PDF object
     *
     * @param  Zend_Pdf $pdf
     * @return Mage_Sales_Model_Order_Pdf_Abstract
     */
    protected function _setPdf(Zend_Pdf $pdf)
    {
        $this->_pdf = $pdf;
        return $this;
    }

    /**
     * Retrieve PDF object
     *
     * @throws Mage_Core_Exception
     * @return Zend_Pdf
     */
    protected function _getPdf()
    {
        if (!$this->_pdf instanceof Zend_Pdf) {
            Mage::throwException(Mage::helper('sales')->__('Please define PDF object before using.'));
        }

        return $this->_pdf;
    }


    /**
     * Draw lines
     *
     * draw items array format:
     * lines        array;array of line blocks (required)
     * shift        int; full line height (optional)
     * height       int;line spacing (default 10)
     *
     * line block has line columns array
     *
     * column array format
     * text         string|array; draw text (required)
     * feed         int; x position (required)
     * font         string; font style, optional: bold, italic, regular
     * font_file    string; path to font file (optional for use your custom font)
     * font_size    int; font size (default 7)
     * align        string; text align (also see feed parametr), optional left, right
     * height       int;line spacing (default 10)
     *
     * @param  Zend_Pdf_Page $page
     * @param  array $draw
     * @param  array $pageSettings
     * @throws Mage_Core_Exception
     * @return Zend_Pdf_Page
     */
    public function drawLineBlocks(Zend_Pdf_Page $page, array $draw, array $pageSettings = array())
    {
        foreach ($draw as $itemsProp) {
            if (!isset($itemsProp['lines']) || !is_array($itemsProp['lines'])) {
                Mage::throwException(Mage::helper('sales')->__('Invalid draw line data. Please define "lines" array.'));
            }
            $lines  = $itemsProp['lines'];
            $height = isset($itemsProp['height']) ? $itemsProp['height'] : 10;

            if (empty($itemsProp['shift'])) {
                $shift = 0;
                foreach ($lines as $line) {
                    $maxHeight = 0;
                    foreach ($line as $column) {
                        $lineSpacing = !empty($column['height']) ? $column['height'] : $height;
                        if (!is_array($column['text'])) {
                            $column['text'] = array($column['text']);
                        }
                        $top = 0;
                        foreach ($column['text'] as $part) {
                            $top += $lineSpacing;
                        }

                        $maxHeight = $top > $maxHeight ? $top : $maxHeight;
                    }
                    $shift += $maxHeight;
                }
                $itemsProp['shift'] = $shift;
            }

            if ($this->y - $itemsProp['shift'] < 15) {
                $page = $this->newPage($pageSettings);
            }

            foreach ($lines as $line) {
                $maxHeight = 0;
                foreach ($line as $column) {
                    $fontSize = empty($column['font_size']) ? 10 : $column['font_size'];
					
					$selected_headingsize = Mage::getStoreConfig('estoreiq_options/messages/estoreiq_heading_font_size_selected');

					if($selected_headingsize == 'small') {
						$fontSize -= 1;
					}
					else if($selected_headingsize == 'large') {
						$fontSize += 1;
					}
		
		
                    if (!empty($column['font_file'])) {
                        $font = Zend_Pdf_Font::fontWithPath($column['font_file']);
                        $page->setFont($font, $fontSize);
                    } else {
                        $fontStyle = empty($column['font']) ? 'regular' : $column['font'];
                        switch ($fontStyle) {
                            case 'bold':
                                $font = $this->_setFontBold($page, $fontSize);
                                break;
                            case 'italic':
                                $font = $this->_setFontItalic($page, $fontSize);
                                break;
                            default:
                                $font = $this->_setFontRegular($page, $fontSize);
                                break;
                        }
                    }

                    if (!is_array($column['text'])) {
                        $column['text'] = array($column['text']);
                    }

                    $lineSpacing = !empty($column['height']) ? $column['height'] : $height;
                    $top = 0;
                    foreach ($column['text'] as $part) {
                        if ($this->y - $lineSpacing < 15) {
                            $page = $this->newPage($pageSettings);
                        }

                        $feed = $column['feed'];
                        $textAlign = empty($column['align']) ? 'left' : $column['align'];
                        $width = empty($column['width']) ? 0 : $column['width'];
                        switch ($textAlign) {
                            case 'right':
                                if ($width) {
                                    $feed = $this->getAlignRight($part, $feed, $width, $font, $fontSize);
                                }
                                else {
                                    $feed = $feed - $this->widthForStringUsingFontSize($part, $font, $fontSize);
                                }
                                break;
                            case 'center':
                                if ($width) {
                                    $feed = $this->getAlignCenter($part, $feed, $width, $font, $fontSize);
                                }
                                break;
                        }
                        $page->drawText($part, $feed, $this->y-$top, 'UTF-8');
                        $top += $lineSpacing;
                    }

                    $maxHeight = $top > $maxHeight ? $top : $maxHeight;
                }
                $this->y -= $maxHeight;
            }
        }

        return $page;
    }
	
	
	
	
	
	
	
	protected function convertToBarcodeString($toBarcodeString)
    {
        $str = $toBarcodeString;
        $barcode_data = str_replace(' ', chr(128), $str);

        $checksum = 104; # must include START B code 128 value (104) in checksum
        for($i=0;$i<strlen($str);$i++) {
                $code128 = '';
                if (ord($barcode_data{$i}) == 128) {
                        $code128 = 0;
                } elseif (ord($barcode_data{$i}) >= 32 && ord($barcode_data{$i}) <= 126) {
                        $code128 = ord($barcode_data{$i}) - 32;
                } elseif (ord($barcode_data{$i}) >= 126) {
                        $code128 = ord($barcode_data{$i}) - 50;
                }
        $checksum_position = $code128 * ($i + 1);
        $checksum += $checksum_position;
        }
        $check_digit_value = $checksum % 103;
        $check_digit_ascii = '';
        if ($check_digit_value <= 94) {
            $check_digit_ascii = $check_digit_value + 32;
        } elseif ($check_digit_value > 94) {
            $check_digit_ascii = $check_digit_value + 50;
        }
        $barcode_str = chr(154) . $barcode_data . chr($check_digit_ascii) . chr(156);
            
        return $barcode_str;

    }
	
	
	
	
}
?>
