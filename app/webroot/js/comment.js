	function show_delete_form(wb_idx, tb_name, wbc_idx){
		var url, frm;
		if(wbc_idx){
			url="./comment/ws_comment_del.php";
			frm="comment_sub_"+wbc_idx;
		}else{
			url="./comment/ws_del.php";
			frm="delete_"+wb_idx;
		}
		
		if($("#"+frm).css("display")=="block"){
			$("#"+frm).hide();
		}else{
			var posting=$.get(url, {wb_idx:wb_idx, tb_name:tb_name, wbc_idx:wbc_idx});
			posting.done(function(data){
				$("#"+frm).html(data);	
			});
			$("#"+frm).show();
		}
	}
	
	function comment_del1(event, wb_idx){
		if(confirm("Do you really want to delete it?")){
			event.preventDefault();
			var url = $("#wb_del"+wb_idx ).attr( "action" );
			
			var posting = $.post(url, {wb_idx:$("#wb_idx"+wb_idx).val(), wb_pass:$("#wb_pass"+wb_idx).val(), tb_name:$("#tb_name"+wb_idx).val()});
			posting.done(function(data){
				if(data=="1"){
					getList(1,$("#tb_name"+wb_idx).val());
				}else{
					alert(data);
				}
			});
		}else{
			return false;
		}
	}

	function comment_del2(event,wbc_idx){
		if(confirm("Do you really want to delete it?")){
			event.preventDefault();
			var url = $("#wb_del_sub"+wbc_idx ).attr( "action" );
			
			var posting = $.post(url, {wb_idx:$("#wb_idx"+wbc_idx).val(), wbc_idx:$("#wbc_idx"+wbc_idx).val(), wbc_pass:$("#wbc_pass"+wbc_idx).val(), tb_name:$("#tb_name"+wbc_idx).val()});
			posting.done(function(data){
				if(data=="1"){
					getList(1, $("#tb_name"+wbc_idx).val(), $("#wb_idx"+wbc_idx).val());
				}else{
					alert(data);
				}
			});
		}else{
			return false;
		}
	}
  
	function showLayer(wb_idx, tb_name){
		if($("#comment_"+wb_idx).css("display")=="block"){
			$("#comment_"+wb_idx).hide();
		}else{
			var posting=$.get("/GuestBbs/comment/", {wb_idx:wb_idx});
			posting.done(function(data){
				$("#comment_"+wb_idx).html(data);
			});
			$("#comment_"+wb_idx).show();
		}
	}
  
	function checkCommentWrite(event){
		if($("#wb_name").val() == '' || $("#wb_pass").val() == '' || $("#wb_content").val() == ''){
			alert('Please fill up the form');
			return false;
		}else if($("#zsfCode").val() == ''){
			alert('Please enter the captcha code.');
			$("#zsfCode").focus();
			return false;
		}else{
			event.preventDefault();
			var url = $("#wb_write" ).attr( "action" );
			
			var posting = $.post(url, {wb_name:$("#wb_name").val(), wb_pass:$("#wb_pass").val(), wb_content:$("#wb_content").val(), tb_name:$("#tb_name").val(), zsfCode:$("#zsfCode").val()});

			posting.done(function(data){
				if(data=="1"){
					$("#wb_name").val("");
					$("#wb_pass").val("");
					$("#wb_content").val("");
					$("#zsfCode").val("");
					getList(1,$("#tb_name").val());
				}else{
					alert(data);
				}
			});
		}
	}
	
	function checkComment(event, wb_idx){
		if($("#wbc_name"+wb_idx).val() == '' || $("#wbc_pass"+wb_idx).val() == '' || $("#wbc_comment"+wb_idx).val() == ''){
			alert('Please fill up the form');
			return false;
		}else if($("#zsfCode"+wb_idx).val() == ''){
			alert('Please enter the captcha code.');
			$("#zsfCode"+wb_idx).focus();
			return false;
		}else{
			event.preventDefault();
			var url = $("#wbc_comment"+wb_idx+"_form").attr( "action" );
			
			var posting = $.post(url, {wbc_name:$("#wbc_name"+wb_idx).val(), wbc_pass:$("#wbc_pass"+wb_idx).val(), wbc_comment:$("#wbc_comment"+wb_idx).val(), tb_name:$("#tb_name"+wb_idx).val(), wb_idx:$("#wb_idx"+wb_idx).val(), zsfCode:$("#zsfCode"+wb_idx).val()});

			posting.done(function(data){
				if(data=="1"){
					$("#wbc_name"+wb_idx).val("");
					$("#wbc_pass"+wb_idx).val("");
					$("#wbc_comment"+wb_idx).val("");
					$("#zsfCode"+wb_idx).val("");
					getList(1,$("#tb_name"+wb_idx).val(), wb_idx);
				}else{
					alert(data);
				}
			});
		}
	}
	
	function getList(page, tb_name, wb_idx){
		var posting=$.get("./comment/ws_list.php", {page:page, tb_name:tb_name});
		posting.done(function(data){
				$("#subCommentList").html(data);
				if(wb_idx) showLayer(wb_idx, tb_name);
			});
	}