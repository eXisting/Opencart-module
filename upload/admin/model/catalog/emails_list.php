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

	public function editEmail($email_id, $data) {
        $sql = "UPDATE " . DB_PREFIX . "emails_list SET 
        status = '" . $this->db->escape($data['status']) . "'
        WHERE email_id = '" . (int)$email_id . "'";

        $this->db->query($sql);
    }

    public function deleteEmail($email_id) {
        $sql = "DELETE FROM " . DB_PREFIX . "emails_list 
        WHERE email_id = '" . (int)$email_id . "'";

	    $this->db->query($sql);
    }

    public function getEmail($email_id) {
		$sql = "SELECT DISTINCT * FROM " . DB_PREFIX . "emails_list WHERE email_id=" . (int)$email_id;
		
        $result = $this->db->query($sql);

		return $result->row;
	}

	public function getEmails($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "emails_list e";

        $sql .= " GROUP BY e.email_id";

        $sort_data = array(
            'e.customer_name',
            'e.email_adress',
            'e.order_cost',
            'e.status',
        );

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= " ORDER BY " . $data['sort'];
        } else {
            $sql .= " ORDER BY e.customer_name";
        }

        if (isset($data['order']) && ($data['order'] == 'DESC')) {
            $sql .= " DESC";
        } else {
            $sql .= " ASC";
        }

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