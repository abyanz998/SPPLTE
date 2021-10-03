<?php
	function anti_injection($data,$koneksi){
		$filter = mysqli_real_escape_string($koneksi,$data);
		return $filter;
	}

	function average($arr){
		if (!is_array($arr)) return false;
		return array_sum($arr)/count($arr);
	}

	function cek_session_admin(){
		$level = $_SESSION[level];
		if ($level != '0' AND $cekakses <= '0'){
			echo "<script>document.location='index.php?view=dashboard';</script>";
		}
	}
?>