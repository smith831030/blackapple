<?php
App::uses('AppModel', 'Model');
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');

class BaMember extends AppModel {
	public function beforeSave($options = array()) {
		if (isset($this->data[$this->alias]['member_pwd'])) {
			$passwordHasher = new SimplePasswordHasher();
			$this->data[$this->alias]['member_pwd'] = $passwordHasher->hash(
				$this->data[$this->alias]['member_pwd']
			);
		}
		return true;
	}
}
?>