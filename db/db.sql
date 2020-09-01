CREATE TABLE `tbl_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_login` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `default_currency` varchar(10) DEFAULT NULL,
  `account_balance` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_UN` (`user_login`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `tbl_transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_kind` char(8) NOT NULL,
  `currency` char(3) NOT NULL,
  `amount` int(11) NOT NULL,
  `balance_after` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `tbl_transactions_FK` (`user_id`),
  CONSTRAINT `tbl_transactions_FK` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
