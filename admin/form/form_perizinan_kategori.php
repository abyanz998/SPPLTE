<?php
	$kategori = $_POST['kategori'];

	if ($kategori == 'Pulang Kerumah'){
?>
		<div class="col-md-4">
			<div class="form-group">
               	<label>Penjemput</label>
               	<input type="text" name="perizinan_penjemput" class="form-control" placeholder="Masukan Penjemput" required>
            </div>
        </div>

        <div class="col-md-4">
			<div class="form-group">
	            <label>Waktu Izin</label>
	       		<table>
	              	<tr>
	              		<td style="width: 35%"><input type="number" name="perizinan_waktuizin" class="form-control" min="0" value="0" required></td>
	               		<td><strong>&nbsp;&nbsp;Hari</strong></td>
	               	</tr>
	          	</table>
           </div>	        
	    </div>

        <div class="col-md-8">
			<div class="form-group">
               	<label>Keterangan</label>
               	<input type="text" name="perizinan_keterangan" class="form-control" placeholder="Masukan Keterangan Izin" required>
            </div>
        </div>

        <div class="col-md-6">
        	<button type="submit" name="tambah" class="btn btn-success">Simpan</button>
            <button type="reset" class="btn btn-default" onclick="reset_form()">Kosongkan</button>
        </div>
      
<?php        
	}elseif ($kategori == 'Keluar Pesantren'){
?>		

   		<link rel="stylesheet" href="../../plugins/datetimepicker/bootstrap-datetimepicker.css">
   		<script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
   		<script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>

		<div class="col-md-2">
			<div class="form-group">
               	<label>Jam Keluar</label>
               	<input type="text" name="perizinan_jamkeluar" class="form-control jam" placeholder="00:00" required>
            </div>
        </div>

        <div class="col-md-2">
			<div class="form-group">
               	<label>Jam Kembali</label>
               	<input type="text" name="perizinan_jamkembali" class="form-control jam" placeholder="00:00" required>
            </div>
        </div>

        <div class="col-md-12">
			<div class="form-group">
               	<label>Keterangan</label>
               	<input type="text" name="perizinan_keterangan" class="form-control" placeholder="Masukan Keterangan Izin" required>
            </div>
        </div>
        <div class="col-md-6">
        	<button type="submit" name="tambah" class="btn btn-success">Simpan</button>
            <button type="reset" class="btn btn-default" onclick="reset_form()">Kosongkan</button>
        </div>

        <script type="text/javascript">
        	//waktu plugin
        $('.jam').datetimepicker({
          format: 'hh:ii',
          language:  'en',
          weekStart: 1,
          todayBtn:  1,
          autoclose: 1,
          todayHighlight: 1,
          startView: 1,
          minView: 0,
          maxView: 1,
          forceParse: 0
        });
        </script>
<?php  
	}
?>