								<ul class="list">
									<?php foreach ($comments as $comment): ?>
									<?php
										if($comment_id==0){
											if($comment['BaPostComment']['reply_total']==1) 
												$reply_txt = "<span id='reply_total_num_".$comment['BaPostComment']['id']."'>".$comment['BaPostComment']['reply_total']."</span> <span id='reply_total_txt_".$comment['BaPostComment']['id']."'>Reply</span>";
											elseif($comment['BaPostComment']['reply_total']>1) 
												$reply_txt = "<span id='reply_total_num_".$comment['BaPostComment']['id']."'>".$comment['BaPostComment']['reply_total']."</span> <span id='reply_total_txt_".$comment['BaPostComment']['id']."'>Replies</span>";
											else
												$reply_txt = "<span id='reply_total_num_".$comment['BaPostComment']['id']."'></span> <span id='reply_total_txt_".$comment['BaPostComment']['id']."'>Reply</span>";
										}
									?>
									<li>
										<span class="img"><img src="https://graph.facebook.com/<?php echo $comment['BaPostComment']['user_id'];?>/picture" /></span>
										<div class="info">
											<span class="name"><a href="http://facebook.com/<?php echo $comment['BaPostComment']['user_id'];?>" class="bold" target="_blank"><?php echo $comment['BaPostComment']['user_name'];?></a></span>
											<span class="comment"><?php echo $comment['BaPostComment']['comment'];?></span>
											<?php if($facebook_id==$comment['BaPostComment']['user_id']){?><span class="icon_del_comment"><a href="#" class="red_link" onclick="submit_comment_delete(<?php echo $comment['BaPostComment']['id'];?>, <?php echo $comment['BaPostComment']['user_id'];?>, <?php echo $comment['BaPostComment']['post_id'];?>, <?php echo $comment['BaPostComment']['depth'];?>); return false;">X</a></span><?php }?>
											<span class="created"><?php echo $comment['BaPostComment']['created'];?></span>
											<?php if($comment_id==0){?><span class="reply"><a href="#" onclick="openReply(<?php echo $post_id;?>, <?php echo $comment['BaPostComment']['id']?>); return false;" class="highlight"><?php echo $reply_txt;?></a></span><?php }?>
										</div>
										
										<?php if($comment_id==0){?><div class="reply_list dpNone" id="reply_list_<?php echo $comment['BaPostComment']['id'];?>"></div><?php }?>
									</li>
									<?php endforeach; ?>
									<?php unset($comment); ?>
								</ul>
								<div class="div_post_comment" id="div_post_comment_<?php echo $comment_id; ?>">
									<fb:login-button scope="public_profile,email" onlogin="checkLoginState();"></fb:login-button>
								</div>