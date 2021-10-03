<?php
	session_start();
	error_reporting(0);
	include "../../config/koneksi.php";
	require_once "../../config/PHPExcel/Classes/PHPExcel.php";

	$idt = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM identitas"));
	$nama_sekolah= $idt['nmSekolah'];
	$lokasi_sekolah=$idt['alamat'].', '.$idt['kecamatan'].', '.$idt['kabupaten'].', '.$idt['propinsi'].' Telp. '.$idt['noTelp'];
	$unit = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM unit_sekolah WHERE idUnit='$_GET[unit]'"));
	$kelas = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM kelas_siswa WHERE idKelas='$_GET[kelas]'"));
	$kamar = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM kamar WHERE idKamar='$_GET[kamar]'"));

	if (($_GET['kelas'] != 'all') && ($_GET['kamar'] == 'all')){
		
		$qSiswa = mysqli_query($koneksi,"SELECT siswa.*, unit_sekolah.singkatanUnit, kelas_siswa.nmKelas, kamar.namaKamar FROM siswa LEFT JOIN unit_sekolah ON siswa.unitSiswa = unit_sekolah.idUnit LEFT JOIN kelas_siswa ON siswa.kelasSiswa = kelas_siswa.idKelas LEFT JOIN kamar ON siswa.kamarSiswa = kamar.idKamar WHERE siswa.stdel='0' AND siswa.unitSiswa='$_GET[unit]' AND siswa.kelasSiswa='$_GET[kelas]' AND statusSiswa='Aktif'");

	}elseif (($_GET['kelas'] == 'all') && ($_GET['kamar'] != 'all')){
		
		$qSiswa = mysqli_query($koneksi,"SELECT siswa.*, unit_sekolah.singkatanUnit, kelas_siswa.nmKelas, kamar.namaKamar FROM siswa LEFT JOIN unit_sekolah ON siswa.unitSiswa = unit_sekolah.idUnit LEFT JOIN kelas_siswa ON siswa.kelasSiswa = kelas_siswa.idKelas LEFT JOIN kamar ON siswa.kamarSiswa = kamar.idKamar WHERE siswa.stdel='0' AND siswa.unitSiswa='$_GET[unit]' AND siswa.kamarSiswa='$_GET[kamar]' AND statusSiswa='Aktif'");

	}elseif (($_GET['kelas'] == 'all') && ($_GET['kamar'] == 'all')){
		
		$qSiswa = mysqli_query($koneksi,"SELECT siswa.*, unit_sekolah.singkatanUnit, kelas_siswa.nmKelas, kamar.namaKamar FROM siswa LEFT JOIN unit_sekolah ON siswa.unitSiswa = unit_sekolah.idUnit LEFT JOIN kelas_siswa ON siswa.kelasSiswa = kelas_siswa.idKelas LEFT JOIN kamar ON siswa.kamarSiswa = kamar.idKamar WHERE siswa.stdel='0' AND siswa.unitSiswa='$_GET[unit]' AND statusSiswa='Aktif'");

	}else{
		
		$qSiswa = mysqli_query($koneksi,"SELECT siswa.*, unit_sekolah.singkatanUnit, kelas_siswa.nmKelas, kamar.namaKamar FROM siswa LEFT JOIN unit_sekolah ON siswa.unitSiswa = unit_sekolah.idUnit LEFT JOIN kelas_siswa ON siswa.kelasSiswa = kelas_siswa.idKelas LEFT JOIN kamar ON siswa.kamarSiswa = kamar.idKamar WHERE siswa.stdel='0' AND siswa.unitSiswa='$_GET[unit]' AND siswa.kelasSiswa='$_GET[kelas]' AND siswa.kamarSiswa='$_GET[kamar]' AND statusSiswa='Aktif'");

	}

	$namaFile = 'Data_Siswa_'.$unit['singkatanUnit'];
	$judul = 'Data Siswa '.$unit['singkatanUnit'];
	if ($_GET['kelas'] != 'all'){
		$namaFile = $namaFile.'_Kelas_'.$kelas['nmKelas'];
		$judul = $judul.' Kelas '.$kelas['nmKelas'];
	}else{
		$namaFile = $namaFile.'_Semua_Kelas';
		$judul = $judul.' Semua Kelas';
	}
	if ($_GET['kamar'] != 'all'){
		$namaFile = $namaFile.'_Kamar_'.$kamar['namaKamar'];
		$judul = $judul.' Kamar '.$kamar['namaKamar'];
	}else{
		$namaFile = $namaFile.'_Semua_Kamar_';
		$judul = $judul.' Semua Kamar ';
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
    $objset->getDefaultStyle()->applyFromArray($style);

    //set lebar kolom otomatis
    foreach(range('A','K') as $columnID) {
    	$objget->getColumnDimension($columnID)->setAutoSize(true);
    }

   	//header identitas sekolah
   	$objget->mergeCells('A1:K1');
   	$objget->getStyle("A1")->getFont()->setSize(16);
   	$objget->getStyle("A1")->getFont()->setBold(true);
   	$objset->setCellValue('A1',$nama_sekolah);
   	$objget->mergeCells('A2:K2');
   	$objget->getStyle("A2")->getFont()->setSize(10);
   	$objset->setCellValue('A2',$lokasi_sekolah);
   	
   	//judul
   	$objget->mergeCells('A4:K4');
   	$objget->getStyle("A4")->getFont()->setSize(12);
   	$objget->getStyle("A4")->getFont()->setBold(true);
   	$objget->getStyle("A4")->getFont()->setUnderline(true);
   	$objset->setCellValue('A4',$judul);

   	//header tabel
   	$styleArray = array(
	  'borders' => array(
	    'allborders' => array(
	      'style' => PHPExcel_Style_Border::BORDER_THIN
	    )
	  )
	);
	$objget->getStyle('A6:K6')->applyFromArray($styleArray);
	$backgroound['fill']=array();
	$backgroound['fill']['type']=PHPExcel_Style_Fill::FILL_SOLID;
	$backgroound['fill']['color']=array();
	$backgroound['fill']['color']['rgb']='dbd7d7';
	$objget->getStyle ( 'A6:K6' )->applyFromArray($backgroound);
   	$objget->getStyle("A6:K6")->getFont()->setBold(true);
	$objset->setCellValue('A6','No');		
    $objset->setCellValue('B6','NIS');
    $objset->setCellValue('C6','Nama Lengkap');
    $objset->setCellValue('D6','Jenis Kelamin');
    $objset->setCellValue('E6','Unit');
    $objset->setCellValue('F6','Kelas');
    $objset->setCellValue('G6','Kamar');
    $objset->setCellValue('H6','Alamat');
    $objset->setCellValue('I6','Nama Ayah');
    $objset->setCellValue('J6','Nama Ibu');
    $objset->setCellValue('K6','No. Hp/Telp. Ortu');

    //isi tabel
    $no=7;
    $urut = 1;
    while($siswa=mysqli_fetch_array($qSiswa)){
		if ($siswa['kamarSiswa'] == '0'){
			$kamarSiswa = '';
		}else{
			$kamarSiswa = $siswa['namaKamar'];
		}
		if($siswa['jkSiswa'] == 'L'){
			$jkSiswa = 'Laki-Laki';
		}elseif($siswa['jkSiswa'] == 'P'){
			$jkSiswa = 'Perempuan';
		}
		$objset->setCellValue('A'.$no,$urut++);
		$objset->setCellValue('B'.$no,$siswa['nisSiswa']);
		$objset->setCellValue('C'.$no,$siswa['nmSiswa']);
		$objset->setCellValue('D'.$no,$jkSiswa);
		$objset->setCellValue('E'.$no,$siswa['singkatanUnit']);
		$objset->setCellValue('F'.$no,$siswa['nmKelas']);
		$objset->setCellValue('G'.$no,$kamarSiswa);
		$objset->setCellValue('H'.$no,$siswa['alamatSiswa']);
		$objset->setCellValue('I'.$no,$siswa['nmAyah']);
		$objset->setCellValue('J'.$no,$siswa['nmIbu']);
		$objset->setCellValue('K'.$no,$siswa['noHpOrtu']);
		//set border
		$styleArray = array(
		  'borders' => array(
		    'allborders' => array(
		      'style' => PHPExcel_Style_Border::BORDER_THIN
		    )
		  )
		);
		$objget->getStyle('A'.$no.':K'.$no)->applyFromArray($styleArray);
		$no++;
	}

  	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
  	header('Content-Disposition: attachment;filename="'.$namaFile.date('d_m_Y').'.xlsx"');
  	$data = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
  	$data->save('php://output');
  	exit;

?>