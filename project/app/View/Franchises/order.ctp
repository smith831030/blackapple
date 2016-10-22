
				<?php echo $this->Session->flash('auth'); ?>
				<h2>GAMI ORDER SYSTEM</h2>
					
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
						<form name="orderForm" action="<?php echo $mainPageUrl;?>/Franchises/OrderConfirm" method="post" onsubmit="return checkSubmit();">
							<fieldset>
								<table class="table table-hover">
									<thead>
										<tr>
											<th></th>
											<th>Item</th>
											<th>Unit</th>
											<th>Qty</th>
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
											<td><input type="number" min="0" step="1" name="op_order_qty[]" id="orderqty_<?php echo $product['Product']['pro_idx'];?>" class="orderqty" disabled /></td>
										</tr>
										<?php
										endforeach;
										unset($product);
										?>
									</tbody>
								</table>
								<button class="btn btn-lg btn-primary btn-block" type="submit">ORDER</button>
							</fieldset>
						</form>
					</div>
				</div>
				
				<script>
					<?php
						if(isset($orderlist)){
							foreach($orderlist as $key=>$data):
								echo "$('#op_idx_".$data."').prop('checked', true);";
								echo "$('#orderqty_".$data."').val(".$op_order_qty[$key].");";
								echo "$('#orderqty_".$data."').prop('disabled', false);";
							endforeach;
						}
					?>
				</script>
				
			<?php //echo $this->element('sql_dump'); ?>
			
