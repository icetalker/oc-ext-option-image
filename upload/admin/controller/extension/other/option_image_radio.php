<?php
class ControllerExtensionOtherOptionImageRadio extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/other/option_image_radio');

		$this->document->setTitle($this->language->get('heading_title'));

		// CSS & JS
        $this->document->addStyle('view/stylesheet/bootstrap-formhelpers/bootstrap-formhelpers.min.css');
        $this->document->addScript('view/javascript/bootstrap-formhelpers/bootstrap-formhelpers.min.js');

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('other_option_image_radio', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/other/option_image_radio', 'user_token=' . $this->session->data['user_token'], true));
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['entry_background_color'] = $this->language->get('entry_background_color'); 
		$data['entry_text_color'] = $this->language->get('entry_text_color'); 

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=other', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/other/option_image_radio', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['action'] = $this->url->link('extension/other/option_image_radio', 'user_token=' . $this->session->data['user_token'], true);

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=other', true);

		if (isset($this->request->post['other_option_image_radio_status'])) {
			$data['other_option_image_radio_status'] = $this->request->post['other_option_image_radio_status'];
		} else {
			$data['other_option_image_radio_status'] = $this->config->get('other_option_image_radio_status');
		}

		if (isset($this->request->post['other_option_image_radio_background_color'])) {
			$data['other_option_image_radio_background_color'] = $this->request->post['other_option_image_radio_background_color'];
		} else {
			$data['other_option_image_radio_background_color'] = $this->config->get('other_option_image_radio_background_color') ?? '#ccbbaa';
		}

		if (isset($this->request->post['other_option_image_radio_text_color'])) {
			$data['other_option_image_radio_text_color'] = $this->request->post['other_option_image_radio_text_color'];
		} else {
			$data['other_option_image_radio_text_color'] = $this->config->get('other_option_image_radio_text_color') ?? '#000000';
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/other/option_image_radio', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/other/option_image_radio')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	public function install() {
		$this->load->model('extension/other/option_image_radio');

		$this->model_extension_other_option_image_radio->install();
	}

	public function uninstall() {
		$this->load->model('extension/other/option_image_radio');

		$this->model_extension_other_option_image_radio->uninstall();
	}

}