  <?php

  $sqld = mysqli_query($con, "SELECT * FROM tb_siswa
    INNER JOIN tb_master_kelas ON tb_siswa.id_kelas=tb_master_kelas.id_kelas
 WHERE id_siswa = '$sesi' ") or die(mysqli_error($con));
  $d = mysqli_fetch_array($sqld);
  ?>
  <div class="content-wrapper">
    <div class="row">
      <div class="col-md-4 d-flex align-items-stretch grid-margin">
        <div class="row flex-grow">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title text-center">My Profile</h4>
                <p class="card-description text-center">

                  <img src="../vendor/images/img_Siswa/<?= $data['foto']; ?>" style="border:3px solid black;width: 100px;height: 100px;border-radius: 7px;" />

                </p>

                <form class="forms-sample" method="post" action="?page=proses" enctype="multipart/form-data">
                  <div class="form-group">
                    <label>Username</label>
                    <input type="hidden" name="ID" value="<?= $data['id_siswa'] ?>">
                    <input type="text" class="form-control" name="nis" value="<?= $data['username'] ?>">
                  </div>
                  <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" class="form-control" name="nama" value="<?= $data['nama_siswa'] ?>">
                  </div>
                  <div class="form-group">
                    <label>Kelas <?php if (empty($d['id_kelas'])) {
                                    echo "<em class='text-danger'> [ Kelas Belum dipilih ! ] </em>";
                                  } ?></label>
                    <select class="form-control" id="kelas" name="kelas" style="font-weight: bold;">
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
                    <label>Password</label>
                    <input type="password" name="password" id="myInput" class="form-control" required>
                    <input type="checkbox" onclick="myFunction()"><sup> Show Password</sup>
                  </div>
                  <div class="form-group">
                    <label>Foto</label>
                    <input id="file" type="file" name="foto" class="form-control">
                  </div>

                  <button type="submit" name="porifilUpdate" class="btn btn-info mr-2">Update</button>
                  <a href="javascript:history.back()" class="btn btn-light">Batal</a>
                </form>

              </div>
            </div>
          </div>
        </div>
      </div>


    </div>
  </div>
  <script>
    function myFunction() {
      var x = document.getElementById("myInput");
      if (x.type === "password") {
        x.type = "text";
      } else {
        x.type = "password";
      }
    }
  </script>