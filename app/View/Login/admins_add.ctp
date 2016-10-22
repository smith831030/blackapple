<div class="users form">
<?php echo $this->Form->create('BaMember'); ?>
    <fieldset>
        <legend><?php echo __('Add Member'); ?></legend>
		<label for="BaMemberMemberId">ID</label>
		<?php echo $this->Form->text('BaMember.member_id');?>
		<label for="BaMemberMemberPwd">PWD</label>
		<?php echo $this->Form->password('BaMember.member_pwd');?>
		
		<input type="submit" id="btn_submit" value="Add" />
    </fieldset>
<?php echo $this->Form->end(); ?>
</div>