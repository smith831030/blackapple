<?php echo $this->Html->css(array('works.css','jquery.fancybox.css','jquery.fancybox-buttons.css'), array('inline' => false));?>
<?php echo $this->Html->script(array('jquery.fancybox.pack.js','jquery.fancybox-buttons.js'), array('inline' => false));?>
			<!--<WORKS>-->
			<div id="works">
				<h2><img src="/img/works/title_works.jpg" title="WORKS" ALT="WORKS" /></h2>
				<?php include "./common/works_sub_list.php" ?>
				
				<div id="work_content">
					<h3>2005 門(The door) episode 2</h3>
					<span class="type">Original comic</span>
					<button id="btn_back" onclick="location.href='/Works';">BACK</button>
					<span class="information">ink &amp; screen tone. 37 pages.<br />Original story series "The door" second part.</span>
					<ul class="list_episode">
						<li><?php echo $this->Html->link('#1','/Works/DoorEp2/1');?></li>
						<li><?php echo $this->Html->link('#2','/Works/DoorEp2/2');?></li>
						<li><?php echo $this->Html->link('#3','/Works/DoorEp2/3');?></li>
					</ul>
					<div class="clearBoth"></div>
					
					<?php if($no==1){?>
						<ul class="imagelist">
							<?php 
							for($i=1;$i<=13;$i++){
								if(strlen($i)==1){
									$number="00".$i;
								}elseif(strlen($i)==2){
									$number="0".$i;
								}else{
									$number=$i;
								}
							?>
							<li><img src="/img/works/2005.door.ep02/2005.door.ep02.<?php echo($number);?>.jpg" alt="2005 The door episode2 page <?php echo($number);?>" title="2005 The door episode2 page <?php echo($number);?>" /></li>
							<?php }?>
						</ul>
						<div class="content_bottom">
							<?php echo $this->Html->link('Next >','/Works/DoorEp2/2');?>
						</div>
					<?php }elseif($no==2){?>
						<ul class="imagelist">
							<?php 
							for($i=14;$i<=25;$i++){
								if(strlen($i)==1){
									$number="00".$i;
								}elseif(strlen($i)==2){
									$number="0".$i;
								}else{
									$number=$i;
								}
							?>
							<li><img src="/img/works/2005.door.ep02/2005.door.ep02.<?php echo($number);?>.jpg" alt="2005 The door episode2 page <?php echo($number);?>" title="2005 The door episode2 page <?php echo($number);?>" /></li>
							<?php }?>
						</ul>
						
						<div class="content_bottom">
							<?php echo $this->Html->link('< Prev','/Works/DoorEp2/1');?>
							<?php echo $this->Html->link('Next >','/Works/DoorEp2/3');?>
						</div>
					<?php }elseif($no==3){?>
						<ul class="imagelist">
							<?php 
							for($i=26;$i<=37;$i++){
								if(strlen($i)==1){
									$number="00".$i;
								}elseif(strlen($i)==2){
									$number="0".$i;
								}else{
									$number=$i;
								}
							?>
							<li><img src="/img/works/2005.door.ep02/2005.door.ep02.<?php echo($number);?>.jpg" alt="2005 The door episode2 page <?php echo($number);?>" title="2005 The door episode2 page <?php echo($number);?>" /></li>
							<?php }?>
						</ul>
						
						<div class="content_bottom">
							<?php echo $this->Html->link('< Prev','/Works/DoorEp2/2');?>
						</div>
					<?php }?>
				</div>
			</div>
			<div class="clearBoth"></div>
			<!--</WORKS>-->