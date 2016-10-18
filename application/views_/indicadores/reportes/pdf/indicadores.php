<?php
/**
 * Clase PDF
 */
class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        // Logo
        // $this->Image('logo_pb.png',10,8,33);
        // Arial bold 15
        $this->SetFont('Arial','B',15);
        // Movernos a la derecha
        $this->Cell(80);
        // Título
        $this->Cell(30,10,'Indicadores',0,0,'C');
        // Salto de línea
        $this->Ln(15);
    } // Header

    // Pie de página
    function Footer()
    {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','',8);
        // Número de página
        $this->Cell(0,10, utf8_decode('Sistema Informático de Contabilización y Control - Vinus S.A.S. Página '.$this->PageNo().' de {nb}'),0,0,'C');
    } // Footer
} // PDF

// Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();

// Recorrido de los indicadores
foreach ($this->indicadores_model->cargar("indicadores", NULL) as $indicador){

    // Nombre e identificador del indicador
    $pdf->SetFont('Helvetica','B',11);
    $pdf->Cell(170,8, utf8_decode($indicador->Nombre),1, 0, 'L', 0);
    $pdf->Cell(20,8, utf8_decode($indicador->Identificador),1, 0, 'C', 0);
    $pdf->Ln();

    // Concepto de medición
    $pdf->SetFont('Helvetica','B',11);
    $pdf->Cell(50,6, utf8_decode("Concepto de medición: "),0, 0, 'L', 0);
    $pdf->SetFont('Helvetica','',11);
    $pdf->Cell(140,6, utf8_decode($indicador->Concepto_Medicion),0, 0, 'L', 0);
    $pdf->Ln();

    // Norma
    $pdf->SetFont('Helvetica','B',11);
    $pdf->Cell(50,6, utf8_decode("Normatividad específica: "),0, 0, 'L', 0);
    $pdf->SetFont('Helvetica','',11);
    $pdf->Cell(140,6, utf8_decode($indicador->Norma),0, 0, 'L', 0);
    $pdf->Ln();

    // Norma
    $pdf->SetFont('Helvetica','B',11);
    $pdf->Cell(50,6, utf8_decode("Unidad de medida: "),0, 0, 'L', 0);
    $pdf->SetFont('Helvetica','',11);
    $pdf->Cell(140,6, utf8_decode($indicador->Unidad_Medida),0, 0, 'L', 0);
    $pdf->Ln();

    // Norma
    $pdf->SetFont('Helvetica','B',11);
    $pdf->Cell(50,6, utf8_decode("Tiempo de corrección: "),0, 0, 'L', 0);
    $pdf->SetFont('Helvetica','',11);
    $pdf->Cell(140,6, utf8_decode("XXX"),0, 0, 'L', 0);
    $pdf->Ln();

    // Método de medida
    $pdf->SetFont('Helvetica','B',11);
    $pdf->MultiCell(190,7, utf8_decode("Método de medida"), 0, 'C');
    $pdf->SetFont('Helvetica','',9);
    $pdf->MultiCell(190,5, utf8_decode($indicador->Metodo_Medida), 0, 'L');
    $pdf->Ln();

    // Método de medida
    $pdf->SetFont('Helvetica','B',11);
    $pdf->MultiCell(190,7, utf8_decode("Valor de aceptación"), 0, 'C');
    $pdf->SetFont('Helvetica','',9);
    $pdf->MultiCell(190,5, utf8_decode($indicador->Valor_Aceptacion), 0, 'L');
    $pdf->Ln();

    $pdf->Ln(15);
} // foreach indicadores

$pdf->Output("Indicadores.pdf", "I");
// $pdf->Output("Indicadores.pdf", "D");
?>