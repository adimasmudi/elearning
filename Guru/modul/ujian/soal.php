<div class="content-wrapper">
  <h4>
    <b>SOAL OBJEKTIF</b>
    <small class="text-muted">/
      Data Soal
    </small>
  </h4>
  <div class="row purchace-popup">
    <div class="col-md-12">
      <span class="d-flex alifn-items-center">
        <a href="?page=ujian&act=soaladd&ID=<?= $_GET['id']; ?>" class="btn btn-dark"> <i class="fa fa-plus text-white"></i> Add Soal</a>
        
        <a href="../Report/soal/print_soal.php?ID=<?= $_GET['id']; ?>" target="_blank" class="btn btn-danger"> <i class="fa fa-download text-white"></i> Download Soal</a>

      </span>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12 col-xs-12">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Daftar Soal Objektif</h4>
          <div class="table-responsive">
            <table class='table table-striped'>
              <thead>
                <tr>
                  <th width="10">No</th>
                  <th>Soal</th>
                  <th>Pilihan Ganda</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $nomor = 1;
                $tampil = mysqli_query($con, "SELECT * FROM soal WHERE id_ujian='$_GET[id]' ORDER BY id_soal ASC");
                while ($r = mysqli_fetch_array($tampil)) { ?>

                  <tr>
                    <td><?= $nomor++; ?> .</td>
                    <td><b><?= $r['soal']; ?></b></td>
                    <td>
                      <ol type='A'>
                        <?php
                        for ($i = 1; $i <= 5; $i++) {
                          $kolom = "pilihan_$i";
                          if ($r['kunci'] == $i) {
                            echo "<li style='font-weight: bold'>$r[$kolom]</li>";
                          } else {
                            echo "<li>$r[$kolom]</li>";
                          }
                        }

                        ?>
                      </ol>
                    </td>
                    <td>
                      <a href="?page=ujian&act=soaledit&ids=<?= $r['id_soal']; ?>&ujian=<?= $_GET['id']; ?>" class='btn btn-dark btn-sm'><i class='fa fa-pencil'></i></a>
                      <a href="?page=ujian&act=soaldel&ids=<?= $r['id_soal']; ?>&id=<?= $_GET['id']; ?>" class='btn btn-dark btn-sm text-danger'><i class='fa fa-trash'></i></a>
                    </td>
                  </tr>
                <?php
                }
                ?>
              </tbody>

            </table>




          </div>

        </div>
      </div>
    </div>

  </div>
</div>
</div>
</div>
</div>

