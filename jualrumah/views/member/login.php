<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');
?>

    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
	<div class="row">
		<div class="span4 offset4 well">
		  <?php if(validation_errors() != ''): ?>
			<div class="alert alert-error">
				<a class="close" data-dismiss="alert" href="#">x</a><?php echo validation_errors() .'<br>'.$msg;?>
			</div>
		  <?php else: ?>
		  	<div class="alert alert-error">
				<a class="close" data-dismiss="alert" href="#">x</a>Silahkan Login: <?php echo '<br>'.$msg; ?>
			</div>
		  <?php endif;?>

			<form method="POST" action="" accept-charset="UTF-8">
				<input type="text" id="username" class="span4" name="email"
					placeholder="Email"> <input type="password" id="password"
					class="span4" name="password" placeholder="Password">
				<!-- <label class="checkbox"> <input type="checkbox" name="remember" value="1">
					Remember Me
				</label> -->
				<input class="btn btn-primary pull-right" type="submit" name="commit" value="Sign In" />
			</form>

		</div>
	</div>
	<br/>
	<br/>
	<br/>
	<br/>
	<br/>
