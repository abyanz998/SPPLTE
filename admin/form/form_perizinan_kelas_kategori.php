<?php
	$kategori = $_POST['kategori'];

	if ($kategori == 'Pulang Kerumah'){
?>  
  <div class="col-md-4">
    <div class="box box-success">
      <div class="box-header">
        <h3 class="box-title">Input Perizinan</h3>
      </div>
      <div class="box-body">
        <div class="form-group">            
          <label class="col-sm-4">Penjemput</label>
          <div class="col-sm-8">
            <input type="text" name="perizinan_penjemput" class="form-control" placeholder="Masukan Penjemput" required="">
          </div>
        </div>

        <div class="form-group">            
          <label class="col-sm-4">Waktu Izin</label>
          <div class="col-sm-8">
            <table>
              <tr>
                <td style="width: 35%"><input type="number" name="perizinan_waktuizin" class="form-control" min="0" value="0" required></td>
                <td><strong>&nbsp;&nbsp;Hari</strong></td>
              </tr>
            </table>
          </div>
        </div>

        <div class="form-group">            
          <label class="col-sm-4">Keterangan</label>
          <div class="col-sm-8">
            <input type="text" name="perizinan_keterangan" class="form-control" placeholder="Masukan Keterangan Izin" required>
          </div>
        </div>
      </div>
    </div>
  </div>

      
<?php        
	}elseif ($kategori == 'Keluar Pesantren'){
?>		

   		<link rel="stylesheet" href="../../plugins/datetimepicker/bootstrap-datetimepicker.css">
   		<script src="../../plugins/jQuery/jQuery-2.1.4.min.js"></script>
   		<script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>

      <div class="col-md-4">
        <div class="box box-success">
          <div class="box-header">
            <h3 class="box-title">Input Perizinan</h3>
          </div>
          <div class="box-body">
            <div class="form-group">            
              <label class="col-sm-4">Jam Keluar</label>
              <div class="col-sm-8">
                <input type="text" name="perizinan_jamkeluar" class="form-control jam" placeholder="00:00" required>
              </div>
            </div>

            <div class="form-group">            
              <label class="col-sm-4">Jam Kembali</label>
              <div class="col-sm-8">
                <input type="text" name="perizinan_jamkembali" class="form-control jam" placeholder="00:00" required>
              </div>
            </div>

            <div class="form-group">            
              <label class="col-sm-4">Keterangan</label>
              <div class="col-sm-8">
                <input type="text" name="perizinan_keterangan" class="form-control" placeholder="Masukan Keterangan Izin" required>
              </div>
            </div>
          </div>
        </div>
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