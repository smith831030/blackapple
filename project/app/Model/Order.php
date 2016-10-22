<?php
class Order extends AppModel {
	public $primaryKey = 'order_idx';
	public $hasMany = array(
		'OrderProduct' => array(
			'className' => 'OrderProduct',
			'foreignKey' => 'order_idx'
		)
	);
}
?>