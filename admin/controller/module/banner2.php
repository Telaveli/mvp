<?php // объявляем код php 
class ControllerModuleBanner2 extends Controller { // наследуем от класса контроллер, соблюдаем название имени класса. ControllerModule + название файла с большой буквы
	private $error = array(); // объявляем переменную - массив с возможными ошибками

	public function index() { // главная функция, выполняется при вызове контроллера
	//$data['ret'] = print_r ($this->request->post);
		$this->load->language('module/banner2'); // грузим файл языка, расположен в admin/languages/russian/modules
		$this->document->setTitle($this->language->get('heading_title'));  // добавляет $title для возможного использования в tpl файле, связанным с данным контроллером
		$this->load->model('extension/module'); // загружает файл модели module.php который лежит в admin/model/extension/
// блок проверки регистрации модуля
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) { // цикл проверяет такие условия: Задан ли у сервера метод передачи формы посредством POST или нет, а так же возвращает ли функция validate, описанная ниже true . При редактировании модуля не используется, при нажатии кнопку сохранить - сохраняется
			if (!isset($this->request->get['module_id'])) { // проверка, активирован ли модуль
				$this->model_extension_module->addModule('banner2', $this->request->post); // вызывается метод (функция) из файла admin/model/extension/module.php   addModule. Аргументы - имя модуля а так же данные которые получены методом POST
			} else { //если активирован
				$this->model_extension_module->editModule($this->request->get['module_id'], $this->request->post); // записать новые данные модуля в таблицу. 
			}

			$this->session->data['success'] = $this->language->get('text_success');  //написать что настройки ок

			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL')); //перенаправление на страницу с модулями
		} //сохрание модуля окончено

		// определяем текстовые переменные, которые можно передать в tpl 
		
		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_banner'] = $this->language->get('entry_banner');
		$data['entry_width'] = $this->language->get('entry_width');
		$data['entry_height'] = $this->language->get('entry_height');
		$data['entry_status'] = $this->language->get('entry_status');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		// предупреждения, сработают если нажата кнопка сохранить, но не прошло валидацию
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}

		if (isset($this->error['width'])) {
			$data['error_width'] = $this->error['width'];
		} else {
			$data['error_width'] = '';
		}

		if (isset($this->error['height'])) {
			$data['error_height'] = $this->error['height'];
		} else {
			$data['error_height'] = '';
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
		// ссылка на добавление видимо еще одного модуля
		if (!isset($this->request->get['module_id'])) { // проверяя id модуля мы смотрм, зарегистрирован ли модуль, если да - выводим его название, в opencart 2 каждый модуль (на главной или другой странице) регистрируется как отдельный модуль в общем списке
			$data['breadcrumbs'][] = array( // в этой ветке условия попадаем на общий модуль (чаще всего для добавления "модулей")
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('module/banner2', 'token=' . $this->session->data['token'], 'SSL')
			);
		} else {
			$data['breadcrumbs'][] = array( // в этой ветке условия попадаем на конкретный модуль, к примеру, размещенный на странице "продукты"
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('module/banner2', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], 'SSL')
			);
		}
		// заполняем переменную $action для файла tpl 
		if (!isset($this->request->get['module_id'])) {
			$data['action'] = $this->url->link('module/banner', 'token=' . $this->session->data['token'], 'SSL');
		} else {
			$data['action'] = $this->url->link('module/banner', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], 'SSL');
		}
		// заполняем переменную $cancel для файла tpl 
		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		// если мы попадаем на модуль из списка модулей - т.е. ссылка на модуль в url, получаем информацию о модуле - по сути настройки.
		if (isset($this->request->get['module_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$module_info = $this->model_extension_module->getModule($this->request->get['module_id']);
		}
		// это блок, который получается при неверной валидации, чтобы оставить значения на месте, а не сбросить.
		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (!empty($module_info)) { //либо если мы открываем его кнопкой редактировать
			$data['name'] = $module_info['name'];
		} else {
			$data['name'] = ''; // выведется для родительского модуля, при создании нового в общем
		}
// здесь используется запись из настроек аналогично предыдущему, в контексте даного модуля - какой номер баннера используется.
		if (isset($this->request->post['banner_id'])) {
			$data['banner_id'] = $this->request->post['banner_id'];
		} elseif (!empty($module_info)) {
			$data['banner_id'] = $module_info['banner_id'];
		} else {
			$data['banner_id'] = '';
		}
// грузим модель, можно грузить сколько нужно, далее видно обращение к конкретной модели
		$this->load->model('design/banner');
// загружена уже не одна модель - пишется имя файла в формате opencarta вместо / ставится _ 
		$data['banners'] = $this->model_design_banner->getBanners();
// проверяем ширину
		if (isset($this->request->post['width'])) {
			$data['width'] = $this->request->post['width'];
		} elseif (!empty($module_info)) {
			$data['width'] = $module_info['width'];
		} else {
			$data['width'] = '';
		}
// высоту 
		if (isset($this->request->post['height'])) {
			$data['height'] = $this->request->post['height'];
		} elseif (!empty($module_info)) {
			$data['height'] = $module_info['height'];
		} else {
			$data['height'] = '';
		}
// проверяем включен ли модуль 
		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($module_info)) {
			$data['status'] = $module_info['status'];
		} else {
			$data['status'] = '';
		}
// подключаем с админской части шапки колонки слева и футера 
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
// передаем данные на отрисовку
		$this->response->setOutput($this->load->view('module/banner2.tpl', $data));
	}
// проверка полей, тут все просто, кому непросто пишите на web-porosya.com
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/banner2')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		if (!$this->request->post['width']) {
			$this->error['width'] = $this->language->get('error_width');
		}

		if (!$this->request->post['height']) {
			$this->error['height'] = $this->language->get('error_height');
		}

		return !$this->error;
	}
}