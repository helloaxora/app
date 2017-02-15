<?php
//require_once Yii::app()->request->baseUrl."dompdf/autoload.inc.php";
//
//// reference the Dompdf namespace
//		use Dompdf\Dompdf;
//
//// instantiate and use the dompdf class
//		$dompdf = new Dompdf();
//		$dompdf->loadHtml('hello world');
//
//// (Optional) Setup the paper size and orientation
//		$dompdf->setPaper('A4', 'landscape');
//
//// Render the HTML as PDF
//		$dompdf->render();
//
//// Output the generated PDF to Browser
//		$dompdf->stream();


$html_body =
	'<html><body>'.
	'<p>Some text</p>'.
	'</body></html>';

Yii::import('application.extensions.*');
//require_once(Yii::app()->request->baseUrl.'protected/extensions/dompdf/dompdf_config.inc.php');
require_once Yii::app()->request->baseUrl."dompdf/autoload.inc.php";
spl_autoload_unregister(array('YiiBase','autoload'));
spl_autoload_register(array('YiiBase','autoload'));

$dompdf = new DOMPDF();
$dompdf->load_html($html_body);
$dompdf->set_paper('a4', 'landscape');
$dompdf->render();

$dompdf->stream("my_pdf.pdf", array("Attachment" => 1));

$this->redirect(array('families/index',));