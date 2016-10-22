
				<?php echo $this->Session->flash('auth'); ?>
				<div class="row">
					<h2>History</h2>
					<?php echo $this->Html->image('common/logo.png', array('alt'=>'GAMI', 'class'=>'dpNone', 'id'=>'hidden_print_logo')); ?>
					
					<div id="div_order_list" class="col-md-4 list-group table-responsive">
						<div class="btn-group">
							<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
								Sort <span class="caret"></span>
							</button>
							<ul class="dropdown-menu" role="menu">
								<li><a href="<?php echo $this->request->here;?>">All</a></li>
								<?php 
								foreach($shops as $shop):
									if($shop['Shop']['shop_title']=='admin'){
										$shop_title = 'Added';
										
									}else{
										$shop_title = $shop['Shop']['shop_title'];
									}
								?>
								<li><a href="<?php echo $mainPageUrl;?>/Managers/History<?php echo '?sorts='.$shop['Shop']['shop_idx'];?>"><?php echo $shop_title;?></a></li>
								<?php
								endforeach;
								unset($shop);
								?>
							</ul>
						</div>
						
						<table class="table table-hover">
							<thead>
								<tr>
									<th>Shop</th>
									<th>UserID</th>
									<th>Ordered</th>
									<th>Status</th>
								</tr>
							</thead>
							
							<tbody>
								<?php
								foreach($orderLists as $list):
									if($list['Shop']['shop_title']=='admin'){
										$shop_title = 'Added';
									}else{
										$shop_title = $list['Shop']['shop_title'];
									}
									
									switch($list['Order']['order_status']){
										case -1: case-2: case -3:
											$status='<span class="label label-danger">Cancel</span>';
											break;
										case 1:
											$status='<span class="label label-success">Completed</span>';
											break;
										case 2:
											$status='<span class="label label-info">Released by Admin</span>';
											break;
										case 3:
											$status='<span class="label label-primary">Added</span>';
											break;
										case 4:
											$status='<span class="label label-warning">Delivering</span>';
											break;
									}
									
									if($this->Time->format($list['Order']['created'], '%H')>=0 && $this->Time->format($list['Order']['created'], '%H')<=3)
										$created = $this->Time->format($list['Order']['created'].'-1 day', '%e/%b/%Y');
									else
										$created = $this->Time->format($list['Order']['created'], '%e/%b/%Y');
								?>
								
								<tr onclick="location.href='<?php echo $mainPageUrl;?>/Managers/History/<?php echo $list['Order']['order_idx'];?><?php echo '/page:'.$this->Paginator->param('page');?><?php if(isset($sort)) echo '?sorts='.$sort;?>';" <?php if($list['Order']['order_idx']==$order_idx) echo 'class="success"';?>>
									<td><?php echo $shop_title;?></td>
									<td><?php echo $list['Member']['mem_id'];?></td>
									<td><span title="<?php echo $list['Order']['created'];?>"><?php echo $created;?></span></td>
									<td><?php echo $status;?></td>
								</tr>
								<?php
								endforeach;
								unset($list);
								?>
							</tbody>
						</table>
						<div class="paging">
							<?php echo $this->Paginator->numbers(array('separator' => ' &nbsp;'));?>
						</div>
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
						
						<form name="orderForm" id="orderForm" action="<?php echo $mainPageUrl;?>/Managers/OrderCancel" method="post" onsubmit="return checkCancelForm(-1);">
							<fieldset>
								<input type="hidden" name="data[Order][order_idx]" value="<?php echo $order_idx;?>" />
								<input type="hidden" name="data[Order][order_status]" id="order_status" value="-1" />
								<input type="hidden" name="order_current_status" id="order_current_status" value="<?php echo $detailLists[0]['Order']['order_status'];?>" />
								<table class="table table-hover">
									<thead>
										<tr>
											<th>Category</th>
											<!--<th class="printDp">itemcode</th>-->
											<th>Product name</th>
											<th>Unit</th>
											<th>Order qty</th>
											<?php if($detailLists[0]['Order']['order_status']<2 || $detailLists[0]['Order']['order_status']==4){?>
												<th>Released qty</th>
												<th>Comment</th>
											<?php }?>
										</tr>
									</thead>
									
									<tbody>
										<?php
										foreach($detailLists as $key=>$list):
											$class='';
											if($list['OrderProduct']['op_order_qty']!=$list['OrderProduct']['op_release_qty'])
												$class='class="danger"';
										?>
										<tr <?php echo $class;?>>
											<td><?php echo $list['C']['cate_title'];?></td>
											<!--<td class="printDp"><?php echo $list['P']['pro_itemcode'];?></td>-->
											<td><?php echo $list['P']['pro_name'];?></td>
											<td><?php echo $list['P']['pro_unit'];?></td>
											<td><?php echo $list['OrderProduct']['op_order_qty'];?></td>
											<?php if($detailLists[0]['Order']['order_status']<2 || $detailLists[0]['Order']['order_status']==4){?>
												<td><?php echo $list['OrderProduct']['op_release_qty'];?></td>
												<td><?php echo $list['OrderProduct']['op_comment'];?></td>
											<?php }?>
										</tr>
										<?php
										endforeach;
										unset($list);
										?>
									</tbody>
								</table>
								<?php if($detailLists[0]['Order']['order_status']!=3){?>
								<p class="text-right">
									<?php if($detailLists[0]['Order']['order_status']<0){?>
									<button class="btn btn-lg btn-success" type="button" onclick="checkRecovery();">RECOVERY</button>
									<?php }else{?>
									<button class="btn btn-lg btn-info" type="button" onclick="window.print();">PRINT</button>
									<button class="btn btn-lg btn-danger" type="submit">CANCEL</button>
									<?php }?>
									
									<?php if($detailLists[0]['Order']['order_status']==4){?>
									<button class="btn btn-lg btn-primary" type="button" onclick="adminOrderComplete();">COMPLETE</button>
									<?php }?>
								</p>
								<?php }?>
							</fieldset>
						</form>
						<?php }?>
					</div>
				</div>
				
			<?php //echo $this->element('sql_dump'); ?>
			
