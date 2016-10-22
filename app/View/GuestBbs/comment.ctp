<ul class="list sub">
<?php foreach ($posts as $post): ?>
	<li>
		<span class="id"><?php echo $post['WsCommentComment']['wbc_name']?></span>
		<span class="date"><?php echo $wbc_date?></span>
			<a href="#" onclick="show_delete_form(<?php echo $wb_idx?>, 'ws_comment', <?php echo $post['WsCommentComment']['wbc_idx']?>); return false;" class="red_link">x</a>
		<div class="comment_content"><?php echo $post['WsCommentComment']['wbc_comment']?></div>
		<div id="comment_sub_<?php echo $post['WsCommentComment']['wbc_idx']?>" class="dpNone">1234</div>
	</li>
<?php endforeach; ?>
<?php unset($post); ?>
</ul>

<div class="reWriteForm">
	<form name="wbc_comment_form" id="wbc_comment<?php echo $wb_idx?>_form" class="writeForm" action="./comment/ws_comment_ok.php" method="post">
		<fieldset>
			<legend>Comment to Comment</legend>
			
			<input type="hidden" name="wb_idx" id="wb_idx<?php echo $wb_idx?>" value="<?php echo $wb_idx?>" />
			
			<label for="wbc_name<?php echo $wb_idx?>">Name</label>
			<input type="text" name="wbc_name" id="wbc_name<?php echo $wb_idx?>" />

			<label for="wbc_pass<?php echo $wb_idx?>">Pass</label>
			<input type="password" name="wbc_pass" id="wbc_pass<?php echo $wb_idx?>" />

			<a href="#" onclick="document.getElementById('zsfImg<?php echo $wb_idx?>').src='http://blackapple.kr/captcha/zmSpamFree.php?re&zsfimg=' + new Date().getTime(); return false;"><img src="http://blackapple.kr/captcha/zmSpamFree.php?zsfimg=<?php echo time();?>" id="zsfImg<?php echo $wb_idx?>" class="zsfImg" alt="SpamFree.kr" title="SpamFree.kr" /></a>
			<input type="text" size="8" maxlength="10" name="zsfCode" id="zsfCode<?php echo $wb_idx?>" class="zsfCode" />

			<textarea name="wbc_comment" id="wbc_comment<?php echo $wb_idx?>" class="comment" rows="10" cols="2"></textarea>
			<input type="submit" id="submit" value="Submit" />
		</fieldset>
	</form>
	
	<script type="text/javascript">
		$( "#wbc_comment<?php echo $wb_idx?>_form" ).submit(function( event ) {
			return checkComment(event, <?php echo $wb_idx?>);
		});
	</script>
</div>