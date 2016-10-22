			
			<div class="container">
				<?php echo $this->Session->flash('auth'); ?>

				<?php echo $this->Form->create('Member', ['type'=>'post', 'class'=>'form-signin']);?>
					<?php
					foreach($shops as $shop):
						$option[$shop['Shop']['shop_idx']]= $shop['Shop']['shop_title'];
					endforeach;
					unset($shop);
					
					echo $this->Form->select('Member.shop_idx', $option, ['empty' => '(choose one)']);
					echo $this->Form->hidden('Member.mem_level', ['value'=>'20']);
					?>
					<label for="inputEmail" class="sr-only">Email address</label>
					<?php echo $this->Form->text('Member.mem_id', ['id'=>'inputEmail', 'class'=>'form-control', 'placeholder'=>'ID', 'required', 'autofocus']);?>
					<label for="inputPassword" class="sr-only">Password</label>
					<?php echo $this->Form->password('Member.mem_pwd', ['id'=>'inputPassword', 'class'=>'form-control', 'placeholder'=>'Password', 'required']);?>
					
					<button class="btn btn-lg btn-primary btn-block" type="submit">Create</button>
				<?php echo $this->Form->end();?>
			</div>
			<?php echo $this->element('sql_dump'); ?>
			
