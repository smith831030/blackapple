
				<?php echo $this->Session->flash('auth'); ?>
				<h2>Storage</h2>
					
				<div class="row">
					<div class="col-md-6 list-group">
						<button type="button" class="btn btn-default btn_add_new_item" aria-label="Add new item" onclick="location.href='<?php echo $mainPageUrl;?>/Managers/MaintenanceAddNewItem';">
							<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add new item
						</button> 

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
						<form name="orderForm" action="<?php echo $mainPageUrl;?>/Managers/MaintenanceStorageModify" method="post" onsubmit="return checkSubmitStorage();">
							<fieldset>
								<table class="table table-hover">
									<thead>
										<tr>
											<th></th>
											<th>Item</th>
											<th>Unit</th>
											<th>Qty</th>
											<th></th>
										</tr>
									</thead>
									
									<tbody>
										<?php
										foreach($products as $key=>$product):
										?>
										<tr class="<?php echo "categories category_".$product['Product']['cate_idx'];?>">
											<td><label class="label_checkbox"><input type="checkbox" name="data[<?php echo $key;?>][Product][pro_idx]" class="op_idx" id="pro_idx_<?php echo $product['Product']['pro_idx'];?>" value="<?php echo $product['Product']['pro_idx'];?>" onchange="enabledTextboxStorage(<?php echo $product['Product']['pro_idx'];?>, this);return false;" /></label></td>
											<td><input type="text" name="data[<?php echo $key;?>][Product][pro_name]" class="pro_name" id="pro_name_<?php echo $product['Product']['pro_idx'];?>" value="<?php echo $product['Product']['pro_name'];?>" disabled /></td>
											<td>
												<select name="data[<?php echo $key;?>][Product][pro_unit]" disabled id="pro_unit_<?php echo $product['Product']['pro_idx'];?>">
												<?php
													foreach($pro_unit_lists as $unitlist):
														$selected='';
														if($unitlist['Product']['pro_unit']==$product['Product']['pro_unit'])
															$selected='selected="selected"';
														echo '<option value="'.$unitlist['Product']['pro_unit'].'" '.$selected.'>'.$unitlist['Product']['pro_unit'].'</option>';
													endforeach;
													unset($unitlist);
												?>
												</select>
											</td>
											<td onclick="enabledTextboxStorage(<?php echo $product['Product']['pro_idx'];?>);return false;"><span <?php if($product['Product']['pro_qty']<0) echo 'class="span_danger"';?>><?php echo $product['Product']['pro_qty']; ?></span></td>
											<td>
												<button type="button" class="btn btn-default btn-xs" aria-label="Add new item" onclick="deleteItem(<?php echo $product['Product']['pro_idx'];?>);">
													<span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
												</button> 
											</td>
										</tr>
										<?php
										endforeach;
										unset($product);
										?>
									</tbody>
								</table>
								<button class="btn btn-lg btn-primary btn-block" type="submit">MODIFY</button>
							</fieldset>
						</form>
					</div>
				</div>
				
			<?php //echo $this->element('sql_dump'); ?>
			
