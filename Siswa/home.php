<?php
session_start();
include "../config/db.php";

echo '<div class="grup">
<div class="kiri">
 <div class="top-heading">

<h4>Daftar Ujian</h4></div> <br>';


//Cek jumlah ujian pada tanggal sekarang
$tgl = date('Y-m-d');
$qujian = mysqli_query($con, "SELECT * FROM ujian t1, kelas_ujian t2 WHERE t1.tanggal='$tgl' AND t1.id_ujian=t2.id_ujian AND t2.id_kelas='$_SESSION[kelas]' AND t2.aktif='Y'");
$tujian = mysqli_num_rows($qujian);
$rujian = mysqli_fetch_array($qujian);

//Jika tidak ada ujian aktif tampilkan pesan
if ($tujian < 1) {
  echo '
   <div class="alert alert-info">Belum ada ujian Pada Tanggal Sekarang Untuk Kelas Kamu. Jika ada kesalahan hubungi Operator! perbaiki tanggal ujian atau kelas ujian</div>';
}

//Jika ada dua atau lebih ujian aktif tampilkan pada tabel
else {
  echo '<div class="table-responsive">
          <table class="table table-striped" id="data">
            <thead>
            <tr>
              <th>No</th>
              <th>Judul</th>
              <th>Pelajaran</th>
              <th>Jenis Ujian</th>
              <th>Aksi</th>
            </tr>
            </thead>
          <tbody>';

  $qujian = mysqli_query($con, "SELECT * FROM kelas_ujian 
      INNER JOIN tb_master_kelas ON kelas_ujian.id_kelas=tb_master_kelas.id_kelas
      INNER JOIN ujian ON kelas_ujian.id_ujian=ujian.id_ujian
      INNER JOIN tb_master_mapel ON ujian.id_mapel=tb_master_mapel.id_mapel

    WHERE ujian.tanggal='$tgl' AND ujian.id_ujian=kelas_ujian.id_ujian AND kelas_ujian.id_kelas='$_SESSION[kelas]'  AND kelas_ujian.aktif='Y'
    ");
  $no = 1;
  while ($r = mysqli_fetch_array($qujian)) {

    $kelas_ujian = array();
    $qkelas_ujian = mysqli_query($con, "SELECT * FROM tb_master_kelas t1, kelas_ujian t2

       WHERE  t1.id_kelas=t2.id_kelas AND t2.id_ujian='$r[id_ujian]'");
    while ($rku = mysqli_fetch_array($qkelas_ujian)) {
      $kelas_ujian[] = $rku['kelas'];
    }

    echo '
    <tr>
    <td><b>' . $no . '</b></td>
    <td><b>' . $r['judul'] . '</b></td>
    <td><b>' . $r['mapel'] . '</b></td>
    ';
    $jenis = mysqli_query($con, "SELECT * FROM tb_jenisujian WHERE id_jenis='$r[id_jenis]'");
    $ju = mysqli_fetch_array($jenis);
    echo '<td><b>' . $ju['jenis_ujian'] . '</b></td>';


    //Jika nilai sudah ada tampilkan tombol Sudah Mengerjakan, jika belum ada tampilkan tombol Kerjakan
    $qnilai = mysqli_query($con, "SELECT * FROM nilai WHERE id_ujian='$r[id_ujian]' AND id_siswa='$_SESSION[id_siswa]' ");
    $tnilai = mysqli_num_rows($qnilai);
    $rnilai = mysqli_fetch_array($qnilai);

    if ($tnilai > 0 and $rnilai['nilai'] != "")
      echo '<td bgcolor= bordercolordark="#00FF33" >
    <a onclick="show_nilai(' . $r['id_ujian'] . ')"  class="btn btn-block"><i class="fa fa-search"></i> Lihat Nilai</a>';

    elseif ($tnilai > 0 and $rnilai['sisa_waktu'] != "")
      echo '<td bgcolor="#FF3300">
    <a onclick="show_ujian(' . $r['id_ujian'] . ')"  class="btn btn-block"><i class="fa fa-check-circle-o"></i> Lanjutkan</a>';

    else echo '<td bgcolor="#FFFF00">
    <a onclick="show_detail(' . $r['id_ujian'] . ')" class="btn btn-block"><i class="fa fa-edit"></i> Kerjakan</a>';
    echo '</td>
    </tr>';

    $no++;
  }

  echo '</tbody>
    </table>
    </div>';
}
?>
<br>

<!-- INFORMASI MENGENAI MATERI terpost -->
<?php
$no = 1;
$sqlmtr = mysqli_query($con, "SELECT * FROM tb_materi

      INNER JOIN tb_roleguru ON tb_materi.id_roleguru=tb_roleguru.id_roleguru

    INNER JOIN tb_master_mapel ON tb_roleguru.id_mapel=tb_master_mapel.id_mapel
    
   WHERE tb_roleguru.id_kelas='$_SESSION[kelas]' AND public='Y' AND tb_materi.tgl_entry='$tgl' ORDER BY tb_materi.id_materi DESC LIMIT 5 ");
$jml = mysqli_num_rows($sqlmtr);
foreach ($sqlmtr as $row) { ?>
  <div class="alert alert-info alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <strong>Baru!</strong> Materi <b><?= $row['mapel'] ?> </b> Untuk kelas kamu ! <a href="?page=materi&act=mapel&ID=<?= $row['id_mapel']; ?>&mp=<?= $row['mapel']; ?>">Lihat</a>
  </div>
<?php
}
?>

<?php


echo '</div> ';
?>
<div class="card">
  <div class="card-body wrap" style="margin-left:20px;background-color:#F5F5F5;border-radius:20px; overflow: scroll;height: 600px;">
    <h4><b><i class="fa fa-wechat text-success"></i></b> <b class="text-success">Chat</b> Box</h4>
    <center>
      <!-- <a href="https://api.whatsapp.com/send?phone=628127577440&text=Halo%20Admin,%20Saya%20mau%20daftar%20jadi%20agenpos%20mohon%20petunjuk%20lebih%20lanjut....."><img src="https://1.bp.blogspot.com/-d9e_wOY69MY/WRM3fYv--rI/AAAAAAAAIDM/aMGRV5d2yTcdEy7KT4kOY6Ok1IZPWvDqQCLcB/s200/Cara%2BMudah%2BMembuat%2BLink%2BWhatsapp%2BLangsung%2BChat%2Bdi%2BWebsite%2B-%2Blogo.png" style="width: 30px;" / /></a> -->
    </center>

    <hr>

    <?php
    // Tampilkan Role Guru
    $roleGuru = mysqli_query($con, "SELECT * FROM tb_siswa WHERE id_siswa='$_SESSION[id_siswa]'") or die(mysqli_error($con));
    foreach ($roleGuru as $rg) { ?>

      <?php
      // query pesan

      $query_daftar_pesan = mysqli_query($con, "SELECT P.*, M.kode_guru, M.nama_guru,M.foto
  FROM pesan P, tb_guru M WHERE P.id_pengirim=M.kode_guru  AND P.id_kelas='$rg[id_kelas]' ORDER BY P.id_pesan DESC");

      while ($daftar_pesan = mysqli_fetch_array($query_daftar_pesan)) {
        $kelas = mysqli_query($con, "SELECT kelas FROM tb_master_kelas WHERE id_kelas='$daftar_pesan[id_kelas]' ");

        foreach ($kelas as $kls)

          if ($daftar_pesan['sudah_dibaca'] == "belum") {

      ?>

          <div data-toggle="modal" data-target="#Apply<?php echo $daftar_pesan['id_pengirim']; ?>" class="alert alert-warning alert-dismissible" role="alert">
            <a href="?page=chat&act=del&id=<?php echo $daftar_pesan['id_pesan']; ?>" class="close"><i class="fa fa-trash text-danger" style="font-size: 16px;"></i></a>
            <strong><?php echo $daftar_pesan['nama_guru']; ?></strong> <em style="font-size: 10px;"><?php echo date('d-m-Y', strtotime($daftar_pesan['tanggal'])); ?></em> <br><?php echo $daftar_pesan['isi_pesan']; ?>

          </div>
          <p>
            <a href="" class="btn btn-light text-success" data-toggle="modal" data-target="#Apply<?php echo $daftar_pesan['id_pengirim']; ?>"><i class="fa fa-angle-double-right"></i> Balas</a>

          </p>


          <!-- Modal Detail-->
          <div class="modal fade" id="Apply<?php echo $daftar_pesan['id_pengirim']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title"> <b><i class="fa fa-wechat"></i> Balas Pesan</b> </h4>
                </div>
                <form action="?page=chat" method="post">
                  <div class="modal-body">
                    <p>
                      <img src="../vendor/images/img_Guru/<?php echo $daftar_pesan['foto']; ?>" style="width: 50px;height: 50px;border-radius: 100%;"> <strong><?php echo $daftar_pesan['nama_guru']; ?></strong>
                    </p>
                    <div style="background-color: #fff;padding: 6px;border-radius: 10px;">
                      <p><?php echo $daftar_pesan['isi_pesan']; ?></p>
                    </div>
                    <p></p>
                    <div class="form-group">
                      <input type="hidden" name="pengirim" value="<?php echo $_SESSION['username']; ?>">
                      <input type="hidden" name="status" value="<?php echo $daftar_pesan['id_pesan']; ?>">
                      <input type="hidden" name="penerima" value="<?php echo $daftar_pesan['kode_guru']; ?>">
                      <input type="hidden" name="kelas" value="<?php echo $daftar_pesan['id_kelas']; ?>">

                      <textarea name="isi_pesan" id="ckeditor" class="form-control" rows="5">Tulis Pesan</textarea>
                    </div>

                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button name="sendMassage" type="submit" class="btn btn-info"><i class="fa fa-send"></i> Kirim Pesan</button>
                  </div>
                </form>


              </div>
            </div>
          </div>

        <?php } else if ($daftar_pesan['sudah_dibaca'] == "sudah") {
        ?>
          <div class="alert alert-default alert-dismissible" role="alert" style="border-radius: 10px;background: #ECEFF1;color: black;">
            <a href="?page=chat&act=del&id=<?php echo $daftar_pesan['id_pesan']; ?>" class="close"><i class="fa fa-trash text-danger" style="font-size: 16px;"></i></a>

            <strong><?php echo $daftar_pesan['nama_guru']; ?></strong> <em style="font-size: 10px;"><?php echo date('d-m-Y', strtotime($daftar_pesan['tanggal'])); ?></em> <br><?php echo $daftar_pesan['isi_pesan']; ?>
          </div>

      <?php
          }
      }
      ?>
    <?php } ?>


    <form action="?page=chat" method="post">
      <div class="form-group">
        <br>
        <select class="form-control" name="penerima" style="font-weight: bold;font-size: 16px;border-radius: 10px;" required>
          <option>Kirim Ke</option>
          <?php
          // tampilkan guru yg ada di role
          $sqlrole = mysqli_query($con, "SELECT * FROM tb_roleguru
            WHERE id_kelas='$_SESSION[kelas]' GROUP BY id_guru");
          while ($role = mysqli_fetch_array($sqlrole)) { ?>
            <?php
            // tampilkan data guru
            $sqlGuru = mysqli_query($con, "SELECT * FROM tb_guru WHERE id_guru='$role[id_guru]'");
            while ($guru = mysqli_fetch_array($sqlGuru)) {
              echo "<option value='$guru[kode_guru]'>$guru[nama_guru]</option>";
            }
            ?>

          <?php } ?>
        </select>



        <!-- <input type="hidden" name="idpengirim" id="id_guru"> -->
        <input type="hidden" name="idkelas" value="<?php echo "$_SESSION[kelas]"; ?> ">

      </div>
      <div class="form-group">
        <input type="hidden" name="idpengirim" value="<?php echo "$_SESSION[id_siswa]"; ?>">
        <textarea name="pesan" class="form-control" rows="5" id="ckeditor1">Tulis Pesan</textarea>
      </div>
      <div class="form-group">
        <button name="sendMassageMassal" type="submit" class="btn btn-light"><i class="fa fa-send"></i> Kirim</button>
      </div>

    </form>



  </div>
</div>
<?php
echo '</div>';
?>