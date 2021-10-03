<?php
	require_once "../../config/PHPExcel/Classes/PHPExcel.php";

	$objPHPExcel = new PHPExcel();

    $objset = $objPHPExcel->setActiveSheetIndex(0); //inisiasi set object dan index sheet
    $objget = $objPHPExcel->getActiveSheet();  //inisiasi get object
    $objget->setTitle('Data Pegawai');

    //mengatur border tabel
    $thin = array ();
	$thin['borders']=array();
	$thin['borders']['allborders']=array();
	$thin['borders']['allborders']['style']=PHPExcel_Style_Border::BORDER_THIN  ;
	$objset->getStyle ( 'A1:E4' )->applyFromArray($thin);
    //posisi center
    $center = array();
	$center ['alignment']=array();
	$center ['alignment']['horizontal']=PHPExcel_Style_Alignment::HORIZONTAL_CENTER;
	$center ['alignment']['vertical']=PHPExcel_Style_Alignment::VERTICAL_CENTER;
	$objset->getStyle ( 'A1:E10' )->applyFromArray ($center);
	//warna background
	$backgroound['fill']=array();
	$backgroound['fill']['type']=PHPExcel_Style_Fill::FILL_SOLID;
	$backgroound['fill']['color']=array();
	$backgroound['fill']['color']['rgb']='000000';
	$objset->getStyle ( 'A1:E1' )->applyFromArray($backgroound);
	//warna tulisan
    $objget->getStyle('A1:E1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
    //ukuran Font
    $objset->getStyle('A1:E1')->getFont()->setBold(true);
    //mengatur height baris 
    $objPHPExcel->getSheet(0)->getRowDimension('1')->setRowHeight(35);
    //set lebar kolom otomatis
    foreach(range('A','E') as $columnID) {
    	$objget->getColumnDimension($columnID)->setAutoSize(true);
    }
    //header tabel
    $objset->setCellValue('A1','NIP');
    $objset->setCellValue('B1','NAMA PEGAWAI');
    $objset->setCellValue('C1','ID UNIT');
    $objset->setCellValue('D1','ID POSISI');
    $objset->setCellValue('E1','STATUS KEPEGAWAIAN');

    $backgroound['fill']=array();
	$backgroound['fill']['type']=PHPExcel_Style_Fill::FILL_SOLID;
	$backgroound['fill']['color']=array();
	$backgroound['fill']['color']['rgb']='FFFF00';
	$objset->getStyle ( 'A2:E2' )->applyFromArray($backgroound);
    $objset->setCellValue('A2','wajib di isi');
    $objset->setCellValue('B2','wajib di isi');
    $objset->setCellValue('C2','wajib di isi');
    $objset->setCellValue('D2','wajib di isi');
    $objset->setCellValue('E2','wajib di isi');

    //isi tabel
    $objset->setCellValue('A3','201806001');
    $objset->setCellValue('B3','Abdullah');
    $objset->setCellValue('C3','1');
    $objset->setCellValue('D3','1');
    $objset->setCellValue('E3','Pegawai Tetap');
    
    $objset->setCellValue('A4','201806002');
    $objset->setCellValue('B4','Dullah');
    $objset->setCellValue('C4','1');
    $objset->setCellValue('D4','1');
    $objset->setCellValue('E4','Pegawai Tidak Tetap');

  	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
  	header('Content-Disposition: attachment;filename="Template_Data_Pegawai.xlsx"');
  	$data = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
  	$data->save('php://output');
  	exit;

?>