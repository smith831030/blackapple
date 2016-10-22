<?php echo $this->Html->css(array('works.css','jquery.fancybox.css','jquery.fancybox-buttons.css'), array('inline' => false));?>
<?php echo $this->Html->script(array('jquery.fancybox.pack.js','jquery.fancybox-buttons.js'), array('inline' => false));?>
			<!--<WORKS>-->
			<div id="works">
				<h2><img src="/img/works/title_works.jpg" title="WORKS" ALT="WORKS" /></h2>
				<?php include "./common/works_sub_list.php" ?>
				
				<div id="work_content">
					<h3>2002 INK &amp; WHITE</h3>
					<span class="type">Original comic</span>
					<button id="btn_back" onclick="location.href='/Works';">BACK</button>
					<span class="information">First comics in my life. Use ink &amp; screen tone. 2 pages.<br />The angel from white fights against the devil from ink. </span>
					<ul class="imagelist">
						<li><img src="/img/works/2002.ink.n.white/2002.ink.n.white.001.jpg" alt="2002 INK &amp; WHITE page 1" title="2002 INK &amp; WHITE page 1" /></li>
						<li><img src="/img/works/2002.ink.n.white/2002.ink.n.white.002.jpg" alt="2002 INK &amp; WHITE page 2" title="2002 INK &amp; WHITE page 2" /></li>
					</ul>
				</div>
			</div>
			<div class="clearBoth"></div>
			<!--</WORKS>-->