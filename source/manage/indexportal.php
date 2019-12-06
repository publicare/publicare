<?php

	echo "<div id=\"divGuiaA\" style=\"height: 0%; visibility: show;\">";
	include ("manage/gerportal.php");
	echo "</div>";
	
	echo "<div id=\"divGuiaB\" style=\"height: 0%; visibility: show;\">";
	include ("manage/gerusuario.php");
	echo "</div>";
	
	echo "<div id=\"divGuiaC\" style=\"height: 0%; visibility: hidden;\">";
	include ("manage/classes.php");
	echo "</div>";
	
	echo "<div id=\"divGuiaD\" style=\"height: 0%; visibility: hidden;\">";
	include ("manage/peles.php");
	echo "</div>";
	
	

?>