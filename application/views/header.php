<?php $this->load->helper('url'); ?>
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv='Content-type' content='text/html; charset=utf-8'>
  <title><?= $title; ?></title>
  <link rel='stylesheet' href='<?= base_url(); ?>public/css/master.css' type='text/css' media='screen' title='no title' charset='utf-8'>
</head>
  <body>
  	<header>
  		<nav>
  			<ul>
			<? if ($this->input->cookie('user')): ?>
				<li><a href='<?= base_url(); ?>user/logout'>Logout</a></li>
			<? else: ?>
				<li><a href='<?= base_url(); ?>user/login'>Login</a></li>
			<? endif; ?>
				<li><a href='<?= base_url(); ?>user/profile'>Profile</a></li>
  			</ul>
  		</nav>
  	</header>