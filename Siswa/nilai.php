<?php
session_start();
include "../config/db.php";

$kelas = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM tb_master_kelas WHERE id_kelas='$_SESSION[kelas]'"));
$mapel = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM ujian
  INNER JOIN tb_master_mapel ON ujian.id_mapel=tb_master_mapel.id_mapel
 WHERE id_ujian='$_GET[ujian]'"));
$soal = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM soal WHERE id_ujian='$_GET[ujian]'"));
$nilai = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM nilai WHERE id_ujian='$_GET[ujian]' AND id_siswa='$_SESSION[id_siswa]'"));

?>
<div class="grup" style="width:95%; margin:0 auto; margin-top:25px">
  <div class="kiri">
    <div class="list-group-item top-heading">
      <h4 class="list-group-item-heading page-label">Nilai Kamu</h4>
    </div>

    <div class="alert alert-info">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Username</th>
            <th><b><?= $_SESSION['username']; ?> </b></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Nama</td>
            <td><b><?= $_SESSION['nama_siswa']; ?> </b></td>
          </tr>
          <tr>
            <td>Kelas</td>
            <td><b><?= $kelas['kelas']; ?></b></td>
          </tr>
          <tr>
            <td>Pelajaran</td>
            <td><b><?= $mapel['mapel']; ?></b></td>
          </tr>
          <tr>
            <td>Jml. Soal</td>
            <td><b><?= $mapel['jml_soal']; ?></b></td>
          </tr>
          <tr>
            <td>Jawaban Benar</td>
            <td><b><?= $nilai['jml_benar']; ?> </b></td>
          </tr>
          <tr>
            <td>Jawaban Salah</td>
            <td><b><?= $nilai['jml_salah']; ?> </b></td>
          </tr>
          <tr>
            <td>Jawaban Kosong</td>
            <td><b><?= $nilai['jml_kosong']; ?> </b></td>
          </tr>

        </tbody>
      </table>
      <Center>
        <p> Nilai :</p>
        <font size="50px" color="#FF0000"><?= $nilai['nilai']; ?> </font>
        <a href="index.php"><button class="btn btn-info btn-block doblockui">kembali</button></a>
      </Center>
    </div>
  </div>
  



</div>