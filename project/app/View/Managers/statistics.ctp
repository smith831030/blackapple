			
			<?php echo $this->Html->css('jquery-ui.min.css', array('inline' => false));?>
			<?php echo $this->Html->script('jquery-ui.min.js', array('inline' => false));?>
			<?php echo $this->Html->script('https://www.google.com/jsapi', array('inline' => false));?>
			<script>
				jQuery(function() {
					jQuery( ".startDate" ).datepicker({
						dateFormat:'yy-mm-dd',
						defaultDate: "+1w",
						numberOfMonths: 3,
						onClose: function( selectedDate ) {
						jQuery( ".endDate" ).datepicker( "option", "minDate", selectedDate );
						}
					});
					jQuery( ".endDate" ).datepicker({
						dateFormat:'yy-mm-dd',
						defaultDate: "+1w",
						numberOfMonths: 3,
						onClose: function( selectedDate ) {
						jQuery( ".startDate" ).datepicker( "option", "maxDate", selectedDate );
						}
					});
					
				});
				
				<?php if(isset($results)){?>
				google.load('visualization', '1', {packages: ['corechart', 'bar']});
				google.setOnLoadCallback(drawBasic);
				
				
				function drawBasic() {
					var data = new google.visualization.DataTable();
					data.addColumn('string', 'Items');
					data.addColumn('number', 'Released qty');

					data.addRows([
						<?php
						foreach($results as $key=>$result):
							if($key>0)	
								echo ',';
						?>
						['<?php echo $result['Product']['pro_name'];?>', <?php echo $result[0]['released'];?>]
						<?php
						endforeach;
						unset($result);
						?>
					]);

					var options = {
						title: 'Released quantity of items',
						hAxis: {
							title: 'Item name',
						},
						vAxis: {
							title: 'Released qty'
						},
						width:'100%',
						height:300
					};

					var chart = new google.visualization.ColumnChart(
					document.getElementById('chart_div'));

					chart.draw(data, options);
				}
				<?php }?>
			</script>
			
			<div class="row">
				<h2>Statistics</h2>
				
				<div id="div_search" class="col-md-6 form-group">
					<form id="searchForm" method="post" action="">
						<fieldset>
							<?php
								foreach($shops as $shop):
									$option[$shop['Shop']['shop_idx']]= $shop['Shop']['shop_title'];
								endforeach;
								unset($shop);
								
								echo '<div class="col-sm-4">'.$this->Form->select('Order.shop_idx', $option, array('empty' => 'All', 'class'=>'form-control shop_idx')).'</div>';
							?>
							<div class="col-sm-8">
								<input type="text" class="startDate" name="startDate" value="<?php if(isset($startDate)) echo $startDate;?>" /> ~ <input type="text" class="endDate" name="endDate" value="<?php if(isset($endDate)) echo $endDate;?>" />
								<button class="btn btn-default" type="submit">Search</button>
							</div>
						</fieldset>
				</div>
				
				<div class="col-md-6 table-responsive"></div>
			</div>
			
			<?php if(isset($results)){?>
			<div class="row">
				<h2 class="dpNone">Result</h2>
				
				<div id="chart_div"></div>
				
				<table class="table table-hover">
					<thead>
						<tr>
							<th>Product name</th>
							<th>Released qty</th>
						</tr>
					</thead>
					
					<tbody>
						<?php
						foreach($results as $result):
						?>
						<tr>
							<td><?php echo $result['Product']['pro_name'];?></td>
							<td><?php echo $result[0]['released'];?></td>
						</tr>
						<?php
						endforeach;
						unset($result);
						?>
					</tbody>
				</table>
			</div>
			<?php }?>
			<?php // echo $this->element('sql_dump'); ?>
			
