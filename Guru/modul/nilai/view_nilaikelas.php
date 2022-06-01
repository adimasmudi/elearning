<?php
// kelas ujian
$kelas = mysqli_query($con, "SELECT * FROM kelas_ujian
INNER JOIN tb_master_kelas ON kelas_ujian.id_kelas=tb_master_kelas.id_kelas
WHERE kelas_ujian.id_ujian='$_GET[ujian]'");
foreach ($kelas as $k)

?>

<?php
// data ujian
$ujian = mysqli_query($con, "SELECT * FROM ujian
INNER JOIN tb_jenisujian ON ujian.id_jenis=tb_jenisujian.id_jenis
INNER JOIN tb_master_mapel ON ujian.id_mapel=tb_master_mapel.id_mapel

WHERE ujian.id_ujian='$_GET[ujian]' ORDER BY id_ujian DESC");
foreach ($ujian as $du) ?>
<div class="content-wrapper">
	<h4>
		<b>NILAI</b>
		<small class="text-muted">/
			Daftar Nilai
		</small>
	</h4>
	<div class="row purchace-popup">
		<div class="col-md-12 col-xs-12">
			<span class="d-flex alifn-items-center">
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
			</span>

		</div>
	</div>
	<div class="row">
		<div class="col-md-12 col-xs-12">

			<div class="card">
				<div class="card-body">
					<h4 class="card-title">
						<a href="../Report/nilai/nilai_perkelas.php?ujian=<?= $_GET['ujian']; ?>&kelas=<?= $_GET['kelas']; ?>" target="_blank" class="btn btn-dark text-white text-right"> <i class="fa fa-print text-white"></i> Print</a>

						<a href="../Report/nilai/nilai_perkelasexcl.php?ujian=<?= $_GET['ujian']; ?>&kelas=<?= $_GET['kelas']; ?>" target="_blank" class="btn btn-success text-white text-right"> <i class="fa fa-file-excel-o text-white"></i> Export to Excell</a>
					</h4>
					<div class="table-responsive">



						<table id="data" class='table table-striped'>
							<thead>
								<tr>
									<th>No</th>
									<th>Nama</th>
									<th>Benar</th>
									<th>Salah</th>
									<th>Kosong</th>
									<th>NILAI</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$no = 1;
								$tampil = mysqli_query($con, "SELECT * FROM tb_siswa WHERE id_kelas='$_GET[kelas]' ORDER BY nama_siswa ASC");
								while ($r = mysqli_fetch_array($tampil)) {
									$nli = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM nilai WHERE id_ujian='$_GET[ujian]' AND id_siswa ='$r[id_siswa]'"));
								?>
									<tr>
										<td><?= $no++; ?>.</td>
										<td><?= $r['nama_siswa']; ?></td>
										<td><?= $nli['jml_benar']; ?></td>
										<td><?= $nli['jml_salah']; ?></td>
										<td><?= $nli['jml_kosong']; ?></td>
										<td><?= $nli['nilai']; ?></td>
									</tr>
								<?php } ?>
							</tbody>
						</table>


					</div>
				</div>
			</div>
		</div>
	</div>
</div>