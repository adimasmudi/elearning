<?php
include '../../config/db.php';



// Tampilkan Perangkat Pembelajaran
$sqlPerangkat = mysqli_query($con,"SELECT * FROM tb_materi

                      INNER JOIN tb_roleguru ON tb_materi.id_roleguru=tb_roleguru.id_roleguru

                      INNER JOIN tb_master_kelas ON tb_roleguru.id_kelas=tb_master_kelas.id_kelas

                      INNER JOIN tb_master_mapel ON tb_roleguru.id_mapel=tb_master_mapel.id_mapel

                      WHERE tb_materi.id_materi='$_GET[ID]'");
$d = mysqli_fetch_array( $sqlPerangkat);
// SESION GURU
$sql = mysqli_query($con,"SELECT * FROM tb_guru WHERE id_guru='$d[id_guru]' ") or die(mysqli_error($con));
$data = mysqli_fetch_array($sql);

 $time = time();
      header("Content-Type: application/vnd.msword");
      header("Expires: 0");
      header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
      header("content-disposition: attachment;filename=MATERI_$time.docx");
?>

<!DOCTYPE html>
<html>
<head>
	<style>
		body{
			font-family: "Arial Rounded MT Bold", "Helvetica Rounded", Arial, sans-serif;
         @page{
        size: A4;
        margin: 0;
      }

		}		

	</style>
</head>
<body>
	<center>
		<h3>MATERI PEMBELAJARAN <?=$d['mapel']; ?></h3>
	</center>

<table cellpadding="3">
		<tr>
			<td>NAMA GURU</td>
			<td>:</td>
			<td> <?=$data['nama_guru'] ?></td>
		</tr>
		<tr>
			<td>MATA PELAJARAN</td>
			<td>:</td>
			<td><?=$d['mapel']; ?> </td>
		</tr>
		<tr>
			<td>KELAS</td>
			<td>:</td>
			<td><?=$d['kelas']; ?></td>
		</tr>
		
</table>
<hr>

<?=$d['materi']; ?>



</body>
</html>

