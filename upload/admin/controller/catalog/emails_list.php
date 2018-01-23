<?php

class ControllerCatalogEmailsList extends Controller{
 
     public function index($data) {
     	$this->language->load('catalog/emails_list');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/emails_list');

		$this->getList();
     }
    
    protected function getList() {
        
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
        
        if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}


		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('catalog/emails_list', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		$data['emails'] = array();

		$filter_data = array(
			'start'           => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'           => $this->config->get('config_limit_admin')
		);

		$results = $this->model_catalog_emails_list->getEmails($filter_data);

		foreach ($results as $result) {
			$data['emails'][] = array(
				'email_id'      => $result['email_id'],
				'customer_name' => $result['customer_name'],
				'product_id'    => $result['product_id'],
				'product_count' => $result['product_count'],
				'order_cost'    => $result['order_cost'],
				'email_adress'  => $result['email_adress'],
				'phone_number'  => $result['phone_number'],
				'subject'       => $result['subject']
			);
		}
        
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		
		$data['column_name']            = $this->language->get('column_name');
		$data['column_customer_name']   = $this->language->get('column_customer_name');
		$data['column_product_count']   = $this->language->get('column_product_count');
		$data['column_order_price']     = $this->language->get('column_order_price');
		$data['column_customer_phone']  = $this->language->get('column_customer_phone');
		$data['column_product_id']      = $this->language->get('column_product_id');
        $data['column_subject']         = $this->language->get('column_subject');

		$data['token'] = $this->session->data['token'];

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		$url = '';

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$url = '';
    
        $total_emails_count = count($data['emails']);
    
		$pagination = new Pagination();
		$pagination->total = $total_emails_count;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('catalog/emails_list', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($total_emails_count) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($total_emails_count - $this->config->get('config_limit_admin'))) ? $total_emails_count : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $total_emails_count, ceil($total_emails_count / $this->config->get('config_limit_admin')));

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
        
		$this->response->setOutput($this->load->view('catalog/emails_list.tpl', $data));
	    
    }
}