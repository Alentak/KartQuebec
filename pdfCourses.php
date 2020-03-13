<?php
include_once 'php/class/database.class.php';
$db = new Database("localhost", "kartquebec", "root", "P@ssw0rd");
session_start();
date_default_timezone_set('America/Montreal');

// Include the main TCPDF library (search for installation path).
require_once('lib/TCPDF-master/tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Paul Guillon');
$pdf->SetTitle('Courses PDF');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, participants, liste');

// set default header data
$pdf->setFooterData(array(0,64,0), array(0,64,128));

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('dejavusans', '', 14, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();

// set text shadow effect
$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

$data = date("Y/m/d h:i:sa")."<br>";
foreach ($_SESSION["courses"] as $c) {
    $participants = $db->Read("SELECT * FROM panier INNER JOIN membre ON (membre.Numero = panier.numeroMembre) INNER JOIN course ON (course.Numero = panier.numeroCourse) WHERE course.Numero = '{$c["Numero"]}' AND estCommandee = true");

    $data .=  "<h2>".$c["numeroCourse"]." - ".$c["Description"]."</h2><br><hr><table><tr><th>Numéro</th><th>Nom</th><th>Prénom</th></tr>";

    foreach ($participants as $p) {
        $data .= "<tr><td>{$p["numeroMembre"]}</td><td>{$p["Nom"]}</td><td>{$p["Prenom"]}</td></tr>";
    }

    $data .= "</table><hr>";
}

// Set some content to print
$html = <<<EOD
<h1>Listing des courses</h1>
$data

EOD;

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('listingParticipants.pdf', 'I');
?>