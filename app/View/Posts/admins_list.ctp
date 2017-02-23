			<!--<NOTICE>-->
			<form action="/Admins/Posts/changeCategory" method="post">
				<table class="table">
					<thead>
						<tr>
							<th><input type="checkbox" id="checkall"></th>
							<th>Image</th>
							<th>Title</th>
							<th>Date</th>
						</tr>
					</thead>

					<tbody>
						<?php foreach ($posts as $post): ?>
							<tr>
								<td><input type="checkbox" name="id[]" class="post_id" value="<?php echo $post['BaPost']['id'];?>"></td>
								<td><img src="/upload/<?php echo $post['BaPost']['img'];?>" width="50"></td>
								<td>[<?php echo $post['BaPostCategory']['category_title']?>] <?php echo $this->Html->link($post['BaPost']['title'],'/Admins/Posts/view/'.$post['BaPost']['id']); ?> (<?php echo $post['BaPost']['comment_total']?>)</td>
								<td><?php echo $post['BaPost']['created']?></td>
							</tr>
							<?php endforeach; ?>
							<?php unset($post); ?>
						</tbody>
					</table>

					<!-- <paging> -->
					<div class="text-center">
						<ul class="pagination">
							<?php echo $this->Paginator->numbers(array('tag'=>'li', 'currentTag'=>'a', 'currentClass'=>'active', 'separator'=>''));?>
						</ul>
					</div>
					<!-- </paging> -->
					<div class="col-md-6">
						<div class="col-md-8">
							<select name="category_id" class="form-control">
							<?php foreach($top_categories as $category): ?>
								<option value="<?php echo $category['BaPostCategory']['id'];?>"><?php echo $category['BaPostCategory']['category_title'];?></option>
							<?php endforeach; ?>
							</select>
						</div>
						<div class="col-md-4">
							<button type="submit" class="btn btn-default">Move</button>
						</div>
					</div>
				</form>

				<div class="text-right">
					<?php echo $this->Html->link('Add', '/Admins/Posts/add', array('class'=>'btn btn-default')); ?>
				</div>
				<?php //echo $this->element('sql_dump'); ?>
			</div>
			<!--</NOTICE>-->

			<script>
				$(document).ready(function(){
					$('#checkall').on('change', function(e){
						$('.post_id').attr('checked', $(this).prop('checked'));
					})
				});
			</script>
