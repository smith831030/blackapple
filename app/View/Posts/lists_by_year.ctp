						<?php 
							$tmp_month='';
							
							foreach ($posts as $key=>$post):
								$year=$this->Time->format($post['BaPost']['created'], '%Y');
								$month=$this->Time->format($post['BaPost']['created'], '%b');
								
								if($key==0){
									echo '<h3>'.$year.'</h3>';
									echo '<h4>'.$month.'</h4>';
									echo '<ul>';
									$tmp_month=$month;
								}elseif($month!=$tmp_month){
									echo '</ul>';
									echo '<h4>'.$month.'</h4>';
									echo '<ul>';
									$tmp_month=$month;
								}
						?>
							<li>
								<span class="title" onclick="location.href='<?php echo '/Posts/view/'.$post['BaPost']['id'];?>';"><?php echo '['.$post['BaPostCategory']['category_title'].'] '.$post['BaPost']['title'].' ('.$post['BaPost']['comment_total'].')'; ?></span>
								<span class="created"><?php echo $post['BaPost']['created'];?></span>
								<?php echo $this->Html->image('/upload/'.$post['BaPost']['img'], array('alt'=>$post['BaPost']['title'], 'title'=>$post['BaPost']['title'], 'url'=>'/Posts/view/'.$post['BaPost']['id'], 'onmouseover'=>'hoverImg(this);')); ?>
							</li>
						<?php 
						endforeach; 
						unset($post); 
						?>
						</ul>
						<?php if($year>2014){ ?>
						<h3><a href="/Posts/ListsByYear/<?php echo $year-1;?>"><?php echo $year-1;?></a></h3>
						<?php }?>