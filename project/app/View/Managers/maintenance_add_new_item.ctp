
				<?php echo $this->Session->flash('auth'); ?>
				<h2>Storage > Add new item</h2>
					
				<div class="row">
					<?php if(isset($pro_idx)){?>
					<div class="alert alert-success" role="alert">
						<span class="glyphicon glyphicon-ok"></span>
						<span><strong>New item has been updated.</strong></span>
						<button type="button" class="btn btn-default" onclick="location.href='<?php echo $mainPageUrl;?>/Managers/MaintenanceStorage';">Back to Storage</button>
					</div>
					<?php }?>
					
					<div class="col-md-12 list-group">
						<form name="orderForm" action="<?php echo $mainPageUrl;?>/Managers/MaintenanceAddNewItem" method="post" class="form-inline" onsubmit="return checkSubmitAddNewItem();">
							<fieldset>
								<div class="form-group">
								<?php
								foreach($categories as $category):
									$cate_option[$category['Category']['cate_idx']]= $category['Category']['cate_title'];
								endforeach;
								unset($category);
								echo $this->Form->select('Product.cate_idx', $cate_option, array('empty'=>'Category', 'id'=>'cate_idx', 'class'=>'form-control'));
								?>
								</div>
								
								<div class="form-group">
									<input type="text" name="data[Product][pro_name]" id="pro_name" class="form-control" />
								</div>
								
								<div class="form-group">
								<?php
								foreach($pro_unit_lists as $unit):
									$unit_option[$unit['Product']['pro_unit']]= $unit['Product']['pro_unit'];
								endforeach;
								unset($unit);
								echo $this->Form->select('Product.pro_unit', $unit_option, array('empty'=>'Unit', 'id'=>'pro_unit', 'class'=>'form-control'));
								?>
								</div>
								
								<button type="submit" class="btn btn-default">ADD</button>
							</fieldset>
						</form>
					</div>
				</div>
				
			<?php //echo $this->element('sql_dump'); ?>
			
