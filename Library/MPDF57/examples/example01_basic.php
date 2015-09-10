<?php

require_once('../../CurlStatic.php');
require_once("../mpdf.php");

$html = CurlStatic::send(array(), $typeRequest, 'http://criarsites.cc/jopacs/');

$html =   mb_convert_encoding($html, 'UTF-8', 
          mb_detect_encoding($html, 'UTF-8, ISO-8859-1', true)); 

$mpdf = new mPDF(); 

$mpdf->WriteHTML( $html );
$mpdf->Output();
exit;

?>