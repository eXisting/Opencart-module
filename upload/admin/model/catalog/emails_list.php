<?php
class ModelCatalogEmailsList extends Model {
	
	public function addProduct($data) {
		$this->event->trigger('pre.admin.emails_list.add', $data);
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "emails_list 	SET
			customer_name = '" . $this->db->escape($data['name']) . "', 
			product_id = '" . $this->db->escape($data['product_id']) . "',
			product_count = '" . $this->db->escape($data['count']) . "', 
			order_cost = '" . $this->db->escape($data['cost']) . "', 
			email_adress = '" . $this->db->escape($data['mail']) . "', 
			phone_number = '" . $this->db->escape($data['phone']) . "'"
		);

		$email_id = $this->db->getLastId();

		if (isset($data['keyword'])) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET 
			query = 'mail_id=" . (int)$email_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('emails_list');

		$this->event->trigger('post.admin.emails_list.add', $email_id);

		return $email_id;
	}

    public function getEmail($email_id) {
		$query = $this->db->query("SELECT DISTINCT *, 
		(SELECT keyword FROM " . DB_PREFIX . "url_alias 
		WHERE query = 'email_id=" . (int)$email_id . "') AS keyword ");

		return $query->row;
	}

	public function getEmails($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "emails_list";

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);
		
		return $query->rows;
	}
}