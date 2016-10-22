			<!--<ABOUT BLACK APPLE>-->
			<div class="container">
				<!--<BLACK APPLE>-->
					<div id="blackapple_history">
						<h2>BlackApple's history</h2>

						<?php
						echo $this->Form->create('WsHistory', array('class'=>'form-group'));
						echo $this->Form->textarea('wb_content', array('class'=>'form-control'));
						echo $this->Form->button('submit', array('class'=>'btn btn-primary'));
 						echo $this->Form->end();
						?>


						<table class="table">
							<thead>
								<tr>
									<th>DATE</th>
									<th>CONTENT</th>
								</tr>
							</thead>
							<tbody>
								<?php $historyI=0;?>
								<?php foreach ($posts as $post): ?>
								<?php
								$history_wb_date=$post['WsHistory']['wb_date'];;
								$history_new_wb_date=substr($history_wb_date,0,10);
								$history_new_wb_date=str_replace("-", ".", $history_new_wb_date);
								$history_wb_content=$post['WsHistory']['wb_content'];
								$history_wb_content=str_replace("&", "&amp;", $history_wb_content);
								if($historyI%2==1)
									$historyBG="class='bg'";
								else
									$historyBG="";
								?>
								<tr <?php echo $historyBG?>>
									<td><?php echo $history_new_wb_date?></td>
									<td><?php echo $history_wb_content?></td>
								</tr>
								<?php $historyI++; ?>
								<?php endforeach; ?>
								<?php unset($post); ?>

								<tr >
									<td>2005.06</td>
									<td>Attended "47th Seoul Comic World" festival with my <a href="/Works/DoorEp2" class="highlight">original comic book</a></td>
								</tr>
								<tr>
									<td>2003</td>
									<td>Dong-Wook withdrew</td>
								</tr>
								<tr >
									<td>2002</td>
									<td>Attended "Seoul Comic World" festival with our original illustration book</td>
								</tr>
								<tr>
									<td>2001</td>
									<td>Changed team name to "Black Apple"</td>
								</tr>
								<tr >
									<td>1999</td>
									<td>Yong-Wook withdrew and changed team name to "Ruin"</td>
								</tr>
								<tr>
									<td>1998</td>
									<td>Made an amateur artist team "Freestyle" with Dong-Wook and Yong-Wook</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<!--</BLACK APPLE>-->
