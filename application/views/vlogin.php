<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Aplikasi Tata Naskah Kepegawaian | Login page</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/dist/css/AdminLTE.css"> 
    <link rel="shortcut icon" href="<?php echo base_url()?>assets/dist/img/favicon_garuda.ico">	
  </head>
  <body class="login-page">
    <div class="login-box">
      <div class="login-logo">
        <img src="<?php echo base_url()?>assets/dist/img/logo-garuda.png" class="image-login" />
		<p class="text-blue hidden-xs"  style="font-size:20px">Aplikasi Tata Naskah Kepegawaian<br/>
		BKN Kantor Regional XI Manado</p>
      </div>
      <div class="box box-info">
		
		<form class="form-horizontal" method="post" action="<?php echo site_url()?>/autho/login/">
		  <div class="box-body">
		    <?php echo $message;?>
			<div class="form-group">
			 <div class="col-sm-12">			  
				<div class="input-group"> 			
					<span class="input-group-addon">
					  <i class="fa fa-user"></i>
					</span> <input type="text" required name="username" placeholder="Username" class="form-control">					
				</div>				
			 </div>
			</div>
			<div class="form-group">			 
			  <div class="col-sm-12">
				<div class="input-group"> 				
					<span class="input-group-addon">
						<i class="fa fa-key"></i>
					</span><input type="password" required name="password" placeholder="Password" class="form-control">
				</div>
			  </div>
			</div>
			
		  </div><!-- /.box-body -->
		  <div class="box-footer">
			 <a href="<?php echo site_url()?>/signup/" class="text-center">Register new membership >></a>
			<button type="submit" class="btn btn-info pull-right">Sign in</button>
		  </div><!-- /.box-footer -->
		</form>
	  </div><!-- /.box -->
    </div>	
    <script src="<?php echo base_url()?>assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script src="<?php echo base_url()?>assets/bootstrap/js/bootstrap.min.js"></script>   
  </body>
</html>
