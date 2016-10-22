<?php
class OrderProduct extends AppModel {
	public $primaryKey = 'op_idx';
	
	public $belongsTo = array(
		'Order' => array(
			'className' => 'Order',
			'foreignKey' => 'order_idx'
		)
	);
}
?>