<?php echo $this->Html->css(array('works.css','jquery.fancybox.css','jquery.fancybox-buttons.css'), array('inline' => false));?>
<?php echo $this->Html->script(array('jquery.fancybox.pack.js','jquery.fancybox-buttons.js'), array('inline' => false));?>
			<!--<WORKS>-->
			<div id="works">
				<h2><img src="/img/works/title_works.jpg" title="WORKS" ALT="WORKS" /></h2>
				<?php include "./common/works_sub_list.php" ?>
				
				<div id="work_content">
					<h3>2007 門(The door) episode 3</h3>
					<span class="type">Original comic</span>
					<button id="btn_back" onclick="location.href='/Works';">BACK</button>
					<span class="information">Photoshop. 5 episodes.<br />Original story series "The door" third part.</span>
					<ul class="list_episode">
						<li><?php echo $this->Html->link('#1','/Works/DoorEp3/1');?></li>
						<li><?php echo $this->Html->link('#2','/Works/DoorEp3/2');?></li>
						<li><?php echo $this->Html->link('#3','/Works/DoorEp3/3');?></li>
						<li><?php echo $this->Html->link('#4','/Works/DoorEp3/4');?></li>
						<li><?php echo $this->Html->link('#5','/Works/DoorEp3/5');?></li>
					</ul>
					
					<ul class="imagelist">
						<?php if($no==1){?>
						<li><img src="/img/works/2007.door.ep03/2007.door.ep03.001_map.jpg" alt="2007 The door episode3 page 1" title="2007 The door episode3 page 1" /></li>
						<?php }elseif($no==2){?>
						<li><img src="/img/works/2007.door.ep03/2007.door.ep03.002_ready.jpg" alt="2007 The door episode3 page 2" title="2007 The door episode3 page 2" /></li>
						<?php }elseif($no==3){?>
						<li><img src="/img/works/2007.door.ep03/2007.door.ep03.003_monster.jpg" alt="2007 The door episode3 page 3" title="2007 The door episode3 page 3" /></li>
						<?php }elseif($no==4){?>
						<li><img src="/img/works/2007.door.ep03/2007.door.ep03.004_break.jpg" alt="2007 The door episode3 page 4" title="2007 The door episode3 page 4" /></li>
						<?php }elseif($no==5){?>
						<li><img src="/img/works/2007.door.ep03/2007.door.ep03.005_dream.jpg" alt="2007 The door episode3 page 5" title="2007 The door episode3 page 5" /></li>
						<?php }?>
					</ul>
					
					<div class="content_bottom">
						<?php if($no>1) echo $this->Html->link('< Prev','/Works/DoorEp3/'.($no-1));?>
						<?php if($no<5) echo $this->Html->link('Next >','/Works/DoorEp3/'.($no+1));?>
					</div>
				</div>
			</div>
			<div class="clearBoth"></div>
			<!--</WORKS>-->