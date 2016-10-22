function getProductList(obj, cate_idx){
	$(obj).parent().children('.active').removeClass('active');
	$(obj).addClass('active');
	
	
	$('.categories').hide();
	$('#product_list').show();
	$('.category_'+cate_idx).show();
}

function enabledTextbox(pro_idx, obj){
	if(!obj){
		$('#op_idx_'+pro_idx).prop('checked', !$('#op_idx_'+pro_idx).is(':checked'));
	}
	$('#cate_title_'+pro_idx).prop('disabled', !$('#op_idx_'+pro_idx).is(':checked'));
	$('#orderqty_'+pro_idx).prop('disabled', !$('#op_idx_'+pro_idx).is(':checked'));
	$('#orderqty_'+pro_idx).val(1);
	$('#orderqty_'+pro_idx).focus();
}

function enabledTextboxStorage(pro_idx, obj){
	if(!obj){
		$('#pro_idx_'+pro_idx).prop('checked', !$('#pro_idx_'+pro_idx).is(':checked'));
	}
	$('#pro_name_'+pro_idx).prop('disabled', !$('#pro_idx_'+pro_idx).is(':checked'));
	$('#pro_unit_'+pro_idx).prop('disabled', !$('#pro_idx_'+pro_idx).is(':checked'));
}

function checkSubmit(){
	var input;
	$('.orderqty:enabled').each(function(){
		if($(this).val()==''){
			input=false;
			return false;
		}
	});
	
	if(!$('.label_checkbox input').is(':checked')){
		alert('Please select at least one item');
		return false;
	}else if(input==false){
		alert('Please input the value');
		return false;
	}
}

function checkSubmitStorage(){
	var input;
	$('.pro_name:enabled').each(function(){
		if($(this).val()==''){
			input=false;
			return false;
		}
	});
	
	if(!$('.op_idx').is(':checked')){
		alert('Please select at least one item');
		return false;
	}else if(input==false){
		alert('Please input the value');
		return false;
	}
}

function checkSubmitAddNewItem(){
	if($('#cate_idx').val()==''){
		alert('Please choose category');
		return false;
	}else if($('#pro_unit').val()==''){
		alert('Please choose unit of product');
		return false;
	}else if($('#pro_name').val()==''){
		alert('Please input product name');
		return false;
	}
}

function getHistoryDetail(obj, order_idx, order_status){
	$('.success').removeClass('success');
	$(obj).addClass('success');
	
	
	
	$.getJSON('/project/Franchises/HistoryDetail/'+order_idx, function(data){
		var html=$('<div></div>');
		var table = $('<table></table>').addClass('table table-hover');
		var thead = $('<thead></thead>');
		
		var th=[];
		th.push("<th>Category</th>");
		th.push("<th>Product name</th>");
		th.push("<th>Unit</th>");
		th.push("<th>Order qty</th>");
		if(order_status>0){
			th.push("<th>Released qty</th>");
			th.push("<th>Comment</th>");
		}
		$( "<tr/>", {
			html: th.join( "" )
		}).appendTo(thead);
		table.append(thead);
		
		$.each( data, function( key, val ) {
			var items = [];
			items.push( "<td>" + val.cate_title + "</td>" );
			items.push( "<td><strong>" + val.pro_name + "</strong></td>" );
			items.push( "<td>" + val.pro_unit + "</td>" );
			items.push( "<td>" + val.op_order_qty + "</td>" );
			if(order_status>0){
				items.push( "<td>" + val.op_release_qty + "</td>" );
				items.push( "<td>" + val.op_comment + "</td>" );
				
				if(val.op_order_qty!=val.op_release_qty)
					var tr_class="danger";
			}
			
			$( "<tr/>", {
				"class":tr_class,
				html: items.join( "" )
			}).appendTo(table);
		});
		html.append(table);
		
		if(order_status==4){
			var form = $('<form></form>');
			form.attr('action', '/project/Franchises/OrderComplete');
			form.attr('method', 'post');
			form.attr('onsubmit', 'return orderComplete();');
			
			var hidden='<input type="hidden" name="order_idx" value="'+order_idx+'" />';
			var btn='<p class="text-right"><button class="btn btn-lg btn-primary" type="submit">COMPLETE</button></p>';
			form.append(hidden);
			form.append(btn);
			
			html.append(form);
		}

		$( "#div_history_detail" ).html(html);
	});
}

function orderComplete(){
	if(!confirm('Do you want to complete this order?')){
		return false;
	}else{
		return true;
	}
}

function adminOrderComplete(){
	if(!confirm('Do you want to complete this order?')){
		return false;
	}else{
		$('#orderForm').attr('action', '/project/Managers/OrderComplete');
		$('#orderForm').attr('onsubmit', '');
		$('#order_status').val(1);
		$('#orderForm').submit();
	}
}

function checkAll(obj){
	$('.op_idx').prop('checked', $(obj).is(':checked'));
}

function checkThis(obj){
	var chk = $(obj).parent().children().children().children('.op_idx');
	chk.prop('checked', !chk.is(':checked'));
}

function checkForm(){
	var result = true;
	$('.op_idx').each(function(){
		if(!$(this).is(":checked")){
			alert('Please check all items');
			result=false;
			return false;
		}
	});
	return result;
}

function checkCancelForm(order_status){
	if(confirm('Are you sure to cancel this order?')){
		$('#orderForm').attr('action', '/project/Managers/OrderCancel');
		$('#orderForm').attr('onsubmit', '');
		if($('#order_current_status').val()==1){
			$('#order_status').val(-1);
		}else if($('#order_current_status').val()==2){
			$('#order_status').val(-2);
		}else if($('#order_current_status').val()==4){
			$('#order_status').val(-4);
		}else{
			$('#order_status').val(order_status);
		}
		$('#orderForm').submit();
	}else{
		return false;
	}
}

function checkRecovery(){
	if(confirm('Are you sure to recovery this order?')){
		$('#orderForm').attr('action', '/project/Managers/OrderRecovery');
		$('#orderForm').attr('onsubmit', '');
		if($('#order_current_status').val()==-1){
			$('#order_status').val(1);
		}else if($('#order_current_status').val()==-2){
			$('#order_status').val(2);
		}else{
			$('#order_status').val(0);
		}
		$('#orderForm').submit();
	}else{
		return false;
	}
}

function checkRelease(){
	var input;
	$('.orderqty:enabled').each(function(){
		if($(this).val()=='' || $(this).val()<=0){
			input=false;
			return false;
		}
	});
	
	if($('.shop_idx').val()==''){
		alert('Please select shop');
		$('.shop_idx').focus();
		return false;
	}else if(!$('.op_idx').is(':checked')){
		alert('Please select at least one item');
		return false;
	}else if(input==false){
		alert('Please input the value');
		return false;
	}
}

function goBackOrderPage(){
	$('#confirmForm').attr('action', '/project/Franchises/Order');
	$('#confirmForm').submit();
}

function deleteItem(pro_idx){
	if(confirm('Do you want to delete this item?')){
		location.href='/project/Managers/MaintenanceDeleteItem/'+pro_idx;
	}else{
		return false;
	}
}