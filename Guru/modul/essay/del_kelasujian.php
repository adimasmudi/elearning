<?php

$sql = mysqli_query($con, "DELETE FROM kelas_ujianessay WHERE id_kelas='$_GET[id]' ");
if ($sql) {
        echo "
        <script>
        window.location='?page=essay';
        </script>
        
        ";
}
