<?php

class ControllerCatalogEmailsList extends Controller{
 
     public function index($data) {
     	$this->language->load('catalog/emails_list');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/emails_list');

		$this->getList();
     }

    public function edit() {
        $this->language->load('catalog/emails_list');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/emails_list');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_catalog_emails_list->editEmail($this->request->get['email_id'], $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            $this->response->redirect($this->url->link('catalog/emails_list', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }

        $this->getForm();
    }

    public function delete() {
        $this->language->load('catalog/emails_list');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/emails_list');

        if (isset($this->request->post['selected']) && $this->validateDelete()) {

            foreach ($this->request->post['selected'] as $email_id) {
                $this->model_catalog_emails_list->deleteEmail($email_id);
            }

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('catalog/emails_list', 'token=' . $this->session->data['token'], 'SSL'));
        }

        $this->getList();
    }

    protected function getForm() {
        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_form'] = !isset($this->request->get['email_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
        $data['text_processing'] = $this->language->get('text_processing');
        $data['text_finished'] = $this->language->get('text_finished');

        $data['entry_status'] = $this->language->get('entry_status');

        $data['help_keyword'] = $this->language->get('help_keyword');

        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        $url = '';

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
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

        if (!isset($this->request->get['email_id'])) {
            $data['action'] = $this->url->link('catalog/emails_list/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
        } else {
            $data['action'] = $this->url->link('catalog/emails_list/edit', 'token=' . $this->session->data['token'] . '&email_id=' . $this->request->get['email_id'] . $url, 'SSL');
        }

        $data['cancel'] = $this->url->link('catalog/emails_list', 'token=' . $this->session->data['token'] . $url, 'SSL');

        if (isset($this->request->get['email_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $mail_info = $this->model_catalog_emails_list->getEmail($this->request->get['email_id']);
        }

        $data['token'] = $this->session->data['token'];

        if (isset($this->request->post['status'])) {
            $data['status'] = $this->request->post['status'];
        } elseif (!empty($mail_info)) {
            $data['status'] = $mail_info['status'];
        } else {
            $data['status'] = '';
        }

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('catalog/emails_list_form.tpl', $data));
    }

    protected function validateForm() {
        if (!$this->user->hasPermission('modify', 'catalog/emails_list')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if ((utf8_strlen($this->request->post['status']) < 2) || (utf8_strlen($this->request->post['status']) > 64)) {
            $this->error['status'] = $this->language->get('error_name');
        }

        return !$this->error;
    }

    protected function validateDelete() {
        if (!$this->user->hasPermission('modify', 'catalog/emails_list')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        return !$this->error;
    }

    protected function getList() {
        
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'customer_name';
        }

        if (isset($this->request->get['order'])) {
            $order = $this->request->get['order'];
        } else {
            $order = 'ASC';
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

        $data['delete'] = $this->url->link('catalog/emails_list/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

        $filter_data = array(
		    'sort'            => $sort,
            'order'           => $order,
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
				'subject'       => $result['subject'],
                'status'        => $result['status'],
                'edit'          => $this->url->link('catalog/emails_list/edit', 'token=' . $this->session->data['token'] . '&email_id=' . $result['email_id'] . $url, 'SSL')
            );
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm']           = $this->language->get('text_confirm');
		
		$data['column_name']            = $this->language->get('column_name');
		$data['column_customer_name']   = $this->language->get('column_customer_name');
		$data['column_product_count']   = $this->language->get('column_product_count');
		$data['column_order_price']     = $this->language->get('column_order_price');
		$data['column_customer_phone']  = $this->language->get('column_customer_phone');
		$data['column_product_id']      = $this->language->get('column_product_id');
        $data['column_subject']         = $this->language->get('column_subject');
        $data['column_status']          = $this->language->get('column_status');
        $data['column_action']          = $this->language->get('column_action');

        $data['button_edit']            = $this->language->get('button_edit');
        $data['button_delete']          = $this->language->get('button_delete');

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

        if ($order == 'ASC') {
            $url .= '&order=DESC';
        } else {
            $url .= '&order=ASC';
        }

        $data['sort_name'] = $this->url->link('catalog/emails_list', 'token=' . $this->session->data['token'] . '&sort=e.customer_name' . $url, 'SSL');
        $data['sort_email_adress'] = $this->url->link('catalog/emails_list', 'token=' . $this->session->data['token'] . '&sort=e.email_adress' . $url, 'SSL');
        $data['sort_cost'] = $this->url->link('catalog/emails_list', 'token=' . $this->session->data['token'] . '&sort=e.order_cost' . $url, 'SSL');
        $data['sort_status'] = $this->url->link('catalog/emails_list', 'token=' . $this->session->data['token'] . '&sort=e.status' . $url, 'SSL');

        $url = '';

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

        $total_emails_count = count($data['emails']);
    
		$pagination = new Pagination();
		$pagination->total = $total_emails_count;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('catalog/emails_list', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($total_emails_count) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($total_emails_count - $this->config->get('config_limit_admin'))) ? $total_emails_count : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $total_emails_count, ceil($total_emails_count / $this->config->get('config_limit_admin')));

        $data['sort'] = $sort;
        $data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
        
		$this->response->setOutput($this->load->view('catalog/emails_list.tpl', $data));
	    
    }
}