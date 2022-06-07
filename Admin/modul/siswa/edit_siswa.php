<?php
$edit = mysqli_query($con, "SELECT * FROM tb_siswa WHERE id_siswa='$_GET[id]' ");
foreach ($edit as $d)

?>
<div class="content-wrapper">
  <h4> <b>ADMIN</b> <small class="text-muted">(Edit Siswa)</small>
  </h4>
  <hr>
  <div class="row">
    <div class="col-md-6 d-flex align-items-stretch grid-margin">
      <div class="row flex-grow">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Form Edit Siswa</h4>
              <form class="forms-sample" action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                  <label>Username</label>
                  <input name="nis" type="text" class="form-control" value="<?= $d['username'] ?>">
                  <input type="hidden" name="ID" value="<?= $d['id_siswa'] ?>">
                </div>
                <div class="form-group">
                  <label>Nama Lengkap Siswa</label>
                  <input name="nama" type="text" class="form-control" value="<?= $d['nama_siswa'] ?>">
                </div>

                <div class="form-group">
                  <div class="form-radio form-radio-flat">
                    <label class="form-check-label">
                      <input type="radio" class="form-check-input" name="jk" id="lk" value="L" <?php if ($d['jk'] == 'L') {
                                                                                                  echo "checked";
                                                                                                } ?>>
                      Laki-laki
                    </label>
                  </div>
                  <div class="form-radio form-radio-flat">
                    <label class="form-check-label">
                      <input type="radio" class="form-check-input" name="jk" id="pr" value="P" <?php if ($d['jk'] == 'P') {
                                                                                                  echo "checked";
                                                                                                } ?>>
                      Perempuan
                    </label>
                  </div>
                </div>


                <div class="form-group">
                  <label for="kelas">Kelas Siswa</label>
                  <select class="form-control" id="kelas" name="kelas">
                    <option>-- Pilih --</option>
                    <?php
                    $sqlKelas = mysqli_query($con, "SELECT * FROM tb_master_kelas ORDER BY id_kelas DESC");
                    while ($kelas = mysqli_fetch_array($sqlKelas)) {
                      if ($kelas['id_kelas'] == $d['id_kelas']) {
                        $selected = "selected";
                      } else {
                        $selected = "";
                      }
                      echo "<option value='$kelas[id_kelas]' $selected>$kelas[kelas]</option>";
                    }
                    ?>
                  </select>
                </div>


                <div class="form-group">
                  <label>Foto</label>
                  <input name="foto" type="file" class="form-control">
                </div>

                <button name="updateSiswa" type="submit" class="btn btn-success mr-2">Submit</button>
                <button onclick='goBack()' class="btn btn-light">Cancel</button>
              </form>

              <?php

              if (isset($_POST['updateSiswa'])) {

                $pass = sha1($_POST['username']);

                $gambar = time() . "-" . @$_FILES['foto']['name'];
                if (!empty($_FILES['foto']['name'])) {
                  $select = mysqli_query($con, "select foto from tb_siswa where id_siswa='$_POST[ID]'");
                  $imagee = mysqli_fetch_array($select);
                  unlink('../vendor/images/img_Siswa/' . $imagee['foto']);
                  move_uploaded_file($_FILES['foto']['tmp_name'], "../vendor/images/img_Siswa/$gambar");
                  $updateSiswa = mysqli_query($con, "UPDATE tb_siswa SET nama_siswa='$_POST[nama]',jk='$_POST[jk]',foto='$gambar',id_kelas='$_POST[kelas]' WHERE id_siswa='$_POST[ID]' ");
                  if ($updateSiswa) {
                    echo "
                        <script type='text/javascript'>
                        setTimeout(function () {
                        swal({
                        title: 'SUKSES',
                        text:  'Data Diperbarui !!',
                        type: 'success',
                        timer: 3000,
                        showConfirmButton: true
                        });     
                        },10);  
                        window.setTimeout(function(){ 
                        window.location.replace('?page=siswa');
                        } ,3000);   
                        </script>";
                  }
                } else {
                  $updateSiswaa = mysqli_query($con, "UPDATE tb_siswa SET nama_siswa='$_POST[nama]',jk='$_POST[jk]',id_kelas='$_POST[kelas]' WHERE id_siswa='$_POST[ID]' ");
                  if ($updateSiswaa) {
                    echo "
                        <script type='text/javascript'>
                        setTimeout(function () {
                        swal({
                        title: 'SUKSES',
                        text:  'Data Diperbarui !!',
                        type: 'success',
                        timer: 3000,
                        showConfirmButton: true
                        });     
                        },10);  
                        window.setTimeout(function(){ 
                        window.location.replace('?page=siswa');
                        } ,3000);   
                        </script>";
                  }
                }
              }

              ?>

            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
<script>
  function goBack() {
    window.history.back();
  }
</script>