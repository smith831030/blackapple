				<div class="main-top container">
				</div>

				<div class="container">
					<div class="row">
						<h2>Latest Artwork</h2>
						<?php foreach($posts as $post):?>
						<div class="col-md-3 col-sm-6">
							<div class="thumbnail">
								<img itemprop="image" src="/upload/<?php echo $post['BaPost']['img'];?>" title="<?php echo $post['BaPost']['title'];?>" />

								<div class="caption">
									<h3><?php echo $post['BaPost']['title'];?></h3>
									<a href="/Posts/index/<?php echo $post['BaPost']['category_id'];?>" class="btn btn-xs btn-warning"><?php echo $post['BaPostCategory']['category_title'];?></a>
									<p><?php echo $post['BaPost']['created'];?></p>
									<p><a href="/Posts/view/<?php echo $post['BaPost']['id'];?>" class="btn btn-primary" role="button">View Detail</a>
								</div>
							</div>
						</div>
						<?php endforeach;?>
					</div>
				</div>

			<?php //echo $this->element('sql_dump'); ?>
