<?php
class ModelCatalogOneClick extends Model {

    public function addOrder($data){
        
        $this->db->query("INSERT INTO " . DB_PREFIX . "emails_list SET
        customer_name = '" . $data['name']  . "',
        product_id = '" . $data['product_id'] . "',
        product_count = '" . $data['count'] . "',
        order_cost = '" . $data['total'] . "',
        email_adress = '" . $data['mail'] . "',
        phone_number = '" . $data['phone'] . "',
        subject = '" . $data['comment'] . "'
        ");
        
        return  $this->db->getLastId();
    }
    
}