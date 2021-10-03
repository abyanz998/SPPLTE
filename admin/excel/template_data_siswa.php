<?php
	require_once "../../config/PHPExcel/Classes/PHPExcel.php";

	$objPHPExcel = new PHPExcel();

    $objset = $objPHPExcel->setActiveSheetIndex(0); //inisiasi set object dan index sheet
    $objget = $objPHPExcel->getActiveSheet();  //inisiasi get object
    $objget->setTitle('Data Siswa');

    //mengatur border tabel
    $thin = array ();
	$thin['borders']=array();
	$thin['borders']['allborders']=array();
	$thin['borders']['allborders']['style']=PHPExcel_Style_Border::BORDER_THIN  ;
	$objset->getStyle ( 'A1:H3' )->applyFromArray($thin);
    //posisi center
    $center = array();
	$center ['alignment']=array();
	$center ['alignment']['horizontal']=PHPExcel_Style_Alignment::HORIZONTAL_CENTER;
	$center ['alignment']['vertical']=PHPExcel_Style_Alignment::VERTICAL_CENTER;
	$objset->getStyle ( 'A1:H10' )->applyFromArray ($center);
	//warna background
	$backgroound['fill']=array();
	$backgroound['fill']['type']=PHPExcel_Style_Fill::FILL_SOLID;
	$backgroound['fill']['color']=array();
	$backgroound['fill']['color']['rgb']='000000';
	$objset->getStyle ( 'A1:H1' )->applyFromArray($backgroound);
	//warna tulisan
    $objget->getStyle('A1:H1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
    //ukuran Font
    $objset->getStyle('A1:H1')->getFont()->setBold(true);
    //mengatur height baris 
    $objPHPExcel->getSheet(0)->getRowDimension('1')->setRowHeight(35);
    //set lebar kolom otomatis
    foreach(range('A','H') as $columnID) {
    	$objget->getColumnDimension($columnID)->setAutoSize(true);
    }
    //header tabel
    $objset->setCellValue('A1','NIS SANTRI');
    $objset->setCellValue('B1','NAMA SANTRI');
    $objset->setCellValue('C1','ID UNIT');
    $objset->setCellValue('D1','ID KELAS');
    $objset->setCellValue('E1','ID KAMAR');
    $objset->setCellValue('F1','NAMA AYAH');
    $objset->setCellValue('G1','NO. HP ORTU');
    $objset->setCellValue('H1','ALAMAT');

    $backgroound['fill']=array();
	$backgroound['fill']['type']=PHPExcel_Style_Fill::FILL_SOLID;
	$backgroound['fill']['color']=array();
	$backgroound['fill']['color']['rgb']='FFFF00';
	$objset->getStyle ( 'A2:D2' )->applyFromArray($backgroound);
    $objset->setCellValue('A2','wajib di isi');
    $objset->setCellValue('B2','wajib di isi');
    $objset->setCellValue('C2','wajib di isi');
    $objset->setCellValue('D2','wajib di isi');

    $backgroound['fill']=array();
	$backgroound['fill']['type']=PHPExcel_Style_Fill::FILL_SOLID;
	$backgroound['fill']['color']=array();
	$backgroound['fill']['color']['rgb']='40ad59';
	$objset->getStyle ( 'E2:H2' )->applyFromArray($backgroound);
    $objset->setCellValue('E2','tidak wajib di isi');
    $objset->setCellValue('F2','tidak wajib di isi');
    $objset->setCellValue('G2','tidak wajib di isi');
    $objset->setCellValue('H2','tidak wajib di isi');
   
    //isi tabel
    $objset->setCellValue('A3','201706001');
    $objset->setCellValue('B3','Sofie Giska Nuraudila');
    $objset->setCellValue('C3','1');
    $objset->setCellValue('D3','1');
    $objset->setCellValue('E3','1');
    $objset->setCellValue('F3','Abdullah');
    $objset->setCellValue('G3','0811000000000');
    $objset->setCellValue('H3','Jalan Klengkeng RT 01 RW 02 Desa Kecamatan Blora Jateng');
   

  	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
  	header('Content-Disposition: attachment;filename="Template_Data_Siswa.xlsx"');
  	$data = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
  	$data->save('php://output');
  	exit;

?>