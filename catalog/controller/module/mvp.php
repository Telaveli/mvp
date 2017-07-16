<?php

class ControllerModuleMvp extends Controller {
	private $error = array(); // объявляем переменную - массив с возможными ошибками
	public function index() {

		// მონაცემების მიღება

		$data['mvp'] = array();
		$this->load->model('module/mvp');
		$data['mvp'] = $this->model_module_comments->getAll();

		// ირთვება სლაიდერი, არის თვითონ ოფენ კარდში 
		$this->document->addStyle('catalog/view/javascript/jquery/owl-carousel/owl.carousel.css');
		$this->document->addStyle('catalog/view/javascript/jquery/owl-carousel/owl.transitions.css');
		$this->document->addScript('catalog/view/javascript/jquery/owl-carousel/owl.carousel.min.js');


// передаем данные на отрисовку
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/mvp.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/module/mvp.tpl', $data);
		} else {
			return $this->load->view('default/template/module/mvp.tpl', $data);
		}
	}

}
