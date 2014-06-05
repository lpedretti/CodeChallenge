<?php
/**
 * Copyright 2010 - 2013, Cake Development Corporation (http://cakedc.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2010 - 2013, Cake Development Corporation (http://cakedc.com)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<div class="users form">
	<h2><?php echo __d('users', 'Add User'); ?></h2>
	<fieldset>
		<?php
			echo $this->Form->create($model);
			
			echo $this->Form->input('first_name', array(
				'label' => __d('users', 'First Name')));
			echo $this->Form->input('last_name', array(
				'label' => __d('users', 'Last Name')));			
			echo $this->Form->input('email', array(
				'label' => __d('users', 'E-mail (used as login)'),
				'error' => array('isValid' => __d('users', 'Must be a valid email address'),
				'isUnique' => __d('users', 'An account with that email already exists'))));
			echo $this->Form->input('password', array(
				'label' => __d('users', 'Password'),
				'type' => 'password'));
			echo $this->Form->input('temppassword', array(
				'label' => __d('users', 'Password (confirm)'),
				'type' => 'password'));
			
			?>
			<div class="input checkbox">
				<? echo $this->Form->checkbox("showcarddetails", ["hiddenField" => false]); ?>
				<label for="UserShowcarddetails">Add my credit card information now</label>
			</div>
			
			<div class="carddetails">
				<?
				echo $this->Form->input('card_number', array(
					'label' => __d('users', 'Card number'), 'data-stripe' => 'number', 'name' => false));
				echo $this->Form->input('cvc', array(
					'label' => __d('users', 'CVC'), 'data-stripe' => 'cvc', 'name' => false));
				?>
				<div class="input text">
					<label for="UserExpirationMonth">Expiration date:</label>
					<?
						$yearopts = [];
						$monthopts = [];
						for ($i = 14; $i < 23; $i++) { $yearopts["$i"] = "$i"; }
						for ($i = 1; $i < 13; $i++) { $monthopts["$i"] = "$i"; }
						echo $this->Form->select("expiration_month", $monthopts, ["name" => false, "data-stripe" => "exp-month", "class" => "displayinline tiny"]);
						echo " / ";
						echo $this->Form->select("expiration_year", $yearopts, ["name" => false, "data-stripe" => "exp-year", "class" => "displayinline tiny"]);
					?>
				</div>
				<div class="payment-errors"><? if (!empty($this->Session->read("cardErrors"))) { print $this->Session->read("cardErrors"); } ?></div>
			</div>
			
			<?
			$tosLink = $this->Html->link(__d('users', 'Terms of Service'), array('controller' => 'pages', 'action' => 'tos', 'plugin' => null));
			echo $this->Form->input('tos', array(
				'label' => __d('users', 'I have read and agreed to ') . $tosLink));
			
			echo $this->Form->input("name", ["type" => "hidden", "data-stripe" => "name"]);
			echo $this->Form->input("token", ["type" => "hidden"]);
			
			$this->Form->unlockField("User.name");
			$this->Form->unlockField("User.token");
			$this->Form->unlockField("User.showcarddetails");
			$this->Form->unlockField("User.card_number");
			$this->Form->unlockField("User.cvc");
			$this->Form->unlockField("User.expiration_month");
			$this->Form->unlockField("User.expiration_year");
			
			echo $this->Form->end(__d('users', 'Submit'));
		?>
	</fieldset>
</div>
<?php echo $this->element('Users.Users/sidebar'); ?>
<script type="text/javascript">
	var stripeResponseHandler = function(status, response) {
		var $form = $('#UserAddForm');

		if (response.error) {
			// Show the errors on the form
			$form.find('.payment-errors').text(response.error.message);
			$form.find('button').prop('disabled', false);
		} else {
			// token contains id, last4, and card type
			var token = response.id;
			// Insert the token into the form so it gets submitted to the server
			$('#UserToken').val(token);
			// and submit
			$form.get(0).submit();
		}
	};
	
	function changeName() {
		$('#UserName').val($('#UserFirstName').val() + ' ' + $('#UserLastName').val());
	}
	
	$(document).ready(function() {
		$('#UserFirstName').change(function() { changeName(); });
		$('#UserLastName').change(function() { changeName(); });
		
		$('#UserShowcarddetails').change(function() {
			if ($(this).is(':checked')) {
				$('.carddetails').show('slow');
			} else {
				$('.carddetails').hide('slow');
				$('#UserCardNumber').val('');
				$('#UserCvc').val('');
				$('#UserExpirationMonth').val('');
				$('#UserExpirationYear').val('');
			}
		});
		
		if ($('#UserShowcarddetails').is(':checked')) {
			$('.carddetails').show('slow');
		}
		
		$('#UserAddForm').submit(function(event) {
			var $form = $(this);
			$form.find('.payment-errors').text('');
			
			// if the user asked to enter the credit card
			if ($('#UserShowcarddetails').is(':checked')) {
				// Disable the submit button to prevent repeated clicks
				$form.find('button').prop('disabled', true);

				Stripe.card.createToken($form, stripeResponseHandler);

				// Prevent the form from submitting with the default action
				return false;
			} else {
				return true;
			}
		});
	});
</script>
