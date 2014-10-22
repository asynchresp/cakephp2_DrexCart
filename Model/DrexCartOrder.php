<?php


class DrexCartOrder extends DrexCartAppModel {
	public $name = 'DrexCartOrder';
	
	public $validate = array(
			'billing_firstname' => array(
					'rule' => 'notEmpty',
					'message' => 'You must enter a billing first name'
			),
			'billing_lastname' => array(
					'rule'    => 'notEmpty',
					'message' => 'You must enter a billing last name'
			),
			'billing_address1' => array(
					'rule' => 'notEmpty',
					'message' => 'You must enter a billing first name'
			),
			'billing_city' => array(
					'rule'    => 'notEmpty',
					'message' => 'You must enter a billing last name'
			),
			'billing_state' => array(
					'rule' => 'notEmpty',
					'message' => 'You must enter a billing first name'
			),
			'billing_zip' => array(
					'rule'    => 'notEmpty',
					'message' => 'You must enter a billing last name'
			),
			'billing_phone' => array(
					'rule'    => 'notEmpty',
					'message' => 'You must enter a billing last name'
			),
			'shipping_firstname' => array(
					'rule' => 'notEmpty',
					'message' => 'You must enter a billing first name'
			),
			'shipping_lastname' => array(
					'rule'    => 'notEmpty',
					'message' => 'You must enter a billing last name'
			),
			'shipping_address1' => array(
					'rule' => 'notEmpty',
					'message' => 'You must enter a billing first name'
			),
			'shipping_city' => array(
					'rule'    => 'notEmpty',
					'message' => 'You must enter a billing last name'
			),
			'shipping_state' => array(
					'rule' => 'notEmpty',
					'message' => 'You must enter a billing first name'
			),
			'shipping_zip' => array(
					'rule'    => 'notEmpty',
					'message' => 'You must enter a billing last name'
			)
			
				
	);
	
	

	var $belongsTo = array(
			'DrexCartUser' => array(
					'className' => 'DrexCart.DrexCartUser',
					'foreignKey' => 'drex_cart_users_id'
			)
	);
	

	// validation rule
	function identicalFieldValues( $field=array(), $compare_field=null )
	{
		foreach( $field as $key => $value ){
			$v1 = $value;
			$v2 = $this->data[$this->name][ $compare_field ];
			if($v1 !== $v2) {
				return FALSE;
			} else {
				continue;
			}
		}
		return TRUE;
	}
	
	
	public function getOrder($order_id=null, $user_id=null) {
		
		return $this->find('first', array('conditions'=>array('DrexCartOrder.id'=>(int)$order_id, 'DrexCartOrder.drex_cart_users_id'=>(int)$user_id)));
	}
}