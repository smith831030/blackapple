<?php echo $this->Html->css(array('works.css','jquery.fancybox.css','jquery.fancybox-buttons.css'), array('inline' => false));?>
<?php echo $this->Html->script(array('jquery.fancybox.pack.js','jquery.fancybox-buttons.js'), array('inline' => false));?>
			<!--<WORKS>-->
			<div id="works">
				<h2><img src="/img/works/title_works.jpg" title="WORKS" ALT="WORKS" /></h2>
				<?php include "./common/works_sub_list.php" ?>
				
				<div id="work_content">
					<h3>2012 The fighters</h3>
					<span class="type">Original comic</span>
					<button id="btn_back" onclick="location.href='/Works';">BACK</button>
					<span class="information">Pen. 35 pages.<br />Original story comics. Fight and fight and fight.</span>
					<ul class="imagelist">
						<?php 
						for($i=1;$i<=35;$i++){
							if(strlen($i)==1){
								$number="0000".$i;
							}elseif(strlen($i)==2){
								$number="000".$i;
							}else{
								$number=$i;
							}
						?>
						<li><img src="/img/works/2012.the.fighters/2012.the.fighters.<?php echo($number);?>.jpg" alt="2005 The door episode2 page <?php echo($number);?>" title="2005 The door episode2 page <?php echo($number);?>" /></li>
						<?php }?>
					</ul>
				</div>
			</div>
			<div class="clearBoth"></div>
			<!--</WORKS>-->