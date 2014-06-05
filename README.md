Code Challenge: Registration with Credit Card
==================
## Inspiration
Many applications require that credit cards be accepted. Security for this information is of the upmost importance. Most user flows will allow for the creation of a user and of credit cards separately, but sometimes, an application requires that both be submitted at the same time.

## Challenge
Using CakePHP's latest stable build - http://cakephp.org - Stripe's PHP - https://github.com/stripe/stripe-php - and JS - https://stripe.com/docs/stripe.js - libraries and our Payment Manager plugin - https://github.com/asugai/CakePHP-Payment-Manager - create a single page that will register a user and allow the user to enter a credit card at the same time. The user form should have the following fields: first name, last name, email, and password. The credit card form should have: card number, expiration date, cvv2/cvc2.

This user and the credit card information associated with it should be saved to a database - not all fields need to be saved, only those that are required for the user and for us to get enough information to charge that same credit card later using stripe.

Make all fields required and errors should be displayed to the user, especially errors with the credit card.

## Requirements
1. Fork this repository
2. Register for a free stripe.com account and use the sk\_test and pk\_test keys in the application
3. Create a branch with your name
4. Add whatever code is necessary to make your application complete the challenge immediately above. There is no time limit for solving this problem.
5. Make sure to commit your database.
6. When you have made your final commit, submit your code by sending a pull request to this repository.  Also send an email to andre@orainteractive.com to notify of your completion.

## Additional Functionality
1. Install packages with composer.
2. Install and use the Environment Manager plugin - https://github.com/asugai/CakePHP-Environment-Manager - and setup your local environment through it.
3. Install and use the Notification Manager plugin - https://github.com/asugai/CakePHP-Notification-Manager - and send an email to the new user using the NotificationUtility library.

## Configuration
Let's assume you have created the database and have Config/database.php correctly configured
1. Create some symlinks to help composer and Cake to get along
	cd {your root directory, where you ussually have app,lib,and vendors dirs}
	ln -s plugins Plugin
	cd app
	ln -s ../plugins Plugin
2. Update plugins with composer
3. Create users plugin tables
	../lib/Cake/Console/cake schema create users --plugin=Users
4. Add extra fields and admin user
	mysql {your db name} Config/Schema/db_users_stripedata.sql (default admin email and password are admin@admin.com / newadmin )
5. Configure email.php in app/Config (copy email.php.default to email.php and at least change the 'from' in the default transport. Without a proper transport, email notification will throw an exception)
6. Configure default email address in core or bootstrap: Configure::write('App.defaultEmail', 'noreply@admin.com');

## where to start
BASE/users -> register new account

## Limitations
This test does not yet uses notifications plugin.


