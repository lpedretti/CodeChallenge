<?php
/**
 * Application model for CakePHP.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
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
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {
	public function __construct($id = false, $table = null, $ds = null) {
		if (get_class($this) == "User") {
			$this->validate = array(
				'email' => array(
					'isValid' => array(
						'rule' => 'email',
						'required' => true,
						'message' => 'Please enter a valid email address.'),
					'isUnique' => array(
						'rule' => array('isUnique', 'email'),
						'message' => 'This email is already in use.')),
				'password' => array(
					'too_short' => array(
						'rule' => array('minLength', '6'),
						'message' => 'The password must have at least 6 characters.'),
					'required' => array(
						'rule' => 'notEmpty',
						'message' => 'Please enter a password.')),
				'temppassword' => array(
					'rule' => 'confirmPassword',
					'message' => 'The passwords are not equal, please try again.'),
				'tos' => array(
					'rule' => array('custom','[1]'),
					'message' => 'You must agree to the terms of use.'),
				'first_name' => array(
					'required' => array(
						'rule' => array('notEmpty'),
						'required' => true, 'allowEmpty' => false,
						'message' => 'Please enter your first name.'),
					'alpha' => array(
						'rule'    => '/^[a-z0-9 ]{3,}$/i',
						'message' => 'Only letters numbers and spaces, min 3 characters')),
				'last_name' => array(
					'required' => array(
						'rule' => array('notEmpty'),
						'required' => true, 'allowEmpty' => false,
						'message' => 'Please enter your last name.'),
					'alpha' => array(
						'rule'    => '/^[a-z0-9 ]{3,}$/i',
						'message' => 'Only letters, numbers and spaces, min 3 characters'))
			);
		}
		
		parent::__construct($id, $table, $ds);
	}
}
