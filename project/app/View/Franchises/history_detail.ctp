<?php
$histories=array();
foreach($lists as $key=>$list):
	$histories[$key]['op_idx']=$list['OrderProduct']['op_idx'];
	$histories[$key]['op_order_qty']=$list['OrderProduct']['op_order_qty'];
	$histories[$key]['op_release_qty']=$list['OrderProduct']['op_release_qty'];
	$histories[$key]['op_comment']=$list['OrderProduct']['op_comment'];
	$histories[$key]['pro_name']=$list['P']['pro_name'];
	$histories[$key]['pro_unit']=$list['P']['pro_unit'];
	$histories[$key]['cate_title']=$list['C']['cate_title'];
endforeach;
unset($list);

echo json_encode($histories);
?>
<?php //echo $this->element('sql_dump'); ?>