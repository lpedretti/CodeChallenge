<?

App::uses('UsersController', 'Users.Controller');
App::uses('PaymentUtility', 'PaymentManager.Lib');

class AppUsersController extends UsersController {
	
	public $uses = array("Users.User");
	
	public function add() {
		$this->Session->write("cardErrors", null);
		if (!empty($this->request->data)) {
			if (!empty($this->request->data["User"]["token"])) {
				$customer = null;
				
				$token = $this->request->data["User"]["token"];
				$description = $this->request->data["User"]["first_name"] . " " . $this->request->data["User"]["last_name"];
				$email = $this->request->data["User"]["email"];
				
				// is there a stripe token? check it out
				$util = new PaymentUtility;
				
				try {
					$customer = $util::createCustomer($description, $token, $email);
				} catch (Exception $e) {
					$this->Session->write("cardErrors", $e->getMessage());
					return;
				}
				if (is_string($customer)) {
					$this->Session->write("cardErrors", $customer);
					return;
				}
				
				$this->request->data["User"]["stripe_id"] = $customer->id;
			}
		}
		
		if (!empty($this->request->data)) {
			$user = $this->{$this->modelClass}->register($this->request->data);
			if ($user !== false) {
				$Event = new CakeEvent(
					'Users.Controller.Users.afterRegistration',
					$this,
					array(
						'data' => $this->request->data,
					)
				);
				$this->getEventManager()->dispatch($Event);
				if ($Event->isStopped()) {
					$this->redirect(array('action' => 'login'));
				}

				$this->_sendVerificationEmail($this->{$this->modelClass}->data);
				$this->Session->setFlash(__d('users', 'Your account has been created. You should receive an e-mail shortly to authenticate your account. Once validated you will be able to login.'));
				$this->redirect(array('action' => 'login'));
			} else {
				unset($this->request->data[$this->modelClass]['password']);
				unset($this->request->data[$this->modelClass]['temppassword']);
				$this->Session->setFlash(__d('users', 'Your account could not be created. Please, try again.'), 'default', array('class' => 'message warning'));
			}
		}
		
	}
	
	public function render($view = null, $layout = null) {
		if (is_null($view)) {
			$view = $this->action;
		}
		$viewPath = substr(get_class($this), 0, strlen(get_class($this)) - 10);
		
		if (!file_exists(APP . 'View' . DS . $viewPath . DS . $view . '.ctp')) {
			$this->plugin = 'Users';
		} else {
			$this->viewPath = $viewPath;
		}
		return parent::render($view, $layout);
	}
}

