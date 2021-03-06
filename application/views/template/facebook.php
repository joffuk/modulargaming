<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<?php
	foreach ($css as $style):
		echo html::style($style);
	endforeach;
	?>
	<script type="text/javascript">
		path = "<?php echo url::base(); ?>";
	</script>
	
	<title>Modular Gaming - <?php echo $title; ?></title>
</head>
<body>

<div class="header">
	<?php echo html::anchor('', 'ModularGaming', array('class' => 'logo')); ?>
	
	<ul class="nav">
		<?php
			
			if ( $user ) {
				
				echo '<li class="first">' . html::anchor( 'dashboard', 'Dashboard' )    . '</li>';
				echo '<li>' . html::anchor( 'inventory', 'Inventory' ) . '</li>';
				echo '<li>' . html::anchor( 'account', 'Settings' ) . '</li>';
				echo '<li class="last">' . html::anchor( 'account/logout', 'Logout' ) . '</li>';
				
			} else {
				
				echo '<li class="first">' . html::anchor( '', 'Home' )    . '</li>';
				echo '<li class="last">' . html::anchor( 'facebook/register', 'Register' ) . '</li>';
				
			}
		?>
	</ul>
</div>

<div class="content">
	<fb:bookmark type="off-facebook"></fb:bookmark>
	<?php echo $content; ?>
</div>

<div class="footer">
	<div class="wrapper">
		<p class="copyright">© 2010 the Modular Gaming Team.</p>
	</div>
</div>
<?php
	if( Kohana::$environment == 'development' )
		echo View::factory('profiler/stats');
?>
<?php
	foreach ($js['files'] as $script):
		echo html::script($script);
	endforeach;
	foreach ($js['scripts'] as $script):
		echo '<script type="text/javascript">'.$script.'</script>';
	endforeach;
?>
<div id="FB_HiddenIFrameContainer" style="display:none; position:absolute; left:-100px; top:-100px; width:0px; height: 0px;"></div> 
<script src="http://static.ak.connect.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php" type="text/javascript"> </script>
<script type="text/javascript">
	FB.init("feaa2c76df6a162bd9174b99fff1be1a ", "/modulargaming/xd_receiver.htm");
	FB_RequireFeatures(["CanvasUtil"], function(){
		FB.XdComm.Server.init('/modulargaming');
		FB.CanvasClient.startTimerToSizeToContent();
	});
</script>

</body>
</html>