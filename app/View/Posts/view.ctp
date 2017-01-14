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

		FB.getLoginStatus(function(response) {
			statusChangeCallback(response,  <?php echo $view['BaPost']['id'];?>, 0);
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

	jQuery(document).ready(function(){
		/* get comment list */
		var comments=$.get("/Posts/comment/<?php echo $view['BaPost']['id'];?>/0");
		comments.done(function(data){
			jQuery(".post_comment").append(data);
			checkLoginState(<?php echo $view['BaPost']['id'];?>, 0);
		});
	});
</script>
			<!--<POST>-->
			<div class="container">
				<?php /*
				<!--<POST CATEGORY-->
				<select onchange="location.href='/Posts/index/'+jQuery(this).val();">
					<option value="all">All</option>
					<?php foreach ($categories as $category): ?>
					<option value="<?php echo $category['BaPostCategory']['id'];?>" <?php if($category_id==$category['BaPostCategory']['id']) echo "selected='selected'"; ?>><?php echo $category['BaPostCategory']['category_title'];?></option>
					<?php endforeach; ?>
					<?php unset($category); ?>

				</select>
				<!--</POST CATEGORY-->
				*/ ?>

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

				<!--<COMMENT>-->
				<span class="total">Comment : <span id="comment_total_num"><?php echo $view['BaPost']['comment_total']; ?></span></span>
				<div class="post_comment"></div>
				<div class="clearfix"></div>
				<!--</COMMENT>-->

				<?php /*
				<!--<POST LIST>-->
				<div id="post_lists">
					<!--<POST LIST>-->
					<div class="post_lists">
						<h2>Post List</h2>
						<ul>
							<?php foreach ($posts as $post): ?>
							<?php if($post_id==$post['BaPost']['id']) $class='now'; else $class=''; ?>
							<li>
								<span class="title <?php echo $class;?>"><?php echo $this->Html->link('['.$post['BaPostCategory']['category_title'].'] '.$post['BaPost']['title'], '/Posts/view/'.$post['BaPost']['id']);?> (<?php echo $post['BaPost']['comment_total']; ?>)</span>
								<span class="created"><?php echo $post['BaPost']['created'];?></span>
							</li>
							<?php endforeach; ?>
							<?php unset($post); ?>
						</ul>
					</div>
					<div class="clearBoth"></div>
					<!--</POST LIST>-->

					<!-- <paging> -->
					<div class="paging">
						<?php
						//페이징
						$pagePagesize=10; 					//한번에 보여줄 페이지의 수
						$totalpage=ceil($total/5);  //실질적인 총 페이지
						if($totalpage<$pagePagesize){		//총페이지수가 한번에 보여지는 페이지수 보다 작을경우 startpage=1
							$startpage=1;
						}else{
							$startpage=((int)((1-1)/$pagePagesize))*$pagePagesize+1;
						}
						$lastpage=$startpage+$pagePagesize-1;   		//한번에 보여지는 페이지중 마지막 페이지
						if($totalpage<$lastpage){			//lastPage 가 총페이지수를 넘어갈경우 lastPage 는 totalPage가 된다.
							$lastpage=$totalpage;
						}
						if($startpage>1)  					//처음페이지가 1보다 크면 prev10 버튼 출력
							echo(" <a href='/Posts/lists/".($startpage-$pagePagesize)."/$post_id' onclick='getList(".($startpage-$pagePagesize).",$post_id);return false;'>[ &lt;&lt;prev10 ]</a> ");
						for($j=$startpage ; $j<=$lastpage ; $j++){
							if($j==1){ 					//현재페이지에 <b>테그 적용하는 if문
								echo("<b>$j</b> &nbsp;");
							}else{
								echo("<a href='/Posts/lists/$j/$post_id' onclick='getList($j,$post_id);return false;'>$j</a> &nbsp;");
							}
						}
						if($lastpage<$totalpage)
							echo(" <a href='/Posts/lists/".($lastpage+1)."/$post_id' onclick='getList(".($lastpage+1).",$post_id);return false;'>[ next10>> ]</a> ");
						?>
					</div>
					<!-- </paging> -->
				</div>
				<!--</POST LIST>-->
				*/ ?>
			</div>
			<!--</POST>-->

			<?php //echo $this->element('sql_dump'); ?>
