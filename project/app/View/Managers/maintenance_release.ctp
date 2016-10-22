
				<?php echo $this->Session->flash('auth'); ?>
				<h2>Release stocks</h2>
					
				<div class="row">
					<form name="orderForm" action="<?php echo $mainPageUrl;?>/Managers/MaintenanceReleaseAdd" method="post" onsubmit="return checkRelease();">
						<fieldset>
							<div class="col-md-6">
								<?php
								foreach($shops as $shop):
									$option[$shop['Shop']['shop_idx']]= $shop['Shop']['shop_title'];
								endforeach;
								unset($shop);
								
								echo '<div class="form-group mReleaseSelect"><label class="col-sm-3 control-label">Release to:</label><div class="col-sm-9">'.$this->Form->select('Order.shop_idx', $option, array('empty' => '(choose one)', 'class'=>'form-control shop_idx')).'</div></div>';
								?>
								
								<div class="list-group">
									<?php
									foreach($categories as $category):
									?>
									<a href="#" onclick="getProductList(this,<?php echo $category['Category']['cate_idx'];?>); return false;" class="list-group-item"><?php echo $category['Category']['cate_title'];?></a>
									<?php
									endforeach;
									unset($category);
									?>
								</div>
							</div>
							
							<div class="col-md-6 form-group table-responsive checkbox" id="product_list">
								
								<table class="table table-hover">
									<thead>
										<tr>
											<th></th>
											<th>Item</th>
											<th>Unit</th>
											<th>Current qty</th>
											<th>Release qty</th>
										</tr>
									</thead>
									
									<tbody>
										<?php
										foreach($products as $key=>$product):
										?>
										<tr class="<?php echo "categories category_".$product['Product']['cate_idx'];?>">
											<td><label class="label_checkbox"><input type="checkbox" name="pro_idx[]" class="op_idx" id="op_idx_<?php echo $product['Product']['pro_idx'];?>" value="<?php echo $product['Product']['pro_idx'];?>" onchange="enabledTextbox(<?php echo $product['Product']['pro_idx'];?>, this);return false;" /></label></td>
											<td onclick="enabledTextbox(<?php echo $product['Product']['pro_idx'];?>);return false;"><?php echo $product['Product']['pro_name'];?></td>
											<td onclick="enabledTextbox(<?php echo $product['Product']['pro_idx'];?>);return false;"><?php echo $product['Product']['pro_unit'];?></td>
											<td onclick="enabledTextbox(<?php echo $product['Product']['pro_idx'];?>);return false;"><span><?php echo $product['Product']['pro_qty']; ?></span></td>
											<td><input type="number" min="0" step="1" name="op_order_qty[]" id="orderqty_<?php echo $product['Product']['pro_idx'];?>" class="orderqty" disabled /></td>
										</tr>
										<?php
										endforeach;
										unset($product);
										?>
									</tbody>
								</table>
								<button class="btn btn-lg btn-primary btn-block" type="submit">RELEASE</button>
							</div>
						</fieldset>
					</form>
				</div>
				
			<?php //echo $this->element('sql_dump'); ?>
			
