<?php 
include '../config/db.php';
$sql = mysqli_query($con, "select * from tb_roleguru where id_roleguru='$_GET[id_roleguru]'");
$role= mysqli_fetch_array($sql);
$data = array(
				'id_guru'   	=>  $role['id_guru'],
				'id_kelas'  	=>  $role['id_kelas'],
				'id_mapel'  	=>  $role['id_mapel']

              	);
 echo json_encode($data);
