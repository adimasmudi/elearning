<?php
$sql = mysqli_query($con,"INSERT INTO kelas_tugas VALUES('null','$_GET[tugas]','$_GET[kelas]','Y') ");
if ($sql) {
    echo "
    <script>
    window.location='?page=tugas';
    </script>  
    ";
}
