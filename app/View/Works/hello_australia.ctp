<?php echo $this->Html->css(array('works.css','jquery.fancybox.css','jquery.fancybox-buttons.css'), array('inline' => false));?>
<?php echo $this->Html->script(array('jquery.fancybox.pack.js','jquery.fancybox-buttons.js'), array('inline' => false));?>
			<!--<WORKS>-->
			<div id="works">
				<h2><img src="/img/works/title_works.jpg" title="WORKS" ALT="WORKS" /></h2>
				<?php include "./common/works_sub_list.php" ?>
				
				<div id="work_content">
					<h3>2012 Hello Australia</h3>
					<span class="type">Original comic</span>
					<button id="btn_back" onclick="location.href='/Works';">BACK</button>
					<span class="information">Pen. 17 episodes.<br />Australia life cartoon as a working holiday.</span>
					<ul class="list_episode">
						<?php for($i=1;$i<=17;$i++){?>
						<li><?php echo $this->Html->link('#'.$i,'/Works/HelloAustralia/'.$i);?></li>
						<?php }?>
					</ul>
					
					<?php 
						if($no){
							if(strlen($no)==1){
								$page="000".$no;
							}else{
								$page="00".$no;
							}
					?>
					<ul class="imagelist">
						<li><img src="/img/works/2012.hello.australia/2011.hello.australia.<?php echo($page);?>.jpg" alt="2012 Hello Australia episode <?php echo($no);?>" title="2012 Hello Australia episode <?php echo($no);?>" /></li>
					</ul>
					<?php }?>
					
					<div class="content_bottom">
						<?php if($no>1) echo $this->Html->link('< Prev','/Works/HelloAustralia/'.($no-1));?>
						<?php if($no<17) echo $this->Html->link('Next >','/Works/HelloAustralia/'.($no+1));?>
					</div>
				</div>
			</div>
			<div class="clearBoth"></div>
			<!--</WORKS>-->