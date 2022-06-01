<div class="content-wrapper">
    <h4>
        <b>EVALUASI</b>
        <small class="text-muted">/
            UJIAN
        </small>
    </h4>
    <div class="row purchace-popup">
        <div class="col-md-12 col-xs-12">
            <span class="d-flex alifn-items-center">
                <a class="btn btn-dark" data-toggle="modal" data-target="#addUjian"> <i class="fa fa-plus"></i> Add Ujian</a>
            </span>
        </div>
    </div>
    <div class="row">

        <div class="col-md-12 col-xs-12">

            <div class="alert alert-info alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Petunjuk LANGKAH!</strong> <br>
                <ul>
                    <li> Klik <b>buat soal</b> Untuk Menambahkan Soal.</li>
                    <li> Klik <b>Pilih Kelas</b> Untuk menambahkan kelas yang akan ujian dan otomatis aktif setelah memilih kelas.</li>
                    <li> Klik <b>Status Ujian</b> Untuk Membuka dan Menutup Ujian. </li>
                    <li>Ujian Akan aktif di halaman Siswa, Apabila anda mengatur <b>tanggal</b> pada hari dimanana ujian akan dilaksanakan dan status ujian <b>Aktif</b></li>
                    <li>Untuk memantau siswa yang sedang mengikuti ujian, anda bisa memilih tombol berwarna kuning pada kolom status Ujian</li>
                </ul>


            </div>

            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Data Ujian</h4>
                    <p class="card-description">

                    </p>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-condensed" id="data">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Jenis Soal</th>
                                    <th>Tgl Ujian</th>
                                    <th>Soal</th>
                                    <th>Status Ujian</th>
                                    <th>Pilih Kelas Ujian</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;

                                $sql_essay = mysqli_query($con, "SELECT * FROM ujian_essay
                INNER JOIN tb_jenisujian ON ujian_essay.id_jenis=tb_jenisujian.id_jenis
                INNER JOIN tb_master_mapel ON ujian_essay.id_mapel=tb_master_mapel.id_mapel
                WHERE ujian_essay.id_guru='$sesi' ORDER BY ujian_essay.id_ujianessay DESC");
                                ?>

                                <!-- essay -->
                                <?php foreach ($sql_essay as $row) { ?>
                                    <?php print_r($row); ?>
                                    <tr>

                                        <td><?= $no++; ?>.</td>
                                        <td><?= $row['mapel']; ?> </td>
                                        <td>
                                            <a href="?page=essay&act=soalEssay&id=<?= $row['id_ujianessay']; ?>"><b class="text-primary"> <em>Essay</em></b></a>
                                        </td>

                                        <td><b><?= date('d-F-Y', strtotime($row['tanggal'])); ?></b></td>
                                        <td>
                                            <?php $jmlSoal = mysqli_num_rows(mysqli_query($con, "SELECT * FROM ujian_essay WHERE id_guru='$sesi' ")) ?>
                                            <a href="?page=essay&act=addessay&id=<?= $row['id_ujianessay']; ?>" class="btn btn-primary btn-sm text-white">Buat Soal ( <b><?= $jmlSoal; ?></b> )</a>
                                        </td>
                                        <td>

                                            <!-- cek ujian ini di kelas ujian -->
                                            <?php
                                            $klsu = mysqli_query($con, "SELECT * FROM kelas_ujianessay WHERE id_ujianessay='$row[id_ujianessay]' AND aktif='Y' ");
                                            $jml = mysqli_num_rows($klsu);
                                            // foreach ($klsu as $u)
                                            if ($jml > 0) {
                                            ?>
                                                <!-- <a class="badge badge-pill badge-primary"> Aktif</a> -->
                                                <a data-toggle="modal" data-target="#tutup<?= $row['id_ujianessay']; ?>" class="btn btn-success btn-sm text-white"><i class="fa fa-check-square-o"></i> Aktif </a>
                                                <a href="?page=essay&act=status&id=<?= $row['id_ujianessay'] ?>" class="btn btn-warning btn-sm text-black"><i class="fa fa-eye text-black"></i></a>
                                                <!-- MODAL TUTUP UJIAN -->
                                                <div class="modal fade" id="tutup<?= $row['id_ujianessay']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">
                                                                    <center>
                                                                        Apakah Anda Ingin <b>Non Aktifkan</b> Ujian Ini <br> Sekarang ?
                                                                    </center>
                                                                </h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <center>
                                                                    <a href="?page=essay&act=closeessay&essayid=<?php echo $row['id_ujianessay']; ?>" class="btn btn-dark"><i class="fa fa-check-square-o"></i> Ya</a>

                                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-window-close-o"></i> Tidak</button>
                                                                </center>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>

                                            <?php
                                            } else {
                                            ?>
                                                <!-- <a class="badge badge-pill badge-warning">Tidak Aktif</a> -->
                                                <a data-toggle="modal" data-target="#Aktif<?= $row['id_ujianessay']; ?>" class="btn btn-danger btn-sm text-white"><i class="fa fa-window-close-o"></i> Tutup </a>
                                                <!-- Modal Aktifkan ujian -->
                                                <div class="modal fade" id="Aktif<?= $row['id_ujianessay']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">
                                                                    <center>
                                                                        Apakah Anda Ingin <b>Mengaktifkan</b> Ujian Ini Sekarang ?
                                                                    </center>
                                                                </h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <center>
                                                                    <a href="?page=essay&act=aktifessay&essayid=<?php echo $row['id_ujianessay']; ?>" class="btn btn-dark"><i class="fa fa-check-square-o"></i> Ya</a>

                                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-window-close-o"></i> Tidak</button>
                                                                </center>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            <?php
                                            }

                                            ?>

                                        </td>


                                        <td>
                                            <a data-toggle="modal" data-target="#kelasUjian<?= $row['id_ujianessay']; ?>" class="btn btn-dark btn-sm text-warning"><i class="fa fa-graduation-cap"></i> Pilih Kelas </a>
                                            <!-- Modal -->
                                            <div class="modal fade" id="kelasUjian<?= $row['id_ujianessay']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content" style="overflow:scroll;height:600px;">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title" id="myModalLabel">PENGATURAN KELAS UJIAN</h4>
                                                        </div>
                                                        <form method=POST enctype='multipart/form-data' action='?page=proses'>
                                                            <div class="modal-body">
                                                                <input type="hidden" name="id" value="<?= $row['id_ujianessay']; ?>">
                                                                <p>
                                                                <h4><b>KELAS TERSEDIA</b></h4>
                                                                </p>
                                                                <table class='table'>
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Nama Kelas</th>
                                                                            <th>Aksi</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                        // kelas yg dimiliki oleh guru
                                                                        $kelasguru = mysqli_query($con, "SELECT * FROM tb_roleguru
                                  INNER JOIN tb_master_kelas ON tb_roleguru.id_kelas=tb_master_kelas.id_kelas
                                  
                                  WHERE tb_roleguru.id_guru='$sesi' GROUP BY tb_roleguru.id_kelas");
                                                                        foreach ($kelasguru as $kg) {
                                                                        ?>
                                                                            <tr>
                                                                                <td>
                                                                                    <?= $kg['kelas'] ?>


                                                                                    <label class="form-check-label">
                                                                                        <input type="checkbox" value="<?= $kg['id_kelas']; ?>" name="kelas[]">
                                                                                        KELAS <?= $kg['kelas']; ?>
                                                                                    </label>

                                                                                </td>
                                                                                <td>
                                                                                    <a href="?page=essay&act=addkelasujianessay&essayid=<?= $row['id_ujianessay']; ?>&kelas=<?= $kg['id_kelas']; ?>" class="btn btn-info btn-xs">Pilih</a>
                                                                                </td>
                                                                            </tr>
                                                                        <?php } ?>
                                                                    </tbody>
                                                                    <tr>
                                                                        <td colspan="2">
                                                                            <button name="kelasujianEssaySave" type="submit" class="btn btn-primary btn-xs">Save</button>
                                                                        </td>
                                                                    </tr>
                                                                </table>

                                                                <p>
                                                                <h4><b>KELAS TERPILIH</b></h4>
                                                                </p>
                                                                <table class="table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Nama Kelas</th>
                                                                            <th></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                        // tampilkan kelas yg telah terpilih
                                                                        $klsujian = mysqli_query($con, "SELECT * FROM kelas_ujianessay
                                    INNER JOIN tb_master_kelas ON kelas_ujianessay.id_kelas=tb_master_kelas.id_kelas
                                    WHERE id_ujianessay='$row[id_ujianessay]' ");

                                                                        foreach ($klsujian as $ku) {
                                                                        ?>

                                                                            <tr>
                                                                                <td> <?= $ku['kelas']; ?> </td>
                                                                                <td>
                                                                                    <a href="?page=essay&act=delkelasujianessay&id=<?= $ku['id_kelas']; ?>" class="btn btn-danger btn-xs">Hapus</a>

                                                                                </td>
                                                                            </tr>
                                                                        <?php } ?>
                                                                    </tbody>

                                                                </table>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>


                                        <td>
                                            <a href="?page=essay&act=editessay&id=<?= $row['id_ujianessay']; ?>" class="btn btn-dark btn-sm"><i class="fa fa-pencil"></i> Edit </a>
                                            <a href="?page=essay&act=delessay&id=<?= $row['id_ujianessay']; ?>" onclick="return confirm('Yakin Hapus Data ?')" class="btn btn-dark btn-sm text-danger"><i class="fa fa-trash"></i> Hapus </a>
                                        </td>

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



<!-- Modal -->
<div class="modal fade" id="addUjian" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    <center>
                        Silahkan Pilih Jenis Soal Berikut ini !
                    </center>
                </h4>
            </div>
            <div class="modal-body">
                <center>
                    <a href="?page=essay&act=addessay" class="btn btn-primary btn-lg"><i class="fa fa-pencil"></i> ESSAY</a>
                </center>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button> -->
            </div>
        </div>
    </div>
</div>