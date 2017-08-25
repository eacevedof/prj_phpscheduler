<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name ComponentTopdf
 * @file component_topdf.php
 * @version 1.0.0
 * @date 01-06-2014 12:45
 * @observations
 */

namespace TheFramework\Components;

use FPDF;

class ComponentTopdf 
{
    private $arData; //array con datos
    private $iEnd; //end day
    
    public function __construct($arData,$iEnd=30)
    {
        $this->arData = $arData;
        $this->iEnd = $iEnd;
        //bugif();
        $pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(40,10,'¡Hola, Mundo!');
$pdf->Output();
    }
}//ComponentTopdf
