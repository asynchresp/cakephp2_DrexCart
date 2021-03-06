<?php 

class DrexCartUserManager {
	
	//private $userId;
	private $userdata;
	
	public function loginById($user_id) {
		$this->DrexCartUser = ClassRegistry::init('DrexCart.DrexCartUser');
		$this->DrexCartUser->create();
		
		// find the user
		$user = $this->DrexCartUser->getUserById((int)$user_id);
		
		if ($user) {
			$this->userdata = $user;
			return true;
		} else {
			return false;
		}
	}
	
	public function loginByEmail($email=null, $password=null) {
		$this->DrexCartUser = ClassRegistry::init('DrexCart.DrexCartUser');
		$this->DrexCartUser->create();
		
		// find the user
		$user = $this->DrexCartUser->getUserByEmail($email);
		if ($user) {
			if ($user['DrexCartUser']['password']==md5($password)) {
				$this->userdata = $user;
				
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	public function logout() {
		$this->userdata = null;
	}
	
	
	public function isLoggedIn() {
		return ($this->userdata) ? true : false;
		print_r($this->userdata);
	}
	
	public function getUserId() {
		return $this->userdata['DrexCartUser']['id'];
	}
	

	public function getUserEmail() {
		return $this->userdata['DrexCartUser']['email'];
	}
	
	public function getFullName() {
		return $this->userdata['DrexCartUser']['firstname'] . ' ' . $this->userdata['DrexCartUser']['lastname'];
	}
	
	public function getContactPhone() {
		//return $this->userdata['DrexCartUser']['contact_number'];
	}
	
	public function getBillingAddress() {
		if ($this->userdata['DrexCartUser']['billing_address_id']) {
			$this->DrexCartAddress = ClassRegistry::init('DrexCart.DrexCartAddress');
			$this->DrexCartAddress->create();
			return $this->DrexCartAddress->find('first', array('conditions'=>array('id'=>$this->userdata['DrexCartUser']['billing_address_id'])));
		} else {
			return false;
		}
		
	}
	
	public function getShippingAddress() {
		if ($this->userdata['DrexCartUser']['shipping_address_id']) {
			$this->DrexCartAddress = ClassRegistry::init('DrexCart.DrexCartAddress');
			$this->DrexCartAddress->create();
			return $this->DrexCartAddress->find('first', array('conditions'=>array('id'=>$this->userdata['DrexCartUser']['shipping_address_id'])));
		} else {
			return false;
		}
	
	}
	
	public function getAddresses() {
		$this->DrexCartAddress = ClassRegistry::init('DrexCart.DrexCartAddress');
		$this->DrexCartAddress->create();
		return $this->DrexCartAddress->find('all', array('conditions'=>array('drex_cart_users_id'=>$this->getUserId())));
	}
	
	public function getOrders($limit=null) {
		$this->DrexCartOrder = ClassRegistry::init('DrexCart.DrexCartOrder');
		$this->DrexCartOrder->create();
		return $this->DrexCartOrder->getOrdersByUserId($this->getUserId(), $limit);
	}
	
	public function getUserData() {
		return $this->userdata;
	}
	
	public function getPaymentProfiles() {
		$this->DrexCartGatewayProfile = ClassRegistry::init('DrexCart.DrexCartGatewayProfile');
		$this->DrexCartGatewayProfile->create();
		return $this->DrexCartGatewayProfile->getPaymentProfiles($this->getUserId());
	}
}

?>