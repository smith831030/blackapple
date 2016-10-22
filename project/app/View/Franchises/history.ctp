
				<?php echo $this->Session->flash('auth'); ?>
				<h2>GAMI ORDER SYSTEM</h2>
					
				<div class="row">
					<div class="col-md-4 list-group table-responsive">
						<table class="table table-hover">
							<thead>
								<tr>
									<th>Shop</th>
									<th>ID</th>
									<th>Ordered</th>
									<th>Status</th>
								</tr>
							</thead>
							
							<tbody>
								<?php
								foreach($histories as $history):
									switch($history['Order']['order_status']){
										case -1: case-2: case -3:
											$status='<span class="label label-danger">Cancel</span>';
											break;
										case 0:
											$status='<span class="label label-default">Organising</span>';
											break;
										case 1:
											$status='<span class="label label-success">Completed</span>';
											break;
										case 2:
											$status='<span class="label label-info">Released by Admin</span>';
											break;
										case 4:
											$status='<span class="label label-warning">Delivering</span>';
											break;
									}
								?>
								<tr onclick="getHistoryDetail(this, <?php echo $history['Order']['order_idx'];?>, <?php echo $history['Order']['order_status'];?>); return false;">
									<td><?php echo $history['Shop']['shop_title'];?></td>
									<td><?php echo $history['Member']['mem_id'];?></td>
									<td><?php echo $history['Order']['created'];?></td>
									<td><?php echo $status;?></td>
								</tr>
								<?php
								endforeach;
								unset($history);
								?>
							</tbody>
						</table>
						<div class="paging">
							<?php echo $this->Paginator->numbers(array('separator' => ' &nbsp;'));?>
						</div>
					</div>
					
					<div class="col-md-8 form-group table-responsive" id="div_history_detail">
						<?php if($detailLists){ ?>
						<div class="alert alert-success" role="alert">
							<span class="glyphicon glyphicon-ok"></span>
							<span><strong>Your order is completed</strong></span>
						</div>
						
						<table class="table table-hover">
							<thead>
								<tr>
									<th>Category</th>
									<th>Product name</th>
									<th>Unit</th>
									<th>Order qty</th>
								</tr>
							</thead>
							
							<tbody>
								<?php
								foreach($detailLists as $list):
								?>
								<tr>
									<td><?php echo $list['C']['cate_title'];?></td>
									<td><?php echo $list['P']['pro_name'];?></td>
									<td><?php echo $list['P']['pro_unit'];?></td>
									<td><?php echo $list['OrderProduct']['op_order_qty'];?></td>
								</tr>
								<?php
								endforeach;
								unset($list);
								?>
							</tbody>
						</table>
						<?php }?>
					</div>
				</div>
				
			<?php //echo $this->element('sql_dump'); ?>
			
