	function getList(page, post_id){
		var posting=$.get("/Posts/lists/"+page+"/"+post_id);
		posting.done(function(data){
				$("#post_lists").html(data);
			});
	}
	
	function statusChangeCallback(response, post_id, comment_id) {
		FB.getLoginStatus(function(response){
			if (response.status === 'connected') {
				FB.api('/me', function(response) {
					/* admin check */
					if(response.id=="100000924274679"){
						response.id="501671759858991";
						response.name="Black Apple";
					}
					
					var html = '';
					html += '<form action="/Posts/CommentAdd" method="post" class="post_comment_form" id="comment_form_'+comment_id+'">';
					html += '	<legend>comment</legend>';
					html += '	<input type="hidden" name="data[BaPostComment][user_id]" value="'+response.id+'" />';
					html += '	<input type="hidden" name="data[BaPostComment][user_name]" value="'+response.name+'" />';
					html += '	<input type="hidden" name="data[BaPostComment][post_id]" value="'+post_id+'" />';
					html += '	<input type="hidden" name="data[BaPostComment][depth]" value="'+comment_id+'" />';
					
					html += '	<img src="https://graph.facebook.com/'+response.id+'/picture" width="32" />';
					html += '	<textarea type="text" name="data[BaPostComment][comment]" class="comment" rows="3" cols="5"></textarea>';
					html += '	<input type="button" class="btn_submit" value="Comment" onclick="submit_comment('+post_id+', '+comment_id+'); return false;" />';
					html += '</form>';
					jQuery("#div_post_comment_"+comment_id).html(html);
				});
			} else if (response.status === 'not_authorized') {
				jQuery(".div_post_comment_"+comment_id).append('Please log into this app.' );
			} else {
				jQuery(".div_post_comment_"+comment_id).append('Please log into Facebook.' );
			}
		});
	}
	
	function checkLoginState(post_id, comment_id) {
		FB.getLoginStatus(function(response) {
			statusChangeCallback(response, post_id, comment_id);
		});
	}
	
	function openReply(post_id, comment_id){
		/* Reply layer open/close */
		if(jQuery("#reply_list_"+comment_id).css("display")=="none"){
			if(jQuery("#reply_list_"+comment_id).html()){
				jQuery("#reply_list_"+comment_id).show('fast');
			}else{
				var comments=$.get("/Posts/comment/"+post_id+"/"+comment_id);
				comments.done(function(data){
					jQuery("#reply_list_"+comment_id).html(data);
					jQuery("#reply_list_"+comment_id).show('fast');
					checkLoginState(post_id, comment_id);
				});
			}
		}else{
			jQuery("#reply_list_"+comment_id).hide('fast');
		}
	}
	
	function submit_comment(post_id, comment_id){
		jQuery.post(
			"/Posts/CommentAdd", 
			{
				'data[BaPostComment][user_id]' : jQuery("#comment_form_"+comment_id).find("input[name='data[BaPostComment][user_id]']").val(),
				'data[BaPostComment][user_name]' : jQuery("#comment_form_"+comment_id).find("input[name='data[BaPostComment][user_name]']").val(),
				'data[BaPostComment][post_id]' : jQuery("#comment_form_"+comment_id).find("input[name='data[BaPostComment][post_id]']").val(),
				'data[BaPostComment][depth]' : jQuery("#comment_form_"+comment_id).find("input[name='data[BaPostComment][depth]']").val(),
				'data[BaPostComment][comment]' : jQuery("#comment_form_"+comment_id).find("textarea[name='data[BaPostComment][comment]']").val()
			},
			function(data){
				if(data==1){	//success
				
					var comments=$.get("/Posts/comment/"+post_id+"/0");
					comments.done(function(data){
						jQuery(".post_comment").html(data);
						checkLoginState(post_id, 0);
						
						if(comment_id>0){
							openReply(post_id, comment_id);
						}
					});
					
					jQuery("#comment_total_num").html(parseInt(jQuery("#comment_total_num").html())+1);
				}else{	//fail
					alert("error");
				}
			}
		);
	}
	
	function submit_comment_delete(comment_id, user_id, post_id, depth){
		if(confirm("Are you sure")){
			jQuery.post(
				"/Posts/CommentDel", 
				{
					'data[BaPostComment][comment_id]' : comment_id,
					'data[BaPostComment][user_id]' : user_id,
					'data[BaPostComment][post_id]' : post_id,
					'data[BaPostComment][depth]' : depth
				},
				function(data){
					if(data.result==1){	//success
						var comments=$.get("/Posts/comment/"+post_id+"/0");
						comments.done(function(data){
							jQuery(".post_comment").html(data);
							checkLoginState(post_id, 0);
							
							if(depth>0){
								openReply(post_id, depth);
							}
						});
						
						jQuery("#comment_total_num").html(parseInt(jQuery("#comment_total_num").html())-(1+parseInt(data.count_reply)));
					}else{	//fail
						alert("error");
					}
				},
				"json"
			);
		}
	}
	
	function hoverImg(obj){
		var w=$(obj).width();
		$(obj).width(w-3);
		
		
		var title= $(obj).parents().children('.title');
		title.css('width', $(obj).width());
		title.css('height', $(obj).height());
		title.css('position', 'absolute');
		title.css('background-color', '#6b93a9');
		title.css('opacity', '0.5');
		title.show();
		
		title.mouseout(function(){
			$(obj).width(w);
			title.hide();
		});
	}