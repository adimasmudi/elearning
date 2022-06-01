<?php

$sql = mysqli_query($con, "INSERT INTO kelas_ujianessay VALUES('null','$_GET[essayid]','$_GET[kelas]','Y') ");
if ($sql) {
    echo "
    <script>
    window.location='?page=essay';
    </script>
    
    ";
}
