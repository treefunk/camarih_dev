<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>
	<link rel="stylesheet" href="<?=base_url()?>assets/css/app.css">
</head>
<body>

	<div id="app">
		<app :data=<?=json_encode(['name' => 'jhondz'])?>></app>
	</div>

	<script src="<?=base_url()?>assets/js/app.js"></script>
	
</body>
</html>