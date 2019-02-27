<?php
$this->layout = 'ajax';

$objPHPExcel->getProperties()->setCreator("Irbits.cl")
							 ->setLastModifiedBy("Irbits.cl")
							 ->setTitle("Operaciones Cuotas Pesca - año ".$year)
							 ->setSubject("Operaciones Cuotas Pesca")
							 ->setDescription("Operaciones Cuotas Pesca Exportado desde RMP")
							 ->setKeywords("CPS Irbits Informe Cuotas Pesca")
							 ->setCategory("Informes");

// Sin lineas del grid
// $objPHPExcel->setActiveSheetIndex(0)->setShowGridlines(false);

// Estilo de texto
$objPHPExcel->getActiveSheet()->setTitle('Operaciones');
$objPHPExcel->getActiveSheet()->getStyle('D1:F1')
                              ->getBorders()
                              ->getBottom()
                              ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->getStyle('A3:J3')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('D1:F1')->getFont()->setBold(true)->setSize(16);
$objPHPExcel->getActiveSheet()->getStyle('D1:F1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->mergeCells('D1:F1');

$objPHPExcel->getActiveSheet()
            ->setCellValue('D1', "OPERACIONES CUOTAS PESCA {$year}")
            ->setCellValue('A3', 'Especie')
            ->setCellValue('B3', 'Licencia')
            ->setCellValue('C3', 'Fecha Promulgación')
            ->setCellValue('D3', 'Fecha Inicio')
            ->setCellValue('E3', 'Fecha Término')
            ->setCellValue('F3', 'Macro Zona')
            ->setCellValue('G3', 'Cantidad')
            ->setCellValue('H3', 'Tipo Operación')
            ->setCellValue('I3', 'Resolución')
            ->setCellValue('J3', 'Contraparte');

$i = 4;
foreach ($operaciones as $operacion) {
    $rut_auxiliar = '-';
    if (!empty($operacion->auxiliar)) {
        $new_rut = str_pad(number_format($operacion->auxiliar->rut, 0, ',', '.'), '9', '0', STR_PAD_LEFT);
        $rut_auxiliar = $new_rut.'-'.$operacion->auxiliar->verificador;
    }

    $objPHPExcel->getActiveSheet()
                ->getStyle("A{$i}:J{$i}")
                ->getNumberFormat()
                ->setFormatCode(
                    PHPExcel_Style_NumberFormat::FORMAT_TEXT
                );
    $objPHPExcel->getActiveSheet()
                ->setCellValue('A'.$i, $operacion->licencia->especie->nombre)
                ->setCellValue('B'.$i, $operacion->licencia->fecha_promulgacion->format('Y').'-'.$operacion->licencia->codigo_resolucion)
                ->setCellValue('C'.$i, convertirFecha($operacion->fecha_promulgacion->toUnixString(), false))
                ->setCellValue('D'.$i, convertirFecha($operacion->fecha_inicio->toUnixString(), false))
                ->setCellValue('E'.$i, convertirFecha($operacion->fecha_termino->toUnixString(), false))
                ->setCellValue('F'.$i, $operacion->macro_zona->nombre)
                ->setCellValue('G'.$i, str_replace('.', '', $this->Number->precision($operacion->cantidad)))
                ->setCellValue('H'.$i, $operacion->tipo_operacion->nombre)
                ->setCellValue('I'.$i, $operacion->resolucion)
                ->setCellValue('J'.$i, $rut_auxiliar);

    $i++;
}

// Se autoajusta el ancho de las columnas
foreach(range('A','J') as $columnID) {
    $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
        ->setAutoSize(true);
}

// Configura la primera hoja como activa en el archivo Excel
$objPHPExcel->setActiveSheetIndex(0);
// Imprime la salida en el navegador
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="operaciones_cuota.xls"');
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
