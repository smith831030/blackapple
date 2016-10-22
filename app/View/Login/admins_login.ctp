		<?php echo $this->Html->css(array('admin.css'), array('inline' => false));?>
		<?php echo $this->Session->flash('auth'); ?>
		<div class="admin">
			<h2>Admin Login</h2>
			<?php echo $this->Session->flash('auth'); ?>
			<?php echo $this->Form->create('BaMember');?>
				<fieldset>
					<legend>Login form</legend>
					<label for="BaMemberMemberId">ID</label>
					<?php echo $this->Form->text('BaMember.member_id');?>
					<label for="BaMemberMemberPwd">PWD</label>
					<?php echo $this->Form->password('BaMember.member_pwd');?>
					
					<input type="submit" id="btn_submit" value="Login" />
				</fieldset>
			<?php echo $this->Form->end();?>
		</div>
		<?php //echo $this->element('sql_dump'); ?>