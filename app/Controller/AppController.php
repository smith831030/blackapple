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
			'loginRedirect' => array('controller' => 'Admins', 'action' => 'index'),
			'logoutRedirect' => array('controller' => 'Admins', 'action' => 'index')
		)
	);

	public function beforeFilter() {
		//App::uses('FacebookSession', 'Facebook');
		//FacebookSession::setDefaultApplication('238850962958240','f7495d93dddef6510256eca0d901c43b');

		// Pass settings in
		$this->Auth->authenticate = array('Form');
		$this->Auth->authenticate = array(
			'Basic' => array('userModel' => 'BaMember'),
			'Form' => array('userModel' => 'BaMember', 'fields' => array('username' => 'member_id', 'password' => 'member_pwd'))
		);
		$this->Auth->allow();

		App::import('Controller', 'Category');
		$category=new CategoryController;
		$top_categories=$category->get_list();
		$this->set(compact('top_categories'));
	}
}
