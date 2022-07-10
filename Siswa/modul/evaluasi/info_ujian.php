<div class="content-wrapper">
  <h4> <b>Evaluasi</b> <small class="text-muted">(Informasi Ujian)</small>
  </h4>
  <hr>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <h4 class="text-heading"> DAFTAR UJIAN </h4>
          <p></p>
          <hr>
          <!-- Informasi ujian objektif -->


          <?php

          include "../config/db.php";
          //Cek jumlah ujian pada tanggal sekarang
          $tgl = date('Y-m-d');
          $qujian = mysqli_query($con, "SELECT * FROM ujian t1, kelas_ujian t2 WHERE t1.tanggal='$tgl' AND t1.id_ujian=t2.id_ujian AND t2.id_kelas='$_SESSION[kelas]' AND t2.aktif='Y'");
          $tujian = mysqli_num_rows($qujian);
          $rujian = mysqli_fetch_array($qujian);

          //Jika tidak ada ujian aktif tampilkan pesan
          if ($tujian < 1) {
            echo '
   <div class="alert alert-info">Belum ada ujian Pada Tanggal Sekarang Untuk Kelas Kamu. Jika ada kesalahan hubungi Guru Mata Pelajaran! perbaiki tanggal ujian atau kelas ujian</div>';
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
              <th>Info</th>
            </tr>
            </thead>
          <tbody>';

            $qujian = mysqli_query($con, "SELECT * FROM kelas_ujian 
      INNER JOIN tb_master_kelas ON kelas_ujian.id_kelas=tb_master_kelas.id_kelas
      INNER JOIN ujian ON kelas_ujian.id_ujian=ujian.id_ujian
      INNER JOIN tb_master_mapel ON ujian.id_mapel=tb_master_mapel.id_mapel

    WHERE ujian.tanggal='$tgl' AND ujian.id_ujian=kelas_ujian.id_ujian AND kelas_ujian.id_kelas='$_SESSION[kelas]' AND kelas_ujian.aktif='Y'
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
    <td><b>' . $no . ' .</b></td>
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
    <a href="index.php?page=evaluasi&act=nilai"><i class="fa fa-file-text"></i><b> Lihat Nilai</b> </a>';

              elseif ($tnilai > 0 and $rnilai['sisa_waktu'] != "")
                echo '<td bgcolor="#FF3300">
    <a href="index.php"> <i class="btn btn-block"><i class="fa fa-check-circle-o"></i> Lanjutkan</a>';

              else echo '
    <td bgcolor="#FFFF00">
    <a href="index.php"><i class="fa fa-home"></i> Klik tombol <b>Kerjakan</b> pada ujian yg aktif di Halaman Utama </a>';
              echo '</td>
    </tr>';

              $no++;
            }

            echo '</tbody>
    </table>
    </div>

    ';
          }
          ?>


          <hr>

          


        </div>
      </div>
    </div>
  </div>
</div>