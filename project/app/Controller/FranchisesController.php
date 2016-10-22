<?php
/**
 * FranchisesController
 *
 * @author		Smith.Seo(smith831030@gmail.com)
 * @created		16/05/2015
 *
 */
class FranchisesController extends AppController {
	public $helpers = array('Html', 'Form', 'Session', 'Text');
	public $components = array('RequestHandler', 'Paginator');
	
	public function beforeFilter() {
		if(!$this->Auth->loggedIn()){
			return $this->redirect(array('controller'=>'MainPage', 'action'=>'index'));
		}
		$this->layout = 'franchises';
		$this->set('mainPageUrl', '/project');
	}
	
	public function index() {
		$this->set('current_page', 'main');
	}
	
	public function order() {
		$this->set('current_page', 'order');
		
		$this->set('orderlist', isset($this->request->data['orderlist'])?$this->request->data['orderlist']:null);
		$this->set('op_order_qty', isset($this->request->data['op_order_qty'])?$this->request->data['op_order_qty']:null);
		
		//Category list
		$this->loadModel('Category');
		$fields='Category.cate_idx, Category.cate_title';
		$this->set('categories', $this->Category->find('all', array('fields'=>$fields, 'order'=>'Category.cate_idx ASC')));
		
		//Product list
		$this->loadModel('Product');
		$fields='Product.pro_idx, Product.cate_idx, Product.pro_name, Product.pro_unit';
		$this->set('products', $this->Product->find('all', array('fields'=>$fields, 'order'=>'Product.cate_idx ASC, Product.pro_name ASC')));
	}
	
	public function orderConfirm(){
		$this->set('current_page', 'order');
		
		$orderlist=$this->request->data['orderlist'];
		$op_order_qty=$this->request->data['op_order_qty'];
		
		$this->loadModel('Product');
		$fields='Product.pro_name, Product.pro_unit, Category.cate_title';
		$joins=array(array(
						'table'=>'categories',
						'alias'=>'Category',
						'type'=>'INNER',
						'conditions'=>array('Product.cate_idx=Category.cate_idx')
					)
				);
		$products=$this->Product->find('all', array('fields'=>$fields, 'joins'=>$joins, 'conditions'=>array('Product.pro_idx'=>$orderlist), 'order'=>'Product.cate_idx ASC, Product.pro_name ASC'));
		
		$this->set('orderlist', $orderlist);
		$this->set('op_order_qty', $op_order_qty);
		$this->set('products', $products);
	}
	
	public function orderProcess(){
		$orderlist=$this->request->data['orderlist'];
		$op_order_qty=$this->request->data['op_order_qty'];
		
		//get shop information
		$this->loadModel('Shop');
		$fields='Shop.shop_code, Shop.shop_state';
		$shop_info = $this->Shop->find('all', array('fields'=>$fields, 'conditions'=>array('Shop.shop_idx'=>$this->Auth->user('shop_idx'))));
		$order_code = 'IC'.$shop_info[0]['Shop']['shop_state'].$shop_info[0]['Shop']['shop_code'].date('y');
		
		//set order code
		$this->loadModel('Order');
		$fields='Order.order_code';
		$last_ordercode = $this->Order->find('first', array('fields'=>$fields, 'conditions'=>array('Order.order_code LIKE '=>$order_code.'%'), 'order'=>'Order.order_idx DESC'));
		if(empty($last_ordercode)){
			$order_code=$order_code.'00001';
		}else{
			$order_code=$order_code.str_pad(((int)substr($last_ordercode['Order']['order_code'], -5,5))+1, 5, "0", STR_PAD_LEFT);
		}
		
		//insert into orders table
		$this->Order->begin();
		
		$this->Order->save(
			array(
				'shop_idx' => $this->Auth->user('shop_idx'),
				'mem_idx' => $this->Auth->user('mem_idx'),
				'order_code' => $order_code,
				'order_status' => '0'
			)
		);
		$order_idx=$this->Order->id;
		
		//insert into order_products table
		$this->loadModel('OrderProduct');
		$sql="INSERT INTO os_order_products(`order_idx`, `pro_idx`, `op_order_qty`) VALUES ";
		foreach($orderlist as $key=>$data){
			$sql.="($order_idx, '$data', '$op_order_qty[$key]')";
			if(count($orderlist)-1>$key)
				$sql.=",";
				
		}
		$this->OrderProduct->query($sql);
		
		$this->Order->commit();
		
		//logs
		$this->setLog($order_idx,'order');
		
		$this->flash('Your order has been completed, thanks', 'index');
		return $this->redirect(array('action' => 'history', $order_idx));
	}
	
	public function orderComplete(){
		$order_idx = $this->request->data['order_idx'];
		
		$this->loadModel('Order');
		$check=$this->Order->find('count', array('conditions'=>array('order_idx'=>$order_idx, 'shop_idx'=>$this->Auth->user('shop_idx'))));
		if($check>0){
			$this->Order->save(
				array(
					'order_idx'=>$order_idx,
					'order_status'=>1
				)
			);
			
			//logs
			$this->setLog($order_idx,'franchises_order_complete');
		
			return $this->redirect(array('action' => 'history', $order_idx));
		}else{
			$this->flash('Please check your permission', 'index');
		}
	}
	
	public function history($order_idx=null){
		$this->set('current_page', 'history');
		
		$this->loadModel('Order');
		$fields=array('Order.order_idx', 'Order.created', 'Order.order_status', 'Shop.shop_title, Member.mem_id');
		$join=array(array('table' => 'shops',
							'alias' => 'Shop',
							'type' => 'INNER',
							'conditions' => array('Order.shop_idx = Shop.shop_idx')
					),array('table' => 'members',
							'alias' => 'Member',
							'type' => 'INNER',
							'conditions' => array('Order.mem_idx = Member.mem_idx')
					)
				);
		//$this->set('histories', $this->Order->find('all', array('fields'=>$fields, 'joins'=>$join, 'conditions'=>array('Order.shop_idx'=>$this->Auth->user('shop_idx')), 'order'=>'Order.order_idx DESC')));
		$paginate = array(
			'fields'=>$fields, 
			'joins'=>$join, 
			'conditions'=>array('Order.shop_idx'=>$this->Auth->user('shop_idx')),
			'order'=>array('Order.order_idx'=>'DESC'),
			'limit' => 10
		);
		$this->Paginator->settings = $paginate;
		$this->set('histories', $this->Paginator->paginate('Order'));
		
		if($order_idx){
			$fields='OrderProduct.op_idx, OrderProduct.op_order_qty, OrderProduct.op_release_qty, OrderProduct.op_comment, P.pro_name, P.pro_unit, C.cate_title';
			$join=array(array('table' => 'order_products',
								'alias' => 'OrderProduct',
								'type' => 'INNER',
								'conditions' => array('Order.order_idx = OrderProduct.order_idx')
						),array('table' => 'products',
								'alias' => 'P',
								'type' => 'INNER',
								'conditions' => array('OrderProduct.pro_idx = P.pro_idx')
						),array('table' => 'categories',
								'alias' => 'C',
								'type' => 'INNER',
								'conditions' => array('P.cate_idx = C.cate_idx')
						)
					);
			$this->set('detailLists', $this->Order->find('all', array('fields'=>$fields, 'joins'=>$join, 'conditions' => array('Order.shop_idx'=>$this->Auth->user('shop_idx'), 'Order.order_idx' => $order_idx))));
		}else{
			$this->set('detailLists', null);
		}
	}
	
	public function historyDetail($order_idx){
		$this->layout = 'ajax';
		
		$this->loadModel('Order');
		$fields='OrderProduct.op_idx, OrderProduct.op_order_qty, OrderProduct.op_release_qty, OrderProduct.op_comment, P.pro_name, P.pro_unit, C.cate_title';
		$join=array(array('table' => 'order_products',
								'alias' => 'OrderProduct',
								'type' => 'INNER',
								'conditions' => array('Order.order_idx = OrderProduct.order_idx')
						),array('table' => 'products',
							'alias' => 'P',
							'type' => 'INNER',
							'conditions' => array('OrderProduct.pro_idx = P.pro_idx')
					),array('table' => 'categories',
							'alias' => 'C',
							'type' => 'INNER',
							'conditions' => array('P.cate_idx = C.cate_idx')
					)
				);
		$lists=$this->Order->find('all', array('fields'=>$fields, 'joins'=>$join, 'conditions' => array('Order.shop_idx'=>$this->Auth->user('shop_idx'), 'Order.order_idx' => $order_idx)));
		
		$this->set(compact('lists'));
        $this->set('_serialize', array('lists'));
	}
}
?>