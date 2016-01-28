<?php

	$tw = date('Y-m-d',strtotime("+ 14 days"));
	$td = date('Y-m-d',strtotime("+ 30 days"));
	$nd = date('Y-m-d',strtotime("+ 90 days"));
			
	echo $tw. ' ' . $td	. ' ' . $nd;	
?>