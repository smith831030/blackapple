
				<?php echo $this->Session->flash('auth'); ?>
				<div class="row">
					<h2>Order</h2>
					<?php echo $this->Html->image('common/logo.png', array('alt'=>'GAMI', 'class'=>'dpNone', 'id'=>'hidden_print_logo')); ?>
					
					<div id="div_order_list" class="col-md-4 list-group table-responsive">
						<table class="table table-hover">
							<thead>
								<tr>
									<th>Shop</th>
									<th>UserID</th>
									<th>Ordered</th>
								</tr>
							</thead>
							
							<tbody>
								<?php
								foreach($orderLists as $list):
									if($this->Time->format($list['Order']['created'], '%H')>=0 && $this->Time->format($list['Order']['created'], '%H')<=3)
										$created = $this->Time->format($list['Order']['created'].'-1 day', '%e/%b/%Y');
									else
										$created = $this->Time->format($list['Order']['created'], '%e/%b/%Y');
								?>
								<tr onclick="location.href='<?php echo $mainPageUrl;?>/Managers/Order/<?php echo $list['Order']['order_idx'];?>';" <?php if($list['Order']['order_idx']==$order_idx) echo 'class="success"';?>>
									<td><?php echo $list['Shop']['shop_title'];?></td>
									<td><?php echo $list['Member']['mem_id'];?></td>
									<td><span title="<?php echo $list['Order']['created'];?>"><?php echo $created;?></span></td>
								</tr>
								<?php
								endforeach;
								unset($list);
								?>
							</tbody>
						</table>
					</div>
					
					<div id="div_order_product_list" class="col-md-8 form-group table-responsive checkbox">
						<?php if($detailLists){ ?>
						<div id="print_invoice_info" class="dpNone">
							<address>
								<strong>INNOVEIL GAMI PTY LTD</strong><br />
								<strong>ABN</strong> 69 600 232 729<br />
								<strong>Address</strong> 10 /10 Northumberland St, South Melbourne<br />
								<strong>Contact</strong> +61 3 9686 6695<br />
								<strong>Date</strong> <?php echo date('j/M/Y');?><br />
								<strong>Shipment no</strong> <?php echo $detailLists[0]['Order']['order_code'];?>
							</address>
							
							<address>
								<strong>Bill to : <?php echo $detailLists[0]['Shop']['shop_title'];?></strong><br />
								<strong>Address : </strong><?php echo $detailLists[0]['Shop']['shop_address'];?><br />
								<strong>Contact : </strong><?php echo $detailLists[0]['Shop']['shop_contact'];?>
							</address>
						</div>
						
						<form name="orderForm" id="orderForm" action="<?php echo $mainPageUrl;?>/Managers/OrderProcess" method="post" onsubmit="return checkForm();">
							<fieldset>
								<input type="hidden" name="data[Order][order_idx]" value="<?php echo $order_idx;?>" />
								<input type="hidden" name="data[Order][order_status]" id="order_status" value="1" />
								<input type="hidden" name="order_current_status" value="0" />
								
								<table class="table table-hover">
									<thead>
										<tr>
											<th><label class="label_checkbox"><input type="checkbox" onchange="checkAll(this); return false;" /></label></th>
											<th>Category</th>
											<!--<th class="printDp">Itemcode</th>-->
											<th>Product name</th>
											<th>Unit</th>
											<th>Current qty</th>
											<th>Order qty</th>
											<th class="op_release_qty">Release qty</th>
											<th class="op_comment">Comment</th>
										</tr>
									</thead>
									
									<tbody>
										<?php
										foreach($detailLists as $key=>$list):
										?>
										<input type="hidden" name="pro_idx[]" value="<?php echo $list['OrderProduct']['pro_idx'];?>" />
										<tr>
											<td><label class="label_checkbox"><input type="checkbox" name="data[OrderProduct][<?php echo $key;?>][op_idx]" class="op_idx" value="<?php echo $list['OrderProduct']['op_idx'];?>" /></label></td>
											<td onclick="checkThis(this); return false;"><?php echo $list['C']['cate_title'];?></td>
											<!--<td onclick="checkThis(this); return false;" class="printDp"><?php echo $list['P']['pro_itemcode'];?></td>-->
											<td onclick="checkThis(this); return false;"><?php echo $list['P']['pro_name'];?></td>
											<td onclick="checkThis(this); return false;"><?php echo $list['P']['pro_unit'];?></td>
											<td onclick="checkThis(this); return false;"><span <?php if($list['P']['pro_qty']<0) echo 'class="span_danger"';?>><?php echo $list['P']['pro_qty'];?></span></td>
											<td onclick="checkThis(this); return false;"><?php echo $list['OrderProduct']['op_order_qty'];?></td>
											<td class="op_release_qty"><input type="number"name="data[OrderProduct][<?php echo $key;?>][op_release_qty]" class="orderqty" value="<?php echo $list['OrderProduct']['op_order_qty'];?>" /></td>
											<td class="op_comment"><input type="text" name="data[OrderProduct][<?php echo $key;?>][op_comment]" /></td>
										</tr>
										<?php
										endforeach;
										unset($list);
										?>
									</tbody>
								</table>
								<p class="text-right">
									<button class="btn btn-lg btn-info" type="button" onclick="window.print();">PRINT</button>
									<button class="btn btn-lg btn-danger" type="button" onclick="checkCancelForm(-3);">CANCEL</button>
									<button class="btn btn-lg btn-primary" type="submit">COMPLETE</button>
								</p>
							</fieldset>
						</form>
						<?php }?>
					</div>
				</div>
				
			<?php //echo $this->element('sql_dump'); ?>
			
