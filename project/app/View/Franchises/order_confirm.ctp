
				<?php echo $this->Session->flash('auth'); ?>
				<h2>GAMI ORDER SYSTEM</h2>
					
				<div class="row">
					<div class="form-group table-responsive checkbox">
						<form name="orderForm" id="confirmForm" action="<?php echo $mainPageUrl;?>/Franchises/OrderProcess" method="post">
							<fieldset>
								<table class="table table-hover">
									<thead>
										<tr>
											<th>Category</th>
											<th>Item</th>
											<th>Unit</th>
											<th>Order qty</th>
										</tr>
									</thead>
									
									<tbody>
										<?php
										foreach($products as $key=>$product):
										?>
										<input type="hidden" name="orderlist[]" value='<?php echo $orderlist[$key];?>' />
										<input type="hidden" name="op_order_qty[]" value='<?php echo $op_order_qty[$key];?>' />
										<tr>
											<td><?php echo $product['Category']['cate_title'];?></td>
											<td><?php echo $product['Product']['pro_name'];?></td>
											<td><?php echo $product['Product']['pro_unit'];?></td>
											<td><?php echo $op_order_qty[$key];?></td>
										</tr>
										<?php
										endforeach;
										unset($product);
										?>
									</tbody>
								</table>
								
								<p class="text-center">
									<button class="btn btn-lg btn-danger" type="button" onclick="goBackOrderPage();">BACK</button>
									<button class="btn btn-lg btn-primary" type="submit">CONFIRM</button>
								</p>
							</fieldset>
						</form>
					</div>
				</div>
				
			<?php //echo $this->element('sql_dump'); ?>
			
