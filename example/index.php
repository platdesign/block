<?php

	require '../block.php';

	block::config([
		'basedir'=>dirname(__FILE__),
		'comments'=>true
	]);

	echo block::render('./views/test.php');

 ?>
