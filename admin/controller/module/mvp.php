<?php

class ControllerModuleMvp extends Controller {
	private $error = array(); // объявляем переменную - массив с возможными ошибками
	public function index() {
		$this->load->language('module/mvp');
		$this->document->setTitle($this->language->get('heading_title'));
		// ვარეგისტრირებთ მოდულს
		$this->load->model('setting/setting');
		$data['ok'] = 1;
	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('mvp', $this->request->post);
			$data['ok'] = 2;
			$this->session->data['success'] = $this->language->get('text_success');
			$data['success'] = $this->session->data['success'] ;

		//	$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}
		// ცვლადების ინიციალიზაცია
		//$data['mod_id'] = $this->request->get['module_id'];
		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['table_image'] = $this->language->get('table_image');
		$data['table_name'] = $this->language->get('table_name');
		$data['table_text'] = $this->language->get('table_text');
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['table_header'] = $this->language->get('table_header');
		$data['table_edit'] = $this->language->get('table_edit');
		$data['table_delete'] = $this->language->get('table_delete');
		$data['table_id'] = $this->language->get('table_id');
		$data['token'] = $this->session->data['token'];
		$data['title_add'] = $this->language->get('title_add');
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		// პურის ნათცეცები, საჭიროა მოდულის გასაფორმებლად "როგორც ყველა"
		$data['breadcrumbs'] = array();
		// ვამატებთ თითო თითო ნამცეცს, პირველი ბმული მთავარ გვერდზე
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'), // text_home მთელი ხედვით ხელმისაწვდომია ყველგან
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);
		// ვამატებთ ბმულს მოდულების სიაზე, ჩაწერილია საკუთარ ენის ფაილში
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL')
		);

		// ღილაკები

		$data['action'] = $this->url->link('module/mvp', 'token=' . $this->session->data['token'], 'SSL');

		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		if (isset($this->request->post['mvp_status'])) {
			$data['mvp_status'] = $this->request->post['mvp_status'];
		} else {
			$data['mvp_status'] = $this->config->get('mvp_status');
		}
		// ბაზის გახსნა

		$data['mvp'] = array();
		$this->load->model('mvp/mvp');
// ამ ეტაპზე ვაკომენტარებ
//		$data['mvp'] = $this->model_mvp_mvp->getAll();







		// ადმინის მხარეზე ვუერთებთ ქუდს, მარცხენა კალოკას და ფუტერს
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
// გადავცემთ მონაცემებს რენდერს
		$this->response->setOutput($this->load->view('module/mvp.tpl', $data));
	}
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/mvp')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
	/*
	public function addComment(){

		// получаем значения
		$name = ($this->request->post['name']) ? $this->request->post['name']:'default';
		$image = ($this->request->post['image']) ? $this->request->post['image']:1;
		$text = ($this->request->post['text']) ? $this->request->post['text']:'no comment';
		$id = (isset($this->request->post['id'])) ? $this->request->post['id']:0;
		// массив вывода
		$json = array();
		$json['name']=$name;
		$json['image']=$image;
		$json['text']=$text;
		$this->load->model('mvp/mvp');
		$json['com_id'] = ($id) ? $this->model_mvp_mvp->updateRow($id,$name,$image,$text) : $this->model_mvp_mvp->addNew($name,$image,$text);
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	public function deleteComment(){

		// получаем значения
		$text = ($this->request->post['id']) ? $this->request->post['id'] : 0;
		// массив вывода
		$json = array();
		if (!$text) {
			$json['error'] = 'no id';
		} else {
			$this->load->model('mvp/mvp');
			$json['com_id'] = $this->model_mvp_mvp->deleteRow($text);
		}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	} */

}
