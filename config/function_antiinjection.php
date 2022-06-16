<?php
function antiinjeksi($text){
	global $con;
	$safetext = $con->real_escape_string(stripslashes(strip_tags(htmlspecialchars($text,ENT_QUOTES))));
	return $safetext;
}
