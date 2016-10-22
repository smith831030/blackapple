			<?php echo $this->Html->script('HuskyEZCreator.js', array('inline' => false, 'charset'=>'utf-8'));?>
			
			<!--<NOTICE>-->
			<div class="post">
				<?php echo $this->Form->create('BaPost', array('class'=>'form_add')); ?>
					<fieldset>
						<legend><?php echo __('Add Post'); ?></legend>
						<!--<POST CATEGORY-->
						<select name="data[BaPost][category_id]">
							<?php foreach ($categories as $category): ?>
							<option value="<?php echo $category['BaPostCategory']['id'];?>"><?php echo $category['BaPostCategory']['category_title'];?></option>
							<?php endforeach; ?>
							<?php unset($category); ?>
							
						</select>
						<!--</POST CATEGORY-->
						<?php echo $this->Form->input('BaPost.title', array('datatype'=>'string', 'class'=>'input_title'));?>
						<?php echo $this->Form->input('BaPost.body', array('datatype'=>'text', 'id'=>'data[BaPost][body]'));?>
						<?php echo $this->Form->input('BaPost.tags', array('datatype'=>'string', 'class'=>'input_title'));?>
						<?php echo $this->Form->input('BaPost.img', array('id'=>'img'));?>
						
						<input type="button" id="btn_submit" value="Add" onclick="submitContents(this);" class="button" />
					</fieldset>
				<?php echo $this->Form->end(); ?>
				<?php echo $this->element('sql_dump'); ?>
			</div>
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
				} catch(e) {alert(e);}
			}
			</script>
