<?php echo $this->Html->css('comment.css', array('inline' => false));?>
<?php echo $this->Html->script('comment.js', array('inline' => false));?>
			<!--<GUEST BBS>-->
			<div id="guestbbs">
				<h2>GUEST BBS</h2>
				
				<div id="subCommentControl"></div>
				
				<div id="control">
					<?php
					echo $this->Form->create('WsComment', array('class'=>'writeForm', 'inputDefaults' => array(
							'div' => false
						)));
					echo $this->Form->input('wb_name', array('label'=>'Name', 'id'=>'wb_name'));
					echo $this->Form->input('wb_pass', array('label'=>'Pass', 'id'=>'wb_pass', 'type'=>'password'));
					echo $this->Form->input('wb_content', array('rows' => '3', 'id'=>'wb_content', 'class'=>'comment', 'label'=>false));
					echo $this->Form->end('submit', array('id'=>'submit'));
					?>
				</div>
				
				<div id="subCommentList">
					<div class="list">
						<ul>
							<?php foreach ($posts as $post): ?>
							<li>
								<span class="id"><?php echo $post['WsComment']['wb_name']?></span>
								<span class="date"><?php echo $post['WsComment']['wb_date']?></span>

								<a href="#" onclick="show_delete_form(<?php echo $post['WsComment']['wb_idx']?>, 'ws_comment', 0); return false;" class="red_link" alt="delete">x</a>

								<a href="#" onclick="showLayer(<?php echo $post['WsComment']['wb_idx']?>, 'ws_comment'); return false;" class="comment_content"><?php echo $post['WsComment']['wb_content']?></a>
								<span class="comment_total">comment : <?php echo $post['WsComment']['wb_comment_count']?></span>
								<div id="delete_<?php echo $post['WsComment']['wb_idx']?>" class="dpNone"></div>
								<div id="comment_<?php echo $post['WsComment']['wb_idx']?>" class="dpNone"></div>
							</li>
							<?php endforeach; ?>
							<?php unset($post); ?>
						</ul>
					</div>
					<!-- <paging> -->
					<div id="paging">
						<?php echo $this->Paginator->numbers(array('separator' => ' &nbsp;'));?>
					</div>
					<!-- </paging> -->

					<?php //echo $this->element('sql_dump'); ?>
				</div>
			</div>
			<!--</GUEST BBS>-->