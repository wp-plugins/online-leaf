<?php

function iif($argument, $true, $false=FALSE) {
	if($argument) { return $true; }
	else { return $false; }
}

?>