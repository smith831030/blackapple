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
$cakeDescription = __d('cake_dev', 'DH\'s BlackApple');
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

		//echo $this->Html->css('style.css');

		//echo $this->Html->script('jquery-1.10.2.min.js');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
	<meta name="p:domain_verify" content="ff3ec8b8ddc42a05ec92d65f3209cce7"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />

	<script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<script src="https://use.fontawesome.com/8e8451dc46.js"></script>

	<?php echo $this->Html->script('masonry.pkgd.min.js');?>

	<link rel="alternate" type="application/rss+xml" href="http://blackapple.kr/Posts/index.rss" title="RSS feed for BlackApple"/>
	<link href='https://fonts.googleapis.com/css?family=Fira+Sans:400,700' rel='stylesheet' type='text/css' />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<?php echo $this->Html->css('common.css?ver=20170209');?>
	<?php echo $this->Html->css('animate.css');?>

	<meta name="google-site-verification" content="TcCwvCGElUL8o6iMSZfgzB2arSLosDYs7L0n1BbGKHI" />
	<?php if(isset($og_img)){?>
		<meta property="og:image" content="<?php echo $og_img;?>" />
		<meta property="og:title" content="<?php echo $og_title;?>"/>
		<meta property="og:url" content="<?php echo $og_url;?>"/>
		<meta property="og:site_name" content="DHs BlackApple"/>
		<meta property="og:type" content="blog"/>
		<meta property="og:description" content="<?php echo $og_description;?>"/>
		<meta property="fb:app_id" content="238850962958240"/>
	<?php }?>
</head>
<body>
	<div>
	<!--<MENU>-->
		<nav class="navbar navbar-default">
		  <div class="container-fluid">
		    <div class="navbar-header">
		      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
		        <span class="sr-only">Toggle navigation</span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		      </button>
		      <?php echo $this->Html->image('common/logo.png', array('alt'=>$cakeDescription, 'url'=>'/', 'class'=>'navbar-brand')); ?>
		    </div>

		    <!-- Collect the nav links, forms, and other content for toggling -->
		    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		      <ul class="nav navbar-nav">
		        <li <?php if($current_page=='aboutus'):?>class="active"<?php endif;?>><a href="/AboutUs" title="Black Apple?">About BA</a></li>
		        <li class="dropdown" <?php if($current_page=='post'):?>class="active"<?php endif;?>>
		          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Artworks <span class="caret"></span></a>
		          <ul class="dropdown-menu">
								<?php foreach($top_categories as $cate):?>
		            	<li><?php echo $this->Html->link($cate['BaPostCategory']['category_title'], array('controller'=>'Posts', 'action'=>'index', $cate['BaPostCategory']['id']));?></a></li>
								<?php endforeach;?>
		          </ul>
		        </li>
		      </ul>
		    </div><!-- /.navbar-collapse -->
		  </div><!-- /.container-fluid -->
		</nav>
		<!--</MENU>-->

		<?php echo $this->fetch('content'); ?>

		<!--<FOOTER>-->
		<footer class="text-center">
			<h2 class="hide">FOOTER</h2>
			<p>
				<a href="https://www.instagram.com/mancity.fanart/" target="_blank"><i class="fa fa-instagram fa-2x" aria-hidden="true"></i></a>
				<a href="https://au.pinterest.com/mancityfanart/" target="_blank" class="footer_pinterest"><i class="fa fa-pinterest-square fa-2x" aria-hidden="true"></i></a>
				<a href="http://dark666jh.blog.me/" target="_blank"><?php echo $this->Html->image('common/naver.png', array('alt'=>'Naver Blog', 'class'=>'footer_naver'));?></a>
			</p>
			<p>
				Copyright ⓒ <?php echo $this->Html->link('JANGHO,SEO','mailto:smith831030@gmail.com')?> all rights reserved
				<?php echo $this->Html->image('common/16px-Feed-icon.svg.png', array('alt'=>'RSS', 'url'=>'/Posts/index.rss')); ?>
			</p>

		</footer>
		<hr />
		<!--</FOOTER>-->
	</div>

	<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

		ga('create', 'UA-7102555-1', 'auto');
		ga('send', 'pageview');
	</script>
</body>
</html>
