<?php
//============================================================+
// File name   : example_011.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 011 for TCPDF class
//               Colored Table (very simple table)
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: Colored Table
 * @author Nicola Asuni
 * @since 2008-03-04
 */

// Include the main TCPDF library (search for installation path).


// extend TCPF with custom functions
namespace GO\MainBundle\Utils;
use TCPDF;
class PDFTableExporter extends TCPDF {

    protected $w = array(60, 20, 40, 45);
    public $columns_width=array();
//function to be used to determine the width of a column using its highest value
    public function getColumnWidth(array $values)
    {
        return max(array_map('strlen',$values));
    }
    // Colored table
	public function ColoredTable($headers,$data) {
		// Colors, line width and bold font
		$this->SetFillColor(128, 128, 120);
		$this->SetTextColor(255);
		$this->SetDrawColor(12, 0, 0);
		$this->SetLineWidth(0.3);
		$this->SetFont('', 'B');
		// Header
		//$this->w;
                //$columns_width=array(15,60, 20, 25, 18,18,30);
               
                
		$num_headers = count($headers);
		for($i = 0; $i < $num_headers; ++$i) {
			$this->Cell($headers[$i]['width'], 7, $headers[$i]['name'], 1, 0, 'C', 1);
                        //adding with values to the array of headers width;
                        array_push($this->columns_width, $headers[$i]['width']);
                        
		}
                //var_dump(array_sum($this->columns_width));
		$this->Ln();
		// Color and font restoration
		$this->SetFillColor(224, 235, 255);
		$this->SetTextColor(0);
		$this->SetFont('');
		// Data
		$fill = 0;
		foreach($data as $row) {
                    /*
			$this->Cell($w[0], 6, $row[0], 'LR', 0, 'L', $fill);
			$this->Cell($w[1], 6, $row[1], 'LR', 0, 'L', $fill);
			$this->Cell($w[2], 6, $row[2], 'LR', 0, 'R', $fill);
			$this->Cell($w[3], 6, $row[3], 'LR', 0, 'R', $fill);
			$this->Ln();
			$fill=!$fill;*/
                    $cell_height=6;
                    for($i=0; $i<count($row);$i++)
                    {
			$this->Cell($headers[$i]['width'], $cell_height, $row[$i], 'LR', 0, 'L', $fill);
			
			
                    }
			$this->Ln();
                        $fill=!$fill;
                        
		}
               // $this->Ln();
		
               	
	}

//fonction qui permet d'ajouter une ligne total qui permet de regrouper des données à la fin de la liste
    public function totalLine($total)
    {
       $this->Cell(array_sum($this->columns_width), 0, '', 'T');
//var_dump(array_sum($$this->columns_width));die();
		$this->Ln();
		$this->Cell(array_sum($this->columns_width)-20, 6, "Total des données", 'LR', 0, 'L', true);
		$this->Cell(20, 6, $total, 'LR', 0, 'L', true);
                $this->Ln();
		$this->Cell(array_sum($this->columns_width), 0, '', 'T');

    }
// create new PDF document
public function export($data_source, array $header, $file_name, $doc_title, $doc_sub_title=null, $total=null){
$pdf = new $this(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Golob One SMS');
$pdf->SetTitle($file_name);
$pdf->SetSubject('Recouvrement des mensualités');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $doc_title, $doc_sub_title.' Golob One toujours à votre service');

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

// set font
$pdf->SetFont('times', '', 12);

// add a page
$pdf->AddPage();

// column titles
//$header = array('Client ', 'Adresse', 'Date ', 'Type abonement');

// data loading
//$data = $pdf->LoadData($data_source);

// print colored table
$pdf->ColoredTable($header, $data_source);
if(!is_null($total))
{
$pdf->totalLine($total);
}

// ---------------------------------------------------------

// close and output PDF document
$pdf->Output($file_name.'.pdf', 'D');
}
//============================================================+
// END OF FILE
//============================================================+
}