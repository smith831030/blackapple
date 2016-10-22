				<!--<POST LIST>-->
				<div class="post_lists">
					<h2>Post List</h2>
					<ul>
						<?php foreach ($posts as $post): ?>
						<?php if($post_id==$post['BaPost']['id']) $class='now'; else $class=''; ?>
						<li>
							<span class="title <?php echo $class;?>"><?php echo $this->Html->link('['.$post['BaPostCategory']['category_title'].'] '.$post['BaPost']['title'], '/Posts/view/'.$post['BaPost']['id']);?> (<?php echo $post['BaPost']['comment_total']; ?>)</span>
							<span class="created"><?php echo $post['BaPost']['created'];?></span>
						</li>
						<?php endforeach; ?>
						<?php unset($post); ?>
					</ul>
				</div>
				<div class="clearBoth"></div>
				<!--</POST LIST>-->
				
				<!-- <paging> -->
				<div class="paging">
					<?php
					//페이징
					$pagePagesize=10; 					//한번에 보여줄 페이지의 수
					$totalpage=ceil($total/$pagesize);  //실질적인 총 페이지
					if($totalpage<$pagePagesize){		//총페이지수가 한번에 보여지는 페이지수 보다 작을경우 startpage=1
						$startpage=1;
					}else{
						$startpage=((int)(($page-1)/$pagePagesize))*$pagePagesize+1;
					}
					$lastpage=$startpage+$pagePagesize-1;   		//한번에 보여지는 페이지중 마지막 페이지
					if($totalpage<$lastpage){			//lastPage 가 총페이지수를 넘어갈경우 lastPage 는 totalPage가 된다.
						$lastpage=$totalpage;
					}
					if($startpage>1)  					//처음페이지가 1보다 크면 prev10 버튼 출력
						echo(" <a href='/Posts/lists/".($startpage-$pagePagesize)."/$post_id' onclick='getList(".($startpage-$pagePagesize).",$post_id);return false;'>[ &lt;&lt;prev10 ]</a> ");
					for($j=$startpage ; $j<=$lastpage ; $j++){
						if($j==$page){ 					//현재페이지에 <b>테그 적용하는 if문
							echo("<b>$j</b> &nbsp;");
						}else{
							echo("<a href='/Posts/lists/$j/$post_id' onclick='getList($j,$post_id);return false;'>$j</a> &nbsp;");
						}
					}
					if($lastpage<$totalpage)
						echo(" <a href='/Posts/lists/".($lastpage+1)."/$post_id' onclick='getList(".($lastpage+1).",$post_id);return false;'>[ next10>> ]</a> ");
					?>
				</div>
				<!-- </paging> -->
			
			<?php //echo $this->element('sql_dump'); ?>
			
