<?php
$this->layout = 'ajax';

$objPHPExcel->getProperties()->setCreator("Irbits.cl")
							 ->setLastModifiedBy("Irbits.cl")
							 ->setTitle("Informe Diario - ".$fecha_text)
							 ->setSubject("Informe Diario Pesca Sur")
							 ->setDescription("Informe Diario Pesca Sur - ".$fecha_text)
							 ->setKeywords("CPS Irbits Informe")
							 ->setCategory("Informes");

// Sin lineas del grid
$objPHPExcel->setActiveSheetIndex(0)->setShowGridlines(false);

// Estilo de texto
$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('B1:E1')
                              ->getBorders()
                              ->getBottom()
                              ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->getStyle('D3')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('B9')->getFont()->setBold(true);

$objPHPExcel->getActiveSheet()
            ->setCellValue('B1', 'INFORME DIARIO ZONA SUR')
            ->setCellValue('A3', 'Correspondiente a descarga día')
            ->setCellValue('D3', $fecha_full)
            ->setCellValue('A7', 'Nombre    Barco')
            ->setCellValue('B7', 'Toneladas                          Diarias')
            ->setCellValue('C7', 'Toneladas                          Semanales')
            ->setCellValue('D7', 'Toneladas                          Mensuales')
            ->setCellValue('E7', 'Toneladas                          Año');
$objPHPExcel->getActiveSheet()->getStyle('A7:E7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A7:E7')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('A7:E7')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
// Jurel Artesanal
$objPHPExcel->getActiveSheet()
            ->setCellValue('A9', 'FLOTA INDUSTRIAL JUREL');
$objPHPExcel->getActiveSheet()->getStyle('A9')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$numRow = 11;
$tempFirst = 11;
$tempLast = $tempFirst;
foreach ($totalesIndustrialJurel as $nombre => $total) {
  $objPHPExcel->getActiveSheet()
              ->setCellValue('A'.$numRow, $nombre)
              ->setCellValue('B'.$numRow, $total['diario'])
              ->setCellValue('C'.$numRow, $total['semanal'])
              ->setCellValue('D'.$numRow, $total['mensual'])
              ->setCellValue('E'.$numRow, $total['anual']);
  $tempLast = $numRow;
  $numRow++;
}

$objPHPExcel->getActiveSheet()->getStyle('B'.$tempFirst.':E'.$tempLast)
                              ->getBorders()->getAllBorders()
                              ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

$numRow++;
$subTotalIndustrialJurelRow = $numRow;
$objPHPExcel->getActiveSheet()
            ->setCellValue('A'.$numRow, 'SUBTOTAL FLOTA INDUSTRIAL')
            ->setCellValue('B'.$numRow, '=SUM(B'.$tempFirst.':B'.$tempLast.')')
            ->setCellValue('C'.$numRow, '=SUM(C'.$tempFirst.':C'.$tempLast.')')
            ->setCellValue('D'.$numRow, '=SUM(D'.$tempFirst.':D'.$tempLast.')')
            ->setCellValue('E'.$numRow, '=SUM(E'.$tempFirst.':E'.$tempLast.')');
$objPHPExcel->getActiveSheet()->getStyle('B'.$numRow.':E'.$numRow)
                              ->getBorders()->getAllBorders()
                              ->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
$numRow+=2;

// Sardinas Insutrial
$objPHPExcel->getActiveSheet()
            ->setCellValue('A'.$numRow, 'FLOTA INDUSTRIAL SARDINA');
$objPHPExcel->getActiveSheet()->getStyle('A'.$numRow)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A'.$numRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$numRow+=2;
$tempFirst = $numRow;
$tempLast = $tempFirst;
foreach ($totalesIndustrialSardina as $nombre => $total) {
  $objPHPExcel->getActiveSheet()
              ->setCellValue('A'.$numRow, $nombre)
              ->setCellValue('B'.$numRow, $total['diario'])
              ->setCellValue('C'.$numRow, $total['semanal'])
              ->setCellValue('D'.$numRow, $total['mensual'])
              ->setCellValue('E'.$numRow, $total['anual']);
  $tempLast = $numRow;
  $numRow++;
}
$objPHPExcel->getActiveSheet()->getStyle('B'.$tempFirst.':E'.$tempLast)
                              ->getBorders()->getAllBorders()
                              ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

$numRow++;
$subTotalIndustrialSardinaRow = $numRow;
$objPHPExcel->getActiveSheet()
            ->setCellValue('A'.$numRow, 'SUBTOTAL FLOTA INDUSTRIAL')
            ->setCellValue('B'.$numRow, '=SUM(B'.$tempFirst.':B'.$tempLast.')')
            ->setCellValue('C'.$numRow, '=SUM(C'.$tempFirst.':C'.$tempLast.')')
            ->setCellValue('D'.$numRow, '=SUM(D'.$tempFirst.':D'.$tempLast.')')
            ->setCellValue('E'.$numRow, '=SUM(E'.$tempFirst.':E'.$tempLast.')');
$objPHPExcel->getActiveSheet()->getStyle('B'.$numRow.':E'.$numRow)
                              ->getBorders()->getAllBorders()
                              ->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
$numRow+=3;
// Total Flota Industrial
$totalIndustrialesRow = $numRow;
$objPHPExcel->getActiveSheet()
            ->setCellValue('A'.$numRow, 'TOTAL FLOTA INDUSTRIAL')
            ->setCellValue('B'.$numRow, '=+B'.$subTotalIndustrialJurelRow.'+B'.$subTotalIndustrialSardinaRow)
            ->setCellValue('C'.$numRow, '=+C'.$subTotalIndustrialJurelRow.'+C'.$subTotalIndustrialSardinaRow)
            ->setCellValue('D'.$numRow, '=+D'.$subTotalIndustrialJurelRow.'+D'.$subTotalIndustrialSardinaRow)
            ->setCellValue('E'.$numRow, '=+E'.$subTotalIndustrialJurelRow.'+E'.$subTotalIndustrialSardinaRow);
$objPHPExcel->getActiveSheet()->getStyle('A'.$numRow)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('B'.$numRow.':E'.$numRow)
                              ->getBorders()->getAllBorders()
                              ->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
$numRow+=2;

// Sardinas Artesanal
$objPHPExcel->getActiveSheet()
            ->setCellValue('A'.$numRow, 'FLOTA ARTESANAL');
$objPHPExcel->getActiveSheet()->getStyle('A'.$numRow)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A'.$numRow)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$numRow+=2;
$tempFirst = $numRow;
$tempLast = $tempFirst;
foreach ($totalesArtesanalSardina as $nombre => $total) {
  $objPHPExcel->getActiveSheet()
              ->setCellValue('A'.$numRow, $nombre)
              ->setCellValue('B'.$numRow, $total['diario'])
              ->setCellValue('C'.$numRow, $total['semanal'])
              ->setCellValue('D'.$numRow, $total['mensual'])
              ->setCellValue('E'.$numRow, $total['anual']);
  $tempLast = $numRow;
  $numRow++;
}
$objPHPExcel->getActiveSheet()->getStyle('B'.$tempFirst.':E'.$tempLast)
                              ->getBorders()->getAllBorders()
                              ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

$numRow++;
$totalArtesanalesRow = $numRow;
$objPHPExcel->getActiveSheet()
            ->setCellValue('A'.$numRow, 'TOTAL ARTESANALES')
            ->setCellValue('B'.$numRow, '=SUM(B'.$tempFirst.':B'.$tempLast.')')
            ->setCellValue('C'.$numRow, '=SUM(C'.$tempFirst.':C'.$tempLast.')')
            ->setCellValue('D'.$numRow, '=SUM(D'.$tempFirst.':D'.$tempLast.')')
            ->setCellValue('E'.$numRow, '=SUM(E'.$tempFirst.':E'.$tempLast.')');
$objPHPExcel->getActiveSheet()->getStyle('A'.$numRow)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('B'.$numRow.':E'.$numRow)
                              ->getBorders()->getAllBorders()
                              ->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
$numRow+=3;

// Total Entradas
$objPHPExcel->getActiveSheet()
            ->setCellValue('A'.$numRow, 'TOTAL ENTRADAS')
            ->setCellValue('B'.$numRow, '=+B'.$totalIndustrialesRow.'+B'.$totalArtesanalesRow)
            ->setCellValue('C'.$numRow, '=+C'.$totalIndustrialesRow.'+C'.$totalArtesanalesRow)
            ->setCellValue('D'.$numRow, '=+D'.$totalIndustrialesRow.'+D'.$totalArtesanalesRow)
            ->setCellValue('E'.$numRow, '=+E'.$totalIndustrialesRow.'+E'.$totalArtesanalesRow);
$objPHPExcel->getActiveSheet()->getStyle('A'.$numRow)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('B'.$numRow.':E'.$numRow)
                              ->getBorders()->getAllBorders()
                              ->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
$numRow+=2;

/******************
 *   PLANTAS
 */

$objPHPExcel->getActiveSheet()
           ->setCellValue('D'.$numRow, 'PLANTAS');
$objPHPExcel->getActiveSheet()->getStyle('D'.$numRow)->getFont()->setBold(true);
$numRow+=2;

$objPHPExcel->getActiveSheet()
           ->setCellValue('A'.$numRow, 'DESTINO PESCA');
$objPHPExcel->getActiveSheet()->getStyle('A'.$numRow)->getFont()->setBold(true);

$numRow+=2;
$tempFirst = $numRow;
$tempLast = $tempFirst;
foreach ($totalesPlantas as $nombre => $total) {
  $objPHPExcel->getActiveSheet()
              ->setCellValue('A'.$numRow, $nombre)
              ->setCellValue('B'.$numRow, $total['diario'])
              ->setCellValue('C'.$numRow, $total['semanal'])
              ->setCellValue('D'.$numRow, $total['mensual'])
              ->setCellValue('E'.$numRow, $total['anual']);
  $tempLast = $numRow;
  $numRow++;
}
$objPHPExcel->getActiveSheet()->getStyle('B'.$tempFirst.':E'.$tempLast)
                              ->getBorders()->getAllBorders()
                              ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

$objPHPExcel->getActiveSheet()
           ->setCellValue('A'.$numRow, 'TOTAL SALIDAS')
           ->setCellValue('B'.$numRow, '=SUM(B'.$tempFirst.':B'.$tempLast.')')
           ->setCellValue('C'.$numRow, '=SUM(C'.$tempFirst.':C'.$tempLast.')')
           ->setCellValue('D'.$numRow, '=SUM(D'.$tempFirst.':D'.$tempLast.')')
           ->setCellValue('E'.$numRow, '=SUM(E'.$tempFirst.':E'.$tempLast.')');
$objPHPExcel->getActiveSheet()->getStyle('A'.$numRow)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('B'.$numRow.':E'.$numRow)
                             ->getBorders()->getAllBorders()
                             ->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

// Configurando Ancho de Columnas
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth('40');
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth('15');
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth('15');
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth('15');
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth('15');

// Alto de Filas
$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(92);
$objPHPExcel->getActiveSheet()->getRowDimension('7')->setRowHeight(40);

// Se configura el nombre de la hoja a la fecha actual
$objPHPExcel->getActiveSheet()->setTitle($fecha_numeros);

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="informe_gerencia.xls"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');
// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
?>
