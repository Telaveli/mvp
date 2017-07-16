<?php

class ControllerModuleComments extends Controller { 
	private $error = array(); // объявляем переменную - массив с возможными ошибками
	public function index() { 
		$this->load->language('module/comments');
		$this->document->setTitle($this->language->get('heading_title'));
		// регистрируем модуль
		$this->load->model('setting/setting');
		$data['ok'] = 1;
	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('comments', $this->request->post);
			$data['ok'] = 2;
			$this->session->data['success'] = $this->language->get('text_success');
			$data['success'] = $this->session->data['success'] ;

		//	$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}
		// определяем переменные 
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
		// хлебные крошки, нужны для оформления модуля "как все"
		$data['breadcrumbs'] = array();
		// Добавляем по одной крошки, сначала ссылка на главную страницу
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'), // text_home по всей видимости доступен отовсюду
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);
		// добавляем ссылку на список с модулями, прописано в своем языковом файле
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL')
		);

		// кнопки
		
		$data['action'] = $this->url->link('module/comments', 'token=' . $this->session->data['token'], 'SSL');

		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		if (isset($this->request->post['comments_status'])) {
			$data['comments_status'] = $this->request->post['comments_status'];
		} else {
			$data['comments_status'] = $this->config->get('comments_status');
		}
		// получение коментов
		
		$data['commets'] = array();
		$this->load->model('comments/comments');
		$data['comments'] = $this->model_comments_comments->getAll();
		
		
		
		
		
		
		
		// подключаем с админской части шапки колонки слева и футера 
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
// передаем данные на отрисовку
		$this->response->setOutput($this->load->view('module/comments.tpl', $data));
	}
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/comments')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
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
		$this->load->model('comments/comments');
		$json['com_id'] = ($id) ? $this->model_comments_comments->updateRow($id,$name,$image,$text) : $this->model_comments_comments->addNew($name,$image,$text);
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
			$this->load->model('comments/comments');
			$json['com_id'] = $this->model_comments_comments->deleteRow($text);
		}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
}
