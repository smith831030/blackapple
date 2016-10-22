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
	<?php echo $this->Paginator->numbers(array('first' => 2, 'last' => 2));?>
</div>
<!-- </paging> -->

<?php //echo $this->element('sql_dump'); ?>