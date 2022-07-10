
<?php
session_start();
 include '../../config/db.php';

if (@$_SESSION['Guru']) {
?>
<?php
if (@$_SESSION['Guru']) {
$sesi = @$_SESSION['Guru'];
}
$sql = mysqli_query($con,"SELECT * FROM tb_guru WHERE id_guru = '$sesi'") or die(mysqli_error($con));
$data = mysqli_fetch_array($sql);

 ?>



<?php 
// kelas ujian
$kelas = mysqli_query($con, "SELECT * FROM kelas_ujian
INNER JOIN tb_master_kelas ON kelas_ujian.id_kelas=tb_master_kelas.id_kelas
WHERE kelas_ujian.id_ujian='$_GET[ujian]' AND kelas_ujian.id_kelas='$_GET[kelas]' ");
foreach ($kelas as $k)

 ?>

<?php 
// data ujian
$ujian = mysqli_query($con,"SELECT * FROM ujian
INNER JOIN tb_jenisujian ON ujian.id_jenis=tb_jenisujian.id_jenis
INNER JOIN tb_master_mapel ON ujian.id_mapel=tb_master_mapel.id_mapel
WHERE ujian.id_ujian='$_GET[ujian]' ORDER BY id_ujian DESC");
foreach ($ujian as $du) ?>
<style>
	body{
		font-family: Verdana, Geneva, Tahoma, sans-serif;
		
	}
</style>
<?php

// Skrip berikut ini adalah skrip yang bertugas untuk meng-export data tadi ke excell
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=$du[mapel]-$k[kelas].xlsx");?>

	         <center>
	         
	         	<h4>DAFTAR HASIL UJIAN/NILAI SISWA</h4></center>
	     <p></p>
<table class="table" style="font-weight:bold;width: 400px;">
	<tr>
		<td>MATA PELAJARAN</td>
		<td>:</td>
		<td><?php echo $du['mapel']; ?></td>
	</tr>
	<tr>
		<td>KELAS</td>
		<td>:</td>
		<td><?php echo $k['kelas']; ?></td>
	</tr>
	<tr>
		<td>JENIS UJIAN</td>
		<td>:</td>
		<td><?php echo $du['jenis_ujian']; ?></td>
	</tr>
</table>


 <hr>
      



	<table width="100%" border="1" style="border-collapse: collapse;" cellpadding="3">
	<thead>
	<tr style="height: 40px;background-color: #00BCD4;">
	<th width="10">No</th>	
	<th>Nama Siswa</th>
	<th>Jawaban Benar</th>
	<th>Jawaban Salah</th>
	<th>Jawaban Kosong</th>
	<th>NILAI</th>	
	</tr>
	</thead>
	<tbody>
	<?php 
	$no = 1;
	$tampil = mysqli_query($con, "SELECT * FROM tb_siswa WHERE id_kelas='$_GET[kelas]' ORDER BY nama_siswa ASC");
	while($r=mysqli_fetch_array($tampil)){
	$nli = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM nilai WHERE id_ujian='$_GET[ujian]' AND id_siswa ='$r[id_siswa]'"));
	?>
	<tr>
		<td><?=$no++; ?>.</td>
		<td><?=$r['nama_siswa']; ?></td>
		<td><?=$nli['jml_benar']; ?></td>
		<td><?=$nli['jml_salah']; ?></td>
		<td><?=$nli['jml_kosong']; ?></td>
		<td><?=$nli['nilai']; ?></td>
	</tr>
<?php } ?>
	</tbody>
	</table>
	<br>
    <table width="100%">
            <!--    <a href="#" class="no-print" onclick="window.print();"> <button style="height: 40px; width: 70px; background-color: dodgerblue;border:none; color: white; border-radius:7px;font-size: 17px; " type=""> Cetak</button> </a> -->
              <tr>
                <td align="right" colspan="6" rowspan="" headers="">
                    <p>Agam, <?php echo date (" d F Y") ?></p>
                    <p> Guru Mata Pelajaran </p>
                     <br> <br>
                    <p><?php echo $data['nama_guru'];?><br>
                    ---------------------------------- </p>
                </td>
              </tr>
            </table>

<?php
} else{

	

echo "<script>
window.location='../../index.php';</script>";

}