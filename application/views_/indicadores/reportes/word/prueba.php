<?php
// Se crea el nuevo objeto
$PHPWord = new PHPWord();

/**
 * Configuración por defecto
 */
$PHPWord->setDefaultFontName('Arial');
$PHPWord->setDefaultFontSize(11);
$properties = $PHPWord->getProperties();
$properties->setCreator('John Arley Cano Salinas'); 
$properties->setCompany('Hatovial S.A.S.');
$properties->setTitle('Acta de recibo');
$properties->setDescription('Acta de recibo final de obra'); 
$properties->setCategory('informe');
$properties->setLastModifiedBy('John Arley Cano Salinas');

$seccion1 = $PHPWord->createSection(array(/* 'marginLeft'=>210, 'marginRight'=>200, 'marginTop'=>620, 'marginBottom'=>0,*/'pageSizeW'=>12240, 'pageSizeH'=>15840));

/**
	 * Título
	 */
	$seccion1->addText(utf8_decode('CONTRATO No. '), 'parrafo1', array ('align' => 'center', 'valign' => 'center'));


// At least write the document to webspace:
$objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');

$temp_file_uri = tempnam('', 'xyz');
$objWriter->save($temp_file_uri);

//download code
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
// header('Content-Disposition: attachment; filename=Acta_Recibo.docx');
header('Content-Disposition: attachment; filename=Acta_Recibo.docx');
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Content-Length: ' . filesize($temp_file_uri));
readfile($temp_file_uri);
unlink($temp_file_uri); // deletes the temporary file
exit;
?>