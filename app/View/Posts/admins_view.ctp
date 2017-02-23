<?php echo $this->Html->css(array('admin.css'), array('inline' => false));?>
			<!--<POST>-->
			<div class="admin">
				<!--<POST BODY>-->
				<div class="post_body">
					<h2>[<?php echo h($post['BaPostCategory']['category_title']); ?>] <?php echo h($post['BaPost']['title']); ?></h2>
					<span class="created">Created: <?php echo $post['BaPost']['created']; ?></span>
					<span class="created">Tags: <?php echo $post['BaPost']['tags']; ?></span>
					<div class="body"><?php echo nl2br($post['BaPost']['body']); ?></div>

					<div>
						<strong>Players</strong>
						<?php foreach($players as $player):?>
							<span class="label label-default"><?=$player['BaPlayer']['p_name'];?></span>
						<?php endforeach;?>
					</div>
				</div>
				<!--<POST BODY>-->

				<div class="clearBoth"></div>
				<br>

				<div>
					<?php echo $this->Html->link('List', '/Admins/Posts/list/', array('class'=>'btn btn-default')); ?>
					<?php
						echo $this->Html->link(
							'Edit',
							array('action' => 'Admins_edit', $post['BaPost']['id']),
							array('class'=>'btn btn-default')
						);
					?>
					<?php
						echo $this->Form->postLink(
							'Delete',
							array('action' => 'Admins_delete', $post['BaPost']['id']),
							array('confirm' => 'Are you sure?', 'class'=>'btn btn-danger')
						);
					?>
				</div>


				<?php //echo $this->element('sql_dump'); ?>
				<!--</POST>-->
			</div>
