<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<base href="<?php echo base_url();?>" />
	<title><?php echo $this->config->item('company') . ' | OSPOS ' . $this->config->item('application_version')  . ' | ' .  $this->lang->line('login_login'); ?></title>
	<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
	<link rel="stylesheet" type="text/css" href="<?php echo 'dist/bootswatch/' . (empty($this->config->item('theme')) ? 'flatly' : $this->config->item('theme')) . '/bootstrap.min.css' ?>"/>
	<!-- start css template tags -->
	<link rel="stylesheet" type="text/css" href="css/login.css"/>
	<!-- end css template tags -->
</head>

<<<<<<< Updated upstream
<body>
	<div id="logo" align="center"><img src="<?php echo base_url();?>/images/logo.png"></div>

	<div id="login">
		<?php echo form_open('login') ?>
			<div id="container">
				<div align="center" style="color:red"><?php echo validation_errors(); ?></div>

				<?php if (!$this->migration->is_latest()): ?>
				<div align="center" style="color:red"><?php echo $this->lang->line('common_migration_needed', $this->config->item('application_version')); ?></div>
=======
<body class="bg-light d-flex flex-column">
  <main class="d-flex justify-content-around align-items-center flex-grow-1">
    <div class="container-login container-fluid d-flex flex-column flex-md-row bg-body shadow rounded m-3 p-4 p-md-0">
      <div class="box-logo d-flex flex-column justify-content-center align-items-center border-end px-4 pb-3 p-md-4">
      <?php if ($this->Appconfig->get('company_logo')): ?>
        <img class="logo w-100" src="<?php echo base_url('uploads/' . $this->Appconfig->get('company_logo')); ?>" alt="<?php echo $this->lang->line('common_logo') . '&nbsp;' . $this->config->item('company'); ?>">
      <?php else: ?>
        <svg class="logo text-primary" role="img" viewBox="0 0 308.57998 308.57997" xmlns="http://www.w3.org/2000/svg">
          <title><?php echo $this->lang->line('common_software_title') . '&nbsp;' . $this->lang->line('common_logo'); ?></title>
          <circle cx="154.28999" cy="154.28999" r="154.28999" fill="currentColor"/>
          <path fill="#fff" d="M154.88998 145.66999c-.03-1.26-.03-3.29.19-4.29 4.6-11.1 15.57-18.82 28.3-18.82h.41v58.3c0 .12-.03.78-.04.9-.54 16.46-14.01 29.7-30.59 29.7v27.08c21 0 39.17-11.27 49.29-28.07l.07-.11c2.9.45 5.86.75 8.9.75 31.95 0 57.81-26 57.81-57.81 0-30.87-24.37-56.46-55.1-57.81h-30.74c-17.18 0-32.61 7.64-43.22 19.63-10.59-11.92-25.86-19.59-43.02-19.59-31.86 0-57.77 25.91-57.77 57.77 0 31.86 25.91 57.77 57.77 57.77 31.86 0 57.77-25.91 57.77-57.77v-3.68c-.01.01-.02-3.31-.03-3.95zm-57.75 38.33c-16.92 0-30.69-13.77-30.69-30.69s13.77-30.69 30.69-30.69 30.69 13.77 30.69 30.69-13.77 30.69-30.69 30.69zm142.96-19.87c-4.33 11.64-15.57 19.9-28.7 19.9h-.54v-61.47h.54c13.13 0 24.37 8.26 28.7 19.9 1.35 3.25 2.03 6.91 2.03 10.83s-.67 7.59-2.03 10.84z"/>
        </svg>
      <?php endif; ?>
      </div>
      <section class="box-login d-flex flex-column justify-content-center align-items-center p-md-4">
				<?php echo form_open('login'); ?>
        <h3 class="text-center m-0"><?php echo $this->lang->line('login_welcome', $this->lang->line('common_software_short')); ?></h3>
        <?php if (validation_errors()): ?>
        <div class="alert alert-warning mt-3">
          <?php echo validation_errors(); ?>
        </div>
        <?php endif; ?>
				<?php if (!$this->migration->is_latest()): ?>
        <div class="alert alert-danger mt-3">
					<?php echo $this->lang->line('login_migration_needed', $this->config->item('application_version')); ?>
				</div>
>>>>>>> Stashed changes
				<?php endif; ?>

				<div id="login_form">
					<div class="input-group">
						<span class="input-group-addon input-sm"><span class="glyphicon glyphicon-user"></span></span>
						<input class="form-control" placeholder="<?php echo $this->lang->line('login_username')?>" name="username" type="text" size=20 autofocus></input>
					</div>

					<div class="input-group">
						<span class="input-group-addon input-sm"><span class="glyphicon glyphicon-lock"></span></span>
						<input class="form-control" placeholder="<?php echo $this->lang->line('login_password')?>" name="password" type="password" size=20></input>
					</div>

					<?php
					if($this->config->item('gcaptcha_enable'))
					{
						echo '<script src="https://www.google.com/recaptcha/api.js"></script>';
						echo '<div class="g-recaptcha" align="center" data-sitekey="' . $this->config->item('gcaptcha_site_key') . '"></div>';
					}
					?>

					<input class="btn btn-primary btn-block" type="submit" name="loginButton" value="<?php echo $this->lang->line('login_go')?>"/>
				</div>
			</div>
		<?php echo form_close(); ?>

		<h1>Open Source Point Of Sale <?php echo $this->config->item('application_version'); ?></h1>

	</div>
</body>
</html>
