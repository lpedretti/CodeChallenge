ALTER TABLE `users` ADD `stripe_id` CHAR( 36 ) NOT NULL AFTER `email_token_expires` ,
ADD `first_name` VARCHAR( 100 ) NOT NULL AFTER `stripe_id` ,
ADD `last_name` VARCHAR( 100 ) NOT NULL AFTER `first_name` ,
ADD INDEX ( `stripe_id` , `first_name` , `last_name` ) ;

INSERT INTO `users` (`id`, `username`, `slug`, `password`, `password_token`, `email`, `email_verified`, `email_token`, `email_token_expires`, `stripe_id`, `first_name`, `last_name`, `tos`, `active`, `last_login`, `last_action`, `is_admin`, `role`, `created`, `modified`) VALUES
('53905e6a-f2d4-409b-8595-0ca643a5c7ef', 'admin', 'admin', 'ac15fc52ec038735ef35cb4bd4516688fec136ad', NULL, 'admin@admin.com', 1, '', '2014-06-06 09:11:22', '', 'admin', 'administrator', 1, 1, NULL, NULL, 1, 'registered', '2014-06-05 09:11:22', '2014-06-05 09:11:22');
