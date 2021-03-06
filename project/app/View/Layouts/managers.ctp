<?php
/**
 *
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
$cakeDescription = __d('cake_dev', 'GAMI ORDER SYSTEM');
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('common.css');
		echo $this->Html->css('bootstrap.min.css');
		echo $this->Html->css('bootsrtap.customize.css');
		echo $this->Html->css('signin.css');
		echo $this->Html->css('print.css', array('media'=>'print'));
		
		echo $this->Html->script('jquery-1.10.2.min.js');
		echo $this->Html->script('ie-emulation-modes-warning.js');
		echo $this->Html->script('common.js');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
	<!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
	<!--[if lt IE 9]><script src="/js/ie8-responsive-file-warning.js"></script><![endif]-->

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>
<body>
	<header>
		<nav class="navbar navbar-inverse navbar-fixed-top">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<?php echo $this->Html->image('common/logo.png', array('alt'=>$cakeDescription, 'url'=>$mainPageUrl.'/', 'class'=>'navbar-brand')); ?>
				</div>
				<div id="navbar" class="collapse navbar-collapse">
					<ul class="nav navbar-nav">
						<li <?php if($current_page=='main') echo 'class="active"';?>><a href="<?php echo $mainPageUrl;?>/">Home</a></li>
						<li <?php if($current_page=='order') echo 'class="active"';?>>
							<a href="<?php echo $mainPageUrl;?>/Managers/Order">Order
								<?php if($newOrder>0){?><span class="label label-danger"><?php echo $newOrder;?></span><?php }?>
							</a>
							
						</li>
						<li <?php if($current_page=='history') echo 'class="active"';?>><a href="<?php echo $mainPageUrl;?>/Managers/History">History</a></li>
						<li class="dropdown  <?php if($current_page=='maintenance') echo 'active';?>">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Maintenance<span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="<?php echo $mainPageUrl;?>/Managers/MaintenanceStorage">Storage</a></li>
								<li><a href="<?php echo $mainPageUrl;?>/Managers/MaintenanceStock">Add stocks</a></li>
								<li><a href="<?php echo $mainPageUrl;?>/Managers/MaintenanceRelease">Release stocks</a></li>
							</ul>
						</li>
						<li <?php if($current_page=='statistics') echo 'class="active"';?>><a href="<?php echo $mainPageUrl;?>/Managers/Statistics">Statistics</a></li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li><a href="<?php echo $mainPageUrl;?>/MainPage/logout">Logout</a></li>
					</ul>
				</div>
			</div>
		</nav>
	</header>
	
	<div class="container">
		<?php echo $this->fetch('content'); ?>
	</div>
	
	<!--<FOOTER>-->
	<footer class="footer">
		<div class="container">
			<h2 class="dpNone">FOOTER</h2>
			<p class="text-muted">Copyright ⓒ <?php echo $this->Html->link('GAMI','http://gamichicken.com.au')?> all rights reserved</p>
		</div>
	</footer>
	<!--</FOOTER>-->
	
	<?php echo $this->Html->script('bootstrap.min.js'); ?>
	<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	<?php echo $this->Html->script('ie10-viewport-bug-workaround.js'); ?>
</body>
</html>
