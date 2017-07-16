<?php

class ControllerModuleComments extends Controller { 
	private $error = array(); // объявляем переменную - массив с возможными ошибками
	public function index() { 
		
		// получение коментов
		
		$data['commets'] = array();
		$this->load->model('module/comments');
		$data['comments'] = $this->model_module_comments->getAll();		
		
		// подключаем слайдер 
		$this->document->addStyle('catalog/view/javascript/jquery/owl-carousel/owl.carousel.css');
		$this->document->addStyle('catalog/view/javascript/jquery/owl-carousel/owl.transitions.css');
		$this->document->addScript('catalog/view/javascript/jquery/owl-carousel/owl.carousel.min.js');
		
		
// передаем данные на отрисовку
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/comments.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/module/comments.tpl', $data);
		} else {
			return $this->load->view('default/template/module/comments.tpl', $data);
		}
	}
		
}
