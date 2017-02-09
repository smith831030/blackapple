<?php echo $this->Html->script('post.js?ver=2015060421', array('inline' => false, 'async' => true));?>

				<!--<POST LIST>-->
				<div class="container post-main">
					<h2><?php echo $posts[0]['BaPostCategory']['category_title'];?></h2>
					<div>
						<!--<POST LIST>-->
						<div class="grid">
								<?php foreach ($posts as $post): ?>
								<?php if($posts[0]['BaPost']['id']==$post['BaPost']['id']) $class='now'; else $class=''; ?>
								<div class="col-md-2 col-xs-4 grid-item animated pulse">
									<a href="<?php echo '/Posts/view/'.$post['BaPost']['id'];?>" class="thumbnail">
										<?php echo $this->Html->image('/upload/'.$post['BaPost']['img'], array('alt'=>$post['BaPost']['title'], 'title'=>$post['BaPost']['title'])); ?>
									</a>
								</div>
								<?php endforeach; ?>
								<?php unset($post); ?>
						</div>
						<div class="clearfix"></div>
						<!--</POST LIST>-->

						<!-- <paging> -->
						<div class="paging">
							<?php echo $this->Paginator->first(1, array('title'=>'First', 'ellipsis'=>'...'));?>
							<?php echo $this->Paginator->numbers(array('separator'=>false, 'currentClass'=>'active'));?>
							<?php echo $this->Paginator->last(1, array('title'=>'Last', 'ellipsis'=>'...'));?>
						</div>
						<!-- </paging> -->
					</div>
					<div class="clearfix"></div>
					<!--</POST LIST>-->
				</div>
				<!--</POST LIST>-->

				<script>
				$(window).on('load', function(){
					$('.grid').masonry({
						itemSelector: '.grid-item'
					});
				});
				</script>


			<?php //echo $this->element('sql_dump'); ?>
