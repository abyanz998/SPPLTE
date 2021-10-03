<?php
	session_start();
	error_reporting(0);
	include "../../config/koneksi.php";
	require_once "../../config/PHPExcel/Classes/PHPExcel.php";

	$unit = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM unit_sekolah WHERE idUnit='$_GET[unit]'"));
	$kelas = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM kelas_siswa WHERE idKelas='$_GET[kelas]'"));
	if ($_GET['kelas'] == 'all'){
		$qSiswa = mysqli_query($koneksi,"SELECT siswa.*, unit_sekolah.singkatanUnit, kelas_siswa.nmKelas FROM siswa LEFT JOIN unit_sekolah ON siswa.unitSiswa = unit_sekolah.idUnit LEFT JOIN kelas_siswa ON siswa.kelasSiswa = kelas_siswa.idKelas WHERE siswa.stdel='0' AND siswa.unitSiswa='$_GET[unit]'");
	}else{
		$qSiswa = mysqli_query($koneksi,"SELECT siswa.*, unit_sekolah.singkatanUnit, kelas_siswa.nmKelas FROM siswa LEFT JOIN unit_sekolah ON siswa.unitSiswa = unit_sekolah.idUnit LEFT JOIN kelas_siswa ON siswa.kelasSiswa = kelas_siswa.idKelas WHERE siswa.stdel='0' AND siswa.unitSiswa='$_GET[unit]' AND siswa.kelasSiswa='$_GET[kelas]'");
	}

	$objPHPExcel = new PHPExcel();

    $objset = $objPHPExcel->setActiveSheetIndex(0); //inisiasi set object dan index sheet
    $objget = $objPHPExcel->getActiveSheet();  //inisiasi get object
    $objget->setTitle('Data Siswa');

   
    //all center
     $style = array(
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        )
    );
    $objget->getDefaultStyle()->applyFromArray($style);

	//warna background
	$backgroound['fill']=array();
	$backgroound['fill']['type']=PHPExcel_Style_Fill::FILL_SOLID;
	$backgroound['fill']['color']=array();
	$backgroound['fill']['color']['rgb']='0044ff';
	$objget->getStyle ( 'A1:I1' )->applyFromArray($backgroound);
	
    //ukuran Font
    $objget->getStyle('A1:I1')->getFont()->setBold(true);

    //border
    $styleArray = array(
	  'borders' => array(
	    'allborders' => array(
	      'style' => PHPExcel_Style_Border::BORDER_THIN
	    )
	  )
	);

	$objget->getStyle('A1:I2')->applyFromArray($styleArray);

    //set lebar kolom otomatis
    foreach(range('A','I') as $columnID) {
    	$objget->getColumnDimension($columnID)->setAutoSize(true);
    }

    //header tabel
    $objset->setCellValue('A1','NIS');
    $objset->setCellValue('B1','Nama Lengkap');
    $objset->setCellValue('C1','Unit');
    $objset->setCellValue('D1','Kelas');
    $objset->setCellValue('E1','Kamar');
    $objset->setCellValue('F1','Alamat');
    $objset->setCellValue('G1','Nama Ayah');
    $objset->setCellValue('H1','Nama Ibu');
    $objset->setCellValue('I1','No. Whatsapp Ortu');

    $backgroound['fill']=array();
	$backgroound['fill']['type']=PHPExcel_Style_Fill::FILL_SOLID;
	$backgroound['fill']['color']=array();
	$backgroound['fill']['color']['rgb']='ff0000';
	$objset->getStyle ( 'A2:E2' )->applyFromArray($backgroound);
    $objset->setCellValue('A2','jangan diubah');
    $objset->setCellValue('B2','jangan diubah');
    $objset->setCellValue('C2','jangan diubah');
    $objset->setCellValue('D2','jangan diubah');
    $objset->setCellValue('E2','masukan ID kamar');

    $backgroound['fill']=array();
	$backgroound['fill']['type']=PHPExcel_Style_Fill::FILL_SOLID;
	$backgroound['fill']['color']=array();
	$backgroound['fill']['color']['rgb']='ffff00';
	$objset->getStyle ( 'F2:I2' )->applyFromArray($backgroound);
    $objset->setCellValue('F2','tidak wajib di isi');
    $objset->setCellValue('G2','tidak wajib di isi');
    $objset->setCellValue('H2','tidak wajib di isi');
    $objset->setCellValue('I2','wajib di isi');
   
    //isi tabel
    $no=3;
    while($siswa=mysqli_fetch_array($qSiswa)){
		if ($siswa['kamarSiswa'] == '0'){
			$kamarSiswa = '';
		}else{
			$kamarSiswa = $siswa['kamarSiswa'];
		}
		$objset->setCellValue('A'.$no,$siswa['nisSiswa']);
		$objset->setCellValue('B'.$no,$siswa['nmSiswa']);
		$objset->setCellValue('C'.$no,$siswa['singkatanUnit']);
		$objset->setCellValue('D'.$no,$siswa['nmKelas']);
		$objset->setCellValue('E'.$no,$kamarSiswa);
		$objset->setCellValue('F'.$no,$siswa['alamatSiswa']);
		$objset->setCellValue('G'.$no,$siswa['nmAyah']);
		$objset->setCellValue('H'.$no,$siswa['nmIbu']);
		$objset->setCellValue('I'.$no,$siswa['noHpOrtu']);
		//set border
		$styleArray = array(
		  'borders' => array(
		    'allborders' => array(
		      'style' => PHPExcel_Style_Border::BORDER_THIN
		    )
		  )
		);
		$objget->getStyle('A'.$no.':I'.$no)->applyFromArray($styleArray);

		$no++;
	}
   
  	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
  	header('Content-Disposition: attachment;filename="Template_Update_No_Whatsapp_Ortu.xlsx"');
  	$data = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
  	$data->save('php://output');
  	exit;

?>