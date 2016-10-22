
				<?php echo $this->Session->flash('auth'); ?>
				<h2>Storage > modify > complete</h2>
					
				<div class="row">
					<div class="alert alert-success" role="alert">
						<span class="glyphicon glyphicon-ok"></span>
						<span><strong>Your stuff has been updated.</strong></span>
					</div>
					
					<div class="form-group table-responsive checkbox">
						<table class="table table-hover">
							<thead>
								<tr>
									<th>Category</th>
									<th>Item</th>
									<th>Unit</th>
								</tr>
							</thead>
							
							<tbody>
								<?php
								foreach($lists as $key=>$product):
								?>
								<tr>
									<td><?php echo $product['Category']['cate_title'];?></td>
									<td><?php echo $product['Product']['pro_name'];?></td>
									<td><?php echo $product['Product']['pro_unit'];?></td>
								</tr>
								<?php
								endforeach;
								unset($product);
								?>
							</tbody>
						</table>
								
						<p class="text-center">
							<button class="btn btn-lg btn-primary" type="button" onclick="location.href='<?php echo $mainPageUrl;?>/Managers/MaintenanceStorage';">BACK TO STORAGE</button>
						</p>
					</div>
				</div>
				
			<?php //echo $this->element('sql_dump'); ?>
			
