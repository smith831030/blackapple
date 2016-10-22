<?php
/**
 * ManagersController
 *
 * @author		Smith.Seo(smith831030@gmail.com)
 * @created		16/05/2015
 *
 */
class ManagersController extends AppController {
	public $helpers = array('Html', 'Form', 'Session', 'Text');
	public $components = array('Paginator');
	
	public function beforeFilter() {
		$this->layout = 'managers';
		$this->set('mainPageUrl', '/project');
		
		if(!$this->Auth->loggedIn()){
			return $this->redirect(array('controller'=>'MainPage', 'action'=>'index'));
		}elseif($this->Auth->user('mem_level')!=10){
			return $this->redirect(array('controller'=>'MainPage', 'action'=>'index'));
		}else{
			$this->loadModel('Order');
			$this->set('newOrder', $this->Order->find('count', array('conditions'=>array('Order.order_status=0'))));
		}
	}
	
	public function index() {
		$this->set('current_page', 'main');
	}
	
	public function order($order_idx=null){
		$this->set('current_page', 'order');
		
		$this->set('order_idx', $order_idx);
		
		//order lists
		$fields='Order.order_idx, Order.created, Order.order_status, Shop.shop_title, Member.mem_id';
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
		$this->set('orderLists', $this->Order->find('all', array('fields'=>$fields, 'joins'=>$join, 'conditions'=>array('Order.order_status'=>0), 'order'=>'Order.order_idx DESC')));
		
		//order details
		if($order_idx){
			$fields='Order.order_status, Order.order_code, OrderProduct.op_idx, OrderProduct.op_order_qty, OrderProduct.op_release_qty, OrderProduct.op_comment, OrderProduct.pro_idx, P.pro_name, P.pro_qty, P.pro_unit, P.pro_itemcode, C.cate_title, Shop.shop_title, Shop.shop_address, Shop.shop_contact';
			$join=array(array('table' => 'shops',
								'alias' => 'Shop',
								'type' => 'INNER',
								'conditions' => array('Order.shop_idx = Shop.shop_idx')
						),array('table' => 'order_products',
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
			$this->set('detailLists', $this->Order->find('all', array('fields'=>$fields, 'joins'=>$join, 'conditions' => array('Order.order_idx' => $order_idx))));
		}else{
			$this->set('detailLists', null);
		}
	}
	
	public function orderProcess(){
		$this->set('current_page', 'order');
		$order_idx=$this->request->data['Order']['order_idx'];
		$products=$this->request->data['pro_idx'];
		
		//transaction begin
		$this->Order->begin();
		
		//update orders table
		$this->Order->save(
			array(
				'order_idx'=>$order_idx,
				'order_status' => '4'
			)
		);
		
		foreach($products as $key=>$data){
			$op_idx=$this->request->data['OrderProduct'][$key]['op_idx'];
			$op_release_qty=$this->request->data['OrderProduct'][$key]['op_release_qty'];
			$op_comment=$this->request->data['OrderProduct'][$key]['op_comment'];
			
			//update order_products table
			$op_query="UPDATE os_order_products SET op_release_qty=?, op_comment=? WHERE op_idx=?";
			$this->Order->query($op_query, array($op_release_qty, $op_comment, $op_idx));
			
			//update products table
			$p_query="UPDATE os_products SET pro_qty=pro_qty-? WHERE pro_idx=?";
			$this->Order->query($p_query, array($op_release_qty, $data));
		}
		unset($data);
		
		$this->Order->commit();
		
		//logs
		$this->setLog($order_idx, 'admin_order_complete');
		
		$this->flash('Your order has been completed, thanks', 'index');
		return $this->redirect(array('action' => 'history', $order_idx));
	}
	
	public function orderComplete(){
		$this->set('current_page', 'order');
		
		if($this->request->data){
			$this->Order->save(
				$this->request->data
			);
			$order_idx=$this->Order->id;
			
			$this->flash('Order has been completed', 'index');
			return $this->redirect(array('action'=>'history', $order_idx));
		}
	}
	
	public function orderCancel(){
		$this->set('current_page', 'order');
		
		$this->Order->begin();
		
		//update orders table
		$this->Order->save(
			$this->request->data
		);
		$order_idx=$this->Order->id;
		
		$order_current_status=isset($this->request->data['order_current_status'])?$this->request->data['order_current_status']:0;
		if($order_current_status>0){
			//select order_products table
			$this->loadModel('OrderProduct');
			$op_fields='OrderProduct.op_release_qty, OrderProduct.pro_idx';
			$op_lists = $this->OrderProduct->find('all', array('fields'=>$op_fields, 'conditions'=>array('OrderProduct.order_idx'=>$order_idx)));
			
			//update products table
			$this->loadModel('Product');
			foreach($op_lists as $key=>$data){
				$p_query='UPDATE os_products SET pro_qty=pro_qty+? WHERE pro_idx=?;';
				$this->Product->query($p_query, array($data['OrderProduct']['op_release_qty'], $data['OrderProduct']['pro_idx']));
			}
		}
		$this->Order->commit();
		
		//logs
		if($order_current_status==0)
			$log_type='admin_order_cancel_from_order';
		elseif($order_current_status==1)
			$log_type='admin_order_cancel_from_complete';
		elseif($order_current_status==2)
			$log_type='admin_order_cancel_from_release';
		elseif($order_current_status==4)
			$log_type='admin_order_cancel_from_delivering';
		$this->setLog($order_idx, $log_type);
		
		$this->flash('Cancel has been done', 'index');
		return $this->redirect(array('action'=>'history', $order_idx));
	}
	
	public function orderRecovery(){
		$this->set('current_page', 'history');
		
		$this->Order->begin();
		
		//update orders table
		$this->Order->save(
			$this->request->data
		);
		$order_idx=$this->Order->id;
		
		$order_current_status=isset($this->request->data['order_current_status'])?$this->request->data['order_current_status']:0;
		if($order_current_status>-3){
			//select order_products table
			$this->loadModel('OrderProduct');
			$op_fields='OrderProduct.op_release_qty, OrderProduct.pro_idx';
			$op_lists = $this->OrderProduct->find('all', array('fields'=>$op_fields, 'conditions'=>array('OrderProduct.order_idx'=>$order_idx)));
			
			//update products table
			$this->loadModel('Product');
			foreach($op_lists as $key=>$data){
				$p_query='UPDATE os_products SET pro_qty=pro_qty-? WHERE pro_idx=?;';
				$this->Product->query($p_query, array($data['OrderProduct']['op_release_qty'], $data['OrderProduct']['pro_idx']));
			}
		}
		$this->Order->commit();
		
		//logs
		$this->setLog($order_idx, 'admin_order_recovery');
		
		if($order_current_status==-3)
			$redirect='order';
		else
			$redirect='history';
		
		$this->flash('Cancel has been done', 'index');
		return $this->redirect(array('action'=>$redirect, $order_idx));
	}
	
	public function history($order_idx=null){
		$this->set('current_page', 'history');
		
		$this->set('order_idx', $order_idx);
		if(isset($this->request->query['sorts'])){
			$sort = $this->request->query['sorts'];
			$this->set('sort', $sort);
		}
		
		//Shop list
		$this->loadModel('Shop');
		$fields='Shop.shop_idx, Shop.shop_title';
		$this->set('shops', $this->Shop->find('all', array('fields'=>$fields, 'order'=>'Shop.shop_idx ASC')));
		
		//order lists
		$fields=array('Order.order_idx', 'Order.created', 'Order.order_status', 'Shop.shop_title', 'Member.mem_id');
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

		if(isset($sort))
			$conditions = array('NOT'=>array('Order.order_status'=>0), 'Shop.shop_idx'=>$sort);
		else
			$conditions = array('NOT' => array('Order.order_status'=>0));
			
		$paginate = array(
			'fields'=>$fields, 
			'joins'=>$join, 
			'conditions'=>$conditions, 
			'order'=>array('Order.order_idx'=>'DESC'),
			'limit' => 10
		);
		
		$this->Paginator->settings = $paginate;
		$this->set('orderLists', $this->Paginator->paginate('Order'));
	
		//order details
		if($order_idx){
			$fields='Order.order_status, Order.order_code, OrderProduct.op_idx, OrderProduct.op_order_qty, OrderProduct.op_release_qty, OrderProduct.op_comment, P.pro_name, P.pro_unit, P.pro_itemcode, C.cate_title, Shop.shop_title, Shop.shop_address, Shop.shop_contact';
			$join=array(array('table' => 'shops',
								'alias' => 'Shop',
								'type' => 'INNER',
								'conditions' => array('Order.shop_idx = Shop.shop_idx')
						),array('table' => 'order_products',
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
			$this->set('detailLists', $this->Order->find('all', array('fields'=>$fields, 'joins'=>$join, 'conditions' => array('Order.order_idx' => $order_idx))));
		}else{
			$this->set('detailLists', null);
		}
	}
	
	public function maintenanceStock() {
		$this->set('current_page', 'maintenance');
		
		//Category list
		$this->loadModel('Category');
		$fields='Category.cate_idx, Category.cate_title';
		$this->set('categories', $this->Category->find('all', array('fields'=>$fields, 'order'=>'Category.cate_idx ASC')));
		
		//Product list
		$this->loadModel('Product');
		$fields='Product.pro_idx, Product.cate_idx, Product.pro_name, Product.pro_qty, Product.pro_unit';
		$this->set('products', $this->Product->find('all', array('fields'=>$fields, 'order'=>'Product.cate_idx ASC, Product.pro_name ASC')));
	}
	
	public function maintenanceStockAdd(){
		$orderlist=$this->request->data['orderlist'];
		$op_order_qty=$this->request->data['op_order_qty'];
		
		//insert into orders table
		$this->Order->begin();
		$this->Order->save(
			array(
				'shop_idx' => $this->Auth->user('shop_idx'),
				'mem_idx' => $this->Auth->user('mem_idx'),
				'order_status' => '3'
			)
		);
		$order_idx=$this->Order->id;
		
		//insert into order_products table
		$this->loadModel('OrderProduct');
		$sql="INSERT INTO os_order_products(order_idx, pro_idx, op_order_qty, op_release_qty, op_comment) VALUES ";
		foreach($orderlist as $key=>$data){
			$sql.="($order_idx, '$data', '$op_order_qty[$key]', '$op_order_qty[$key]', 'Added stocks by Admin')";
			if(count($orderlist)-1>$key)
				$sql.=",";
				
		}
		$this->OrderProduct->query($sql);
		
		//update products table
		$this->loadModel('Product');
		foreach($orderlist as $key=>$data){
			$sql="UPDATE os_products SET pro_qty=pro_qty+ ? WHERE pro_idx=?";
			$this->Product->query($sql, array($op_order_qty[$key], $data));
		}
		
		$this->Order->commit();
		
		//logs
		$this->setLog($order_idx, 'admin_add_stocks');
		
		$this->flash('Your order has been completed, thanks', 'index');
		return $this->redirect(array('action' => 'history', $order_idx));
	}
	
	public function maintenanceRelease() {
		$this->set('current_page', 'maintenance');
		
		//Shop list
		$this->loadModel('Shop');
		$fields='Shop.shop_idx, Shop.shop_title';
		$this->set('shops', $this->Shop->find('all', array('fields'=>$fields, 'order'=>'Shop.shop_idx ASC')));
		
		//Category list
		$this->loadModel('Category');
		$fields='Category.cate_idx, Category.cate_title';
		$this->set('categories', $this->Category->find('all', array('fields'=>$fields, 'order'=>'Category.cate_idx ASC')));
		
		//Product list
		$this->loadModel('Product');
		$fields='Product.pro_idx, Product.cate_idx, Product.pro_name, Product.pro_qty, Product.pro_unit';
		$this->set('products', $this->Product->find('all', array('fields'=>$fields, 'order'=>'Product.cate_idx ASC, Product.pro_name ASC')));
	}
	
	public function maintenanceReleaseAdd(){
		$this->set('current_page', 'maintenance');
		
		$this->Order->begin();
		
		//insert orders table
		$this->Order->save(
			array(
				'shop_idx'=>$this->request->data['Order']['shop_idx'],
				'order_status' => '2',
				'mem_idx'=>$this->Auth->user('mem_idx')
			)
		);
		$order_idx=$this->Order->id;
		
		$this->loadModel('Product');
		$this->loadModel('OrderProduct');
		$products=$this->request->data['pro_idx'];
		
		$op_query="INSERT INTO os_order_products (op_order_qty, op_release_qty, pro_idx, order_idx, op_comment) VALUES ";
		foreach($products as $key=>$data){
			$op_order_qty=$this->request->data['op_order_qty'][$key];
			
			//insert order_products table
			$op_query.="($op_order_qty, $op_order_qty, $data, $order_idx, 'Released by Admin')";
			if(count($products)-1>$key)
				$op_query.=",";
			
			//update products table
			$p_query="UPDATE os_products SET pro_qty=pro_qty-? WHERE pro_idx=?";
			$this->Product->query($p_query, array($op_order_qty, $data));
		}
		unset($data);
		$this->OrderProduct->query($op_query);
		
		$this->Order->commit();
		
		//logs
		$this->setLog($order_idx, 'admin_stock_release');
		
		$this->flash('Your order has been completed, thanks', 'index');
		return $this->redirect(array('action' => 'history', $order_idx));
	}
	
	public function MaintenanceStorage(){
		$this->set('current_page', 'maintenance');
				
		//Category list
		$this->loadModel('Category');
		$fields='Category.cate_idx, Category.cate_title';
		$this->set('categories', $this->Category->find('all', array('fields'=>$fields, 'order'=>'Category.cate_idx ASC')));
		
		$this->loadModel('Product');
		//pro_unit list
		$fields='DISTINCT Product.pro_unit';
		$this->set('pro_unit_lists', $this->Product->find('all', array('fields'=>$fields)));
		
		//Product list
		$fields='Product.pro_idx, Product.cate_idx, Product.pro_name, Product.pro_qty, Product.pro_unit';
		$this->set('products', $this->Product->find('all', array('fields'=>$fields, 'order'=>'Product.cate_idx ASC, Product.pro_name ASC')));
	}
	
	public function MaintenanceStorageModify(){
		$this->set('current_page', 'maintenance');
		
		$this->loadModel('Product');
		
		//update products table
		$this->Product->saveMany(
			$this->request->data
		);
		
		//select products table
		$pro_idx=array();
		foreach($this->request->data as $key=>$data){
			$pro_idx[$key]=$data['Product']['pro_idx'];
		}
		$fields = 'Category.cate_title, Product.pro_name, Product.pro_unit';
		$joins = array(array(
						'table'=>'categories',
						'alias'=>'Category',
						'type'=>'INNER',
						'conditions'=>array('Product.cate_idx=Category.cate_idx')
					)
				);
		$lists=$this->Product->find('all', array('fields'=>$fields, 'joins'=>$joins, 'conditions'=>array('Product.pro_idx'=>$pro_idx)));
		$this->set('lists', $lists);
		
		//log
		$this->setLogAdmin('admin_modify_item', $pro_idx);
	}
	
	public function MaintenanceAddNewItem($pro_idx=null){
		$this->set('current_page', 'maintenance');
		
		$this->loadModel('Product');
		$this->loadModel('Category');
		
		//insert product
		if($this->request->data){
			$this->Product->save(
				$this->request->data
			);
			
			//log
			$this->setLogAdmin('admin_add_new_item', $this->Product->id);
			
			$this->flash('Your order has been completed, thanks', 'MaintenanceAddNewItem');
			return $this->redirect(array('action' => 'MaintenanceAddNewItem', $this->Product->id));
		}
		
		if(isset($pro_idx))
			$this->set('pro_idx', $pro_idx);
		
		//pro_unit list
		$fields='DISTINCT Product.pro_unit';
		$this->set('pro_unit_lists', $this->Product->find('all', array('fields'=>$fields)));
		
		//category list
		$fields='Category.cate_idx, Category.cate_title';
		$this->set('categories', $this->Category->find('all', array('fields'=>$fields, 'order'=>'Category.cate_idx ASC')));
		
		unset($this->Product);
	}
	
	public function MaintenanceDeleteItem($pro_idx){
		$this->layout='ajax';
		
		$this->loadModel('Product');
		
		//log
		$this->setLogAdmin('admin_delete_item', $pro_idx);
		
		//delete products
		$this->Product->delete($pro_idx);
		
		$this->flash('Your order has been completed, thanks', 'MaintenanceStorage');
		return $this->redirect(array('action' => 'MaintenanceStorage'));
	}
	
	public function Statistics(){	
		$this->set('current_page', 'statistics');
		
		//Shop list
		$this->loadModel('Shop');
		$fields='Shop.shop_idx, Shop.shop_title';
		$this->set('shops', $this->Shop->find('all', array('fields'=>$fields, 'order'=>'Shop.shop_idx ASC')));
		
		//Search results
		if($this->request->data){
			$startDate=$this->request->data['startDate'];
			$endDate=$this->request->data['endDate'];
			/*
			SELECT
				Product.pro_name, SUM(OrderProduct.op_release_qty) as `released`
			FROM `os_orders` AS Order
			INNER JOIN os_order_products AS OrderProduct
				ON Order.order_idx=OrderProduct.order_idx
			INNER JOIN os_products AS Product
				ON OrderProduct.pro_idx=Product.pro_idx
			WHERE Order.order_status=1 AND
				Order.created BETWEEN '2015-05-01' AND '2015-05-31'
			GROUP BY Product.pro_name
			*/
			
			$fields='Product.pro_name, SUM(OrderProduct.op_release_qty) as `released`';
			$conditions=array('Order.order_status'=>1, 'Order.created BETWEEN ? AND ?'=>array($startDate, $endDate));
			if($this->request->data['Order']['shop_idx']){
				$conditions[2]=array('Order.shop_idx'=>$this->request->data['Order']['shop_idx']);
			}
			$joins=array(array(
							'table'=>'os_order_products',
							'alias'=>'OrderProduct',
							'type'=>'INNER',
							'conditions'=>array('Order.order_idx=OrderProduct.order_idx')
						),array(
							'table'=>'os_products',
							'alias'=>'Product',
							'type'=>'INNER',
							'conditions'=>array('OrderProduct.pro_idx=Product.pro_idx')
						)
					);
			$group=array('Product.pro_name');
			$results = $this->Order->find('all', array('fields'=>$fields, 'conditions'=>$conditions, 'joins'=>$joins, 'group'=>$group));
			$this->set('startDate', $startDate);
			$this->set('endDate', $endDate);
			$this->set('results', $results);
			
		}
	}
}
?>