
				<?php echo $this->Session->flash('auth'); ?>
				<h2>Add stocks</h2>
					
				<div class="row">
					<div class="col-md-6 list-group">
					<?php
					foreach($categories as $category):
					?>
						<a href="#" onclick="getProductList(this,<?php echo $category['Category']['cate_idx'];?>); return false;" class="list-group-item"><?php echo $category['Category']['cate_title'];?></a>
					<?php
					endforeach;
					unset($category);
					?>
					</div>
					
					<div class="col-md-6 form-group table-responsive checkbox" id="product_list">
						<form name="orderForm" action="<?php echo $mainPageUrl;?>/Managers/MaintenanceStockAdd" method="post" onsubmit="return checkSubmit();">
							<fieldset>
								<table class="table table-hover">
									<thead>
										<tr>
											<th></th>
											<th>Item</th>
											<th>Unit</th>
											<th>Qty</th>
											<th>Add</th>
										</tr>
									</thead>
									
									<tbody>
										<?php
										foreach($products as $key=>$product):
										?>
										<tr class="<?php echo "categories category_".$product['Product']['cate_idx'];?>">
											<td><label class="label_checkbox"><input type="checkbox" name="orderlist[]" class="op_idx" id="op_idx_<?php echo $product['Product']['pro_idx'];?>" value="<?php echo $product['Product']['pro_idx'];?>" onchange="enabledTextbox(<?php echo $product['Product']['pro_idx'];?>, this);return false;" /></label></td>
											<td onclick="enabledTextbox(<?php echo $product['Product']['pro_idx'];?>);return false;"><?php echo $product['Product']['pro_name'];?></td>
											<td onclick="enabledTextbox(<?php echo $product['Product']['pro_idx'];?>);return false;"><?php echo $product['Product']['pro_unit'];?></td>
											<td onclick="enabledTextbox(<?php echo $product['Product']['pro_idx'];?>);return false;"><span <?php if($product['Product']['pro_qty']<0) echo 'class="span_danger"';?>><?php echo $product['Product']['pro_qty']; ?></span></td>
											<td><input type="number" step="1" name="op_order_qty[]" id="orderqty_<?php echo $product['Product']['pro_idx'];?>" class="orderqty" disabled /></td>
										</tr>
										<?php
										endforeach;
										unset($product);
										?>
									</tbody>
								</table>
								<button class="btn btn-lg btn-primary btn-block" type="submit">ADD</button>
							</fieldset>
						</form>
					</div>
				</div>
				
			<?php //echo $this->element('sql_dump'); ?>
			
