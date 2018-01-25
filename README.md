# Opencart-module

## One click order module for Opencart 2.0+

Working with further algortithm:
---
#### XML:
---
* add buttons to product;
* add scripts to .tpl files
* add server code for admin panel;
* add labels for admin views;
---
#### Site side:
---
* on click button "Order" appears form with inputs for order;
* via AJAX post request to server where validate inputs and build e-mail message;
* send it using SMTP(for Opencart v.2.2.0.0) or  default Mail instance (for older versions);
* write note to DB;
* after those actions e-mail message will be in mail boxes of both users ( site admin and customer);
* also admin panel will show order inside "Catalog/Emails" panel;
---
### Admin panel
---
* represents emails list;
* offer user additional functionality such as delete fast order and set it status;
---
