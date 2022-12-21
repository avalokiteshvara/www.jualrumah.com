<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');
?>

<br/>
<br/>

<!-- <div class="container"> -->
	<div class="row">
		<div class="span4 offset4 well">
<!-- 			<legend>Please Sign In</legend> -->
		      
		      
			<div class="alert alert-error">
				<a class="close" data-dismiss="alert" href="#">x</a><?php echo validation_errors();?>
			</div>
			
			<!-- email,nama_lengkap,no_telp,pass, pass_confirm -->
			
			<form method="POST" action="" accept-charset="UTF-8">
			
				<input type="text" class="span4" name="email" placeholder="Email">								
				<input type="text" class="span4" name="nama_depan" placeholder="Nama Depan"> 				
				<input type="text" class="span4" name="nama_belakang" placeholder="Nama Belakang"> 					
				<input type="text" class="span4" name="no_telp"	placeholder="No.Telp">					
			    <input type="password" class="span4" name="pass" placeholder="Password"> 				
				<input type="password" class="span4" name="pass_confirm" placeholder="Ulangi">	
				
				<input class="btn btn-primary pull-right" type="submit" name="commit" value="Daftar" />
			</form>
			
		</div>
	</div>
<!-- </div> -->