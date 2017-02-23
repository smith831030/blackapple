			<?php echo $this->Html->script('HuskyEZCreator.js', array('inline' => false, 'charset'=>'utf-8'));?>

			<!--<NOTICE>-->
			<div class="col-md-8 col-md-offset-2">
				<?php echo $this->Form->create('BaPost', array('class'=>'form-horizontal')); ?>
					<fieldset>
						<legend><?php echo __('Edit Post'); ?></legend>
						<!--<POST CATEGORY-->
						<select name="data[BaPost][category_id]" class="form-control">
							<?php foreach ($categories as $category): ?>
							<option value="<?php echo $category['BaPostCategory']['id'];?>" <?php if($this->request->data['BaPost']['category_id']==$category['BaPostCategory']['id']){echo 'selected';}?>><?php echo $category['BaPostCategory']['category_title'];?></option>
							<?php endforeach; ?>
							<?php unset($category); ?>

						</select>
						<!--</POST CATEGORY-->
						<?php echo $this->Form->input('BaPost.title', array('datatype'=>'string', 'class'=>'form-control'));?>
						<?php echo $this->Form->input('BaPost.body', array('datatype'=>'text', 'id'=>'data[BaPost][body]', 'class'=>'form-control'));?>
						<?php echo $this->Form->input('BaPost.tags', array('datatype'=>'string', 'class'=>'form-control'));?>
						<?php echo $this->Form->hidden('BaPost.id');?>
						<?php echo $this->Form->input('BaPost.img', array('id'=>'img', 'class'=>'form-control'));?>

						<label>Players</label>
						<button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal_players">Players</button>
						<br><br>

						<button type="submit" id="btn_submit" onclick="submitContents(this);" class="btn btn-primary">Modify</button>

						<!-- Modal -->
						<div class="modal fade" id="modal_players" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<h4 class="modal-title">Players</h4>
									</div>
									<div class="modal-body">
										<table class="table" id="players">
											<thead>
												<tr>
													<th><input type="checkbox" id="player_all"></th>
													<th>Name</th>
													<th>Back Number</th>
													<th>Position</th>
												</tr>
											</thead>

											<tbody>
												<?php foreach($players as $player):?>
												<tr>
													<td>
														<input type="checkbox" class="p_id" name="player[]" id="player_<?=$player['BaPlayer']['id'];?>" value="<?=$player['BaPlayer']['id'];?>"></td>
													<td><label for="player_<?=$player['BaPlayer']['id'];?>"><?=$player['BaPlayer']['p_name'];?></label></td>
													<td><?=$player['BaPlayer']['p_backnumber'];?></td>
													<td><?=$player['BaPlayer']['p_position'];?></td>
												</tr>
												<?php endforeach; ?>
											</tbody>
										</table>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-primary" data-dismiss="modal">Select</button>
									</div>
								</div><!-- /.modal-content -->
							</div><!-- /.modal-dialog -->
						</div><!-- /.modal -->
					</fieldset>
				<?php echo $this->Form->end(); ?>
				<?php //echo $this->element('sql_dump'); ?>
			</div>
			<div class="clearfix"></div>
			<!--</NOTICE>-->

			<script type="text/javascript">
			var oEditors = [];

			// 추가 글꼴 목록
			//var aAdditionalFontSet = [["MS UI Gothic", "MS UI Gothic"], ["Comic Sans MS", "Comic Sans MS"],["TEST","TEST"]];

			nhn.husky.EZCreator.createInIFrame({
				oAppRef: oEditors,
				elPlaceHolder: "data[BaPost][body]",
				sSkinURI: "/SmartEditor2Skin.html",
				htParams : {
					bUseToolbar : true,				// 툴바 사용 여부 (true:사용/ false:사용하지 않음)
					bUseVerticalResizer : true,		// 입력창 크기 조절바 사용 여부 (true:사용/ false:사용하지 않음)
					bUseModeChanger : true,			// 모드 탭(Editor | HTML | TEXT) 사용 여부 (true:사용/ false:사용하지 않음)
					//aAdditionalFontList : aAdditionalFontSet,		// 추가 글꼴 목록
					fOnBeforeUnload : function(){
						//alert("완료!");
					}
				}, //boolean
				fOnAppLoad : function(){
					//예제 코드
					//oEditors.getById["data[BaPost][body]"].exec("PASTE_HTML", ["로딩이 완료된 후에 본문에 삽입되는 text입니다."]);
				},
				fCreator: "createSEditor2"
			});

			function submitContents(elClickedObj) {
				oEditors.getById["data[BaPost][body]"].exec("UPDATE_CONTENTS_FIELD", []);	// 에디터의 내용이 textarea에 적용됩니다.

				// 에디터의 내용에 대한 값 검증은 이곳에서 document.getElementById("data[BaPost][body]").value를 이용해서 처리하면 됩니다.

				try {
					elClickedObj.form.submit();
				} catch(e) {}
			}

			$(document).ready(function(){
				$('#player_all').on('change', function(e){
					$('.p_id').attr('checked', $(this).prop('checked'));
				})

				$('#players').DataTable({
					paging: false
				});

				<?php foreach($p_players as $p):?>
					$('#player_<?=$p['BaPostsPlayer']['player_id'];?>').attr('checked', true);
				<?php endforeach;?>
			});
			</script>
