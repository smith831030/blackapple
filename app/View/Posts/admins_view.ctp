<?php echo $this->Html->css(array('admin.css'), array('inline' => false));?>
			<!--<POST>-->
			<div class="admin">				
				<!--<POST BODY>-->
				<div class="post_body">
					<h2>[<?php echo h($post['BaPostCategory']['category_title']); ?>] <?php echo h($post['BaPost']['title']); ?></h2>
					<span class="created">Created: <?php echo $post['BaPost']['created']; ?></span>
					<span class="created">Tags: <?php echo $post['BaPost']['tags']; ?></span>
					<div class="body"><?php echo nl2br($post['BaPost']['body']); ?></div>
				</div>
				<!--<POST BODY>-->
				
				<!--<COMMENT>-->
				<div class="post_comment">
					<span class="total">Comment : <?php echo $post['BaPost']['comment_total']; ?></span>
					<ul class="list">
					<?php foreach ($comments as $comment): ?>
						<li>
							<span class="img"><img src="https://graph.facebook.com/<?php echo $comment['BaPostComment']['user_id'];?>/picture" /></span>
							<div class="info">
								<span class="name"><a href="http://facebook.com/<?php echo $comment['BaPostComment']['user_id'];?>" class="bold" target="_blank"><?php echo $comment['BaPostComment']['user_name'];?></a></span>
								<span class="comment"><?php echo $comment['BaPostComment']['comment'];?></span>
								<span class="created"><?php echo $comment['BaPostComment']['created'];?></span>
							</div>
						</li>
					<?php endforeach; ?>
					<?php unset($comment); ?>
					</ul>
				</div>
				<div class="clearBoth"></div>
				<!--</COMMENT>-->
				
				<div class="control">
					<?php echo $this->Html->link('List', '/Admins/Posts/list/', array('class'=>'button')); ?>
					<?php
						echo $this->Html->link(
							'Edit',
							array('action' => 'Admins_edit', $post['BaPost']['id']),
							array('class'=>'button')
						);
					?>
					<?php
						echo $this->Form->postLink(
							'Delete',
							array('action' => 'Admins_delete', $post['BaPost']['id']),
							array('confirm' => 'Are you sure?', 'class'=>'button')
						);
					?>
				</div>
				

				<?php //echo $this->element('sql_dump'); ?>
				<!--</POST>-->
			</div>