<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	public $components = array(
		'Session',
		'Auth' => array(
			'loginRedirect' => array('controller' => 'MainPage', 'action' => 'index'),
			'logoutRedirect' => array('controller' => 'MainPage', 'action' => 'index')
		)
	);
	
	public function beforeFilter() {
		// Pass settings in
		$this->Auth->authenticate = array(
			'Basic' => array('userModel' => 'Member'),
			'Form' => array('userModel' => 'Member', 'fields' => array('username' => 'mem_id', 'password' => 'mem_pwd', 'created'=>'mem_regdate'))
		);
		$this->Auth->allow();
		
		
	}
	
	public function addLog($action, $detail){
		$this->loadModel('Log');
		
		$logData=array();
		$logData['Log']=array();
		$logData['Log']['mem_idx']=$this->Auth->user('mem_idx');
		$logData['Log']['shop_idx']=$this->Auth->user('shop_idx');
		$logData['Log']['log_action']=$action;
		$logData['Log']['log_detail']=json_encode($detail);
				
		$this->Log->save($logData);
	}
	
	public function setLog($order_idx, $log_type){
		//logs
		$fields='Shop.shop_title, Member.mem_id, Order.created, Category.cate_title, Product.pro_name, Product.pro_unit, OrderProduct.op_order_qty, OrderProduct.op_release_qty, OrderProduct.op_comment';
		$joins=array(array(
						'table'=>'shops',
						'alias'=>'Shop',
						'type'=>'INNER',
						'conditions'=>array('Order.shop_idx=Shop.shop_idx')
					),array(
						'table'=>'members',
						'alias'=>'Member',
						'type'=>'INNER',
						'conditions'=>array('Order.mem_idx=Member.mem_idx')
					),array(
						'table'=>'order_products',
						'alias'=>'OrderProduct',
						'type'=>'INNER',
						'conditions'=>array('Order.order_idx=OrderProduct.order_idx')
					),array(
						'table'=>'products',
						'alias'=>'Product',
						'type'=>'INNER',
						'conditions'=>array('OrderProduct.pro_idx=Product.pro_idx')
					),array(
						'table'=>'categories',
						'alias'=>'Category',
						'type'=>'INNER',
						'conditions'=>array('Product.cate_idx=Category.cate_idx')
					)
				);
		$logs = $this->Order->find('all', array('fields'=>$fields, 'joins'=>$joins, 'conditions'=>array('Order.order_idx'=>$order_idx)));		
		
		$detail=array('mem_id'=>$this->Auth->user('mem_id'));
		$detail[$log_type] = array('info'=>array(),'products'=>array());
		$detail[$log_type]['info']['shop_title']=$logs[0]['Shop']['shop_title'];
		$detail[$log_type]['info']['member_id']=$logs[0]['Member']['mem_id'];
		$detail[$log_type]['info']['ordered']=$logs[0]['Order']['created'];
		
		foreach($logs as $key=>$data){
			$detail[$log_type]['products'][$key]=array(
															'category'=>$data['Category']['cate_title'],
															'product_name'=>$data['Product']['pro_name'],
															'product_unit'=>$data['Product']['pro_unit'],
															'order_qty'=>$data['OrderProduct']['op_order_qty'],
															'release_qty'=>$data['OrderProduct']['op_release_qty'],
															'comment'=>$data['OrderProduct']['op_comment']
														);
		}
		
		$this->addLog($log_type, $detail);
	}
	
	public function setLogAdmin($log_type, $pro_idx){
		$fields='Category.cate_title, Product.pro_idx, Product.pro_name, Product.pro_unit';
		$joins=array(array(
						'table'=>'categories',
						'alias'=>'Category',
						'type'=>'INNER',
						'conditions'=>array('Product.cate_idx=Category.cate_idx')
					));
		$lists=$this->Product->find('all', array('fields'=>$fields, 'joins'=>$joins, 'conditions'=>array('Product.pro_idx'=>$pro_idx)));
		
		$detail=array('mem_id'=>$this->Auth->user('mem_id'));
		foreach($lists as $key=>$data){
			$detail[$log_type]['products'][$key] = array('category'=>$data['Category']['cate_title'],
														'pro_idx'=>$data['Product']['pro_idx'],
														'product_name'=>$data['Product']['pro_name'],
														'product_unit'=>$data['Product']['pro_unit']);
		}
		$this->addLog($log_type, $detail);
	}
	
}
