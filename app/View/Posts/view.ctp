<?php //echo $this->Html->css('post.css', array('inline' => false));?>
<?php echo $this->Html->script('post.js', array('inline' => false, 'async' => true));?>
<?php echo $this->Html->meta('keywords', $view['BaPost']['tags'], array('inline' => false));?>
<?php echo $this->Html->meta('description', mb_strimwidth(h(strip_tags($view['BaPost']['body'])), 0, 400, "...","utf-8"), array('inline' => false));?>

<script type="text/javascript">
	window.fbAsyncInit = function() {
		FB.init({
			appId      : '238850962958240',
			//appId      : '305244666318869',	//test version
			cookie     : true,
			xfbml      : true,
			version    : 'v2.0'
		});
	};

	//SDK
	(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/en_US/sdk.js";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));
</script>
			<!--<POST>-->
			<div class="container">
				<!--<POST BODY>-->
				<div class="post_body" itemscope itemtype="http://schema.org/Article">
					<h2 itemprop="name">[<?php echo $view['BaPostCategory']['category_title'];?>] <?php echo $view['BaPost']['title'];?></h2>
					<span itemprop="datePublished" content="<?php echo $view['BaPost']['created'];?>" class="hidden"><?php echo $view['BaPost']['created'];?></span>
					<div class="text-left">
						<?php echo $this->Html->link('http://blackapple.kr/Posts/view/'.$view['BaPost']['id'],'http://blackapple.kr/Posts/view/'.$view['BaPost']['id'], array('itemprop'=>'url', 'class'=>'btn btn-success btn-xs'));?>

						<div class="fb-share-button" data-href="<?php echo $og_url;?>" data-layout="button" data-size="large" data-mobile-iframe="true">
							<a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($og_url);?>&amp;src=sdkpreparse">Share</a>
						</div>
					</div>
					<img itemprop="image" src="/upload/<?php echo $view['BaPost']['img'];?>" class="hidden" title="<?php echo $view['BaPost']['title'];?>" />

					<div class="post-body" itemprop="articleBody"><?php echo $view['BaPost']['body'];?></div>
				</div>
				<!--</POST BODY>-->

				<div>
					<?php echo $this->Html->link('Back to list', array('action'=>'index', $view['BaPost']['category_id']), array('class'=>'btn btn-primary'));?>
				</div>

				<div class="clearfix"></div>
			</div>
			<!--</POST>-->

			<?php //echo $this->element('sql_dump'); ?>
