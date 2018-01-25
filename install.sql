CREATE TABLE IF NOT EXISTS `oc_emails_list` (
      `email_id` int(11) NOT NULL AUTO_INCREMENT,
      `customer_name` varchar(255) NOT NULL,
      `product_id` int(11) NOT NULL,
      `product_count` int(11) NOT NULL,
      `order_cost` double NOT NULL,
      `email_adress` varchar(255) NOT NULL,
      `phone_number`varchar(255) NOT NULL,
      `subject`varchar(255),
      `status` varchar(255),
      PRIMARY KEY (`email_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
