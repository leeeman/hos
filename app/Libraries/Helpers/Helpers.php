<?php
namespace App\Libraries\Helpers;
use TCPDF;
class Helpers {
	
	public static function easyPrint($html, $options = []) {	
		$filename 	= isset($options['filename'])?$options['filename']:"Print.pdf";
		$page_style = isset($options['page_style'])?$options['page_style']:"P";
		
		$pdf = new TCPDF($page_style, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		// remove default header/footer
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);

		// set margins
		$pdf->SetMargins(20, 20, 20);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, 8);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
		    require_once(dirname(__FILE__).'/lang/eng.php');
		    $pdf->setLanguageArray($l);
		}

		$pdf->AddPage();
		$pdf->SetFont('calibri', '', 11, '', false);
		$pdf->setFontSubsetting(false); 

		$pdf->writeHTML($html, true, false, true, false, '');
		//$pdf->writeHTMLCell($w=280, $h=190, '', '', $html=$html, $border=1, $ln=0, $fill=false, $reseth=true, $align='L', $autopadding=true);

		return $pdf->Output($filename, 'I');
	}
}