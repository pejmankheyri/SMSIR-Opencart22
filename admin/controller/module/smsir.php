<?php

/**
 * 
 * PHP version 5.6.x | 7.x
 * 
 * @category Modules
 * @package OpenCart 2.2
 * @author Pejman Kheyri <pejmankheyri@gmail.com>
 * @copyright 2021 All rights reserved.
 */

class ControllerModuleSmsir extends Controller {

	/**
	 * @property   String $module_path String containing the path expression for SMSIR files.
	 * @property   String $call_model String containing the call to SMSIR model.
	 * @property   ModelExtensisionModuleSmsir $smsir_model Object containing the loaded SMSIR model.
	 */
	private $data = array();
	private $version = '1.0.0';	
	private $call_model = 'model_module_smsir';
	private $module_path = 'module/smsir';
	private $smsir_model;

	/**
	 * SMSIR Controller Constructor
	 * initialize necessary dependencies from the OpenCart framework.
	 */
	public function __construct($registry){
		parent::__construct($registry);
		//cross version check and module specific declarations
		if (version_compare(VERSION, '2.3.0.0', '>=')) {
			$this->call_model = 'model_extension_module_smsir';
			$this->module_path = 'extension/module/smsir';
			$this->model_class = 'ModelExtensionModuleSmsir';
		}
		$this->load->model($this->module_path);
		$this->smsir_model = $this->{$this->call_model};
    	$this->load->language($this->module_path);
    	//Loading framework models
		$this->load->model('setting/store');
        $this->load->model('localisation/language');
        $this->load->model('design/layout');
		$this->load->model('tool/image');
		$this->load->model('setting/setting');
		//Module specific resources
        $this->document->addStyle('view/stylesheet/smsir/smsir.css');
		$this->document->addStyle('view/stylesheet/smsir/select2.css');
		$this->document->addScript('view/javascript/smsir/smsir.js');
		$this->document->addScript('view/javascript/smsir/select2.min.js');
		$this->document->addScript('view/javascript/smsir/charactercounter.js');
		//global module variables
		$this->data['module_path'] = $this->module_path;
		$this->data['catalogURL'] = $this->getCatalogURL();
	    
	}
    public function index() { 
        if(!isset($this->request->get['store_id'])) {
           $this->request->get['store_id'] = 0; 
        }
		$this->document->setTitle($this->language->get('heading_title'));	
        $store = $this->getCurrentStore($this->request->get['store_id']);
		
        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {

            if (!$this->user->hasPermission('modify', $this->module_path)) {
				$this->error['warning'] = $this->language->get('error_permission');
            }

            if (!empty($_POST['OaXRyb1BhY2sgLSBDb21'])) {
                $this->request->post['SMSIR']['LicensedOn'] = $_POST['OaXRyb1BhY2sgLSBDb21'];
            }

            if (!empty($_POST['cHRpbWl6YXRpb24ef4fe'])) {
                $this->request->post['SMSIR']['License'] = json_decode(base64_decode($_POST['cHRpbWl6YXRpb24ef4fe']), true);
            }

            if (!$this->user->hasPermission('modify', $this->module_path)) {
				$this->session->data['error'] = 'You do not have permissions to edit this module!';	
			} else {
				$this->model_setting_setting->editSetting('SMSIR', $this->request->post, $this->request->post['store_id']);
				$this->session->data['success'] = $this->language->get('text_success');	
			}
            $this->response->redirect($this->url->link($this->module_path, 'token=' . $this->session->data['token'].'&store_id='.$store['store_id'], 'SSL'));
        }
		
		$this->data['image'] = 'no_image.jpg';
		$this->data['thumb'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		$this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);

 		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
		
		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		$this->load->model('localisation/order_status');
		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

        $this->data['breadcrumbs']   = array();
        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
        );
        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_module'),
            'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
        );
        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link($this->module_path, 'token=' . $this->session->data['token'], 'SSL'),
        );
		
        $languageVariables = array(
            'entry_code',
            'smsir_panel_credit',
            'smsir_panel_credit_desc',
            'smsir_sms',
            'smsir_Apidomain',
            'smsir_ApiKey',
            'smsir_SecretKey',
            'smsir_Keys_link',
            'smsir_Keys_link_desc',
            'smsir_SecretKey_link_desc',
            'smsir_linenumber',
            'smsir_linenumber_desc',
            'smsir_linenumber_link',
            'smsir_send_to',
            'smsir_choose_users_for_send_sms',
            'smsir_all_customers',
            'smsir_specific_customers',
            'smsir_specific_mobiles',
            'smsir_customers_ordered_specific_products',
            'smsir_customer_groups',
            'smsir_newsletter_users',
            'smsir_all_affiliates',
            'smsir_specific_affiliates',
            'smsir_number',
            'smsir_add',
            'smsir_customer',
            'smsir_auto_complete',
            'smsir_affiliate',
            'smsir_products',
            'smsir_products_desc',
            'smsir_message',
            'smsir_message_desc',
            'smsir_send_message',
            'smsir_sending_messages',
            'smsir_dont_close_windows',
            'smsir_last_sent_to',
            'smsir_sent_messages',
            'smsir_errors',
            'smsir_close',
            'smsir_written_chars',
            'smsir_error_all_fiels_requied',
            'smsir_message_sent_successfuly',
            'smsir_message_sent_with_some_errors',
            'smsir_general',
            'smsir_transactional_sms',
            'smsir_settings',
            'smsir_confirm',
            'smsir_send_sms_to_customers',
            'smsir_send_sms_to_admins',
            'smsir_on_new_order',
            'smsir_on_order_status_change',
            'smsir_on_new_registration',
            'smsir_status',
            'smsir_short_codes',
            'smsir_short_codes_desc',
            'smsir_store_name',
            'smsir_order_id',
            'smsir_order_total',
            'smsir_shipping_address',
            'smsir_shipping_method',
            'smsir_payment_address',
            'smsir_payment_method',
            'smsir_customer_new_order_default_text',
            'smsir_order_status',
            'smsir_select_all',
            'smsir_deselect_all',
            'smsir_which_order_status_send_sms',
            'smsir_status_changed_from',
            'smsir_status_changed_to',
            'smsir_order_status_change_default_text',
            'smsir_customer_name',
            'smsir_new_registration_default_text',
            'smsir_new_order_admin_default_text',
            'smsir_new_registration_admin_default_text',
            'smsir_admins_mobiles',
            'smsir_admins_mobiles_desc',
            'smsir_ifcustomerclubdesc',
            'smsir_all_customer_club',
            'smsir_version',
            'heading_title',
            'error_input_form',
            'entry_yes',
            'entry_no',
            'text_default',
            'text_enabled',
            'text_disabled',
            'text_text',
            'save_changes',
            'button_cancel',
            'text_settings',
            'button_add',
            'button_edit',            
            'button_remove',
            'text_special_duration',
            'smsir_no_number_to_send'
          );
       
        foreach ($languageVariables as $languageVariable) {
            $this->data[$languageVariable] = $this->language->get($languageVariable);
        }
		$this->data['heading_title'] = $this->language->get('heading_title');
        $this->data['stores'] = array_merge(array(0 => array('store_id' => '0', 'name' => $this->config->get('config_name') . ' ' . $this->data['text_default'], 'url' => HTTP_SERVER, 'ssl' => HTTPS_SERVER)), $this->model_setting_store->getStores());
        $this->data['error_warning']          = '';  
        $this->data['languages']    		  = $this->model_localisation_language->getLanguages();
        foreach ($this->data['languages'] as $key => $value) {
			if(version_compare(VERSION, '2.2.0.0', "<")) {
				$this->data['languages'][$key]['flag_url'] = 'view/image/flags/'.$this->data['languages'][$key]['image'];
			} else {
				$this->data['languages'][$key]['flag_url'] = 'language/'.$this->data['languages'][$key]['code'].'/'.$this->data['languages'][$key]['code'].'.png"';
			}
		}
        $this->data['version']                = $this->version;
        $this->data['store']                  = $store;
        $this->data['token']                  = $this->session->data['token'];
        $this->data['action']                 = $this->url->link($this->module_path, 'token=' . $this->session->data['token'], 'SSL');
        $this->data['saveApiKey']             = $this->url->link($this->module_path.'/saveApiKey', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['validatePhoneNumberUrl'] = $this->url->link($this->module_path.'/validatePhone', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['cancel']                 = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['data']                   = $this->model_setting_setting->getSetting('SMSIR', $store['store_id']);
		
		$this->document->addStyle('view/javascript/smsir/jquery/css/ui-lightness/jquery-ui.min.css');
		$this->document->addScript('view/javascript/smsir/jquery/js/jquery-ui.min.js');
		$this->data['status'] = true;
		@$apiKey = $this->data['data']['SMSIR']['apiKey'];

		@$this->data['linenumber'] = $this->data['data']['SMSIR']['linenumber'];	

		$this->data['getcredit'] = $this->GetCredit();
		
		// SMS Bulk Start
		if(strcmp(VERSION,"2.1.0.1") < 0) {
			$this->load->model('sale/customer_group');
			$this->data['customer_groups'] = $this->model_sale_customer_group->getCustomerGroups(0);
			$this->data['customer_autocomplete_url'] = $this->url->link('sale/customer/autocomplete','','SSL');
		} else {
			$this->load->model('customer/customer_group');
			$this->data['customer_groups'] = $this->model_customer_customer_group->getCustomerGroups(0);
			$this->data['customer_autocomplete_url'] = $this->url->link('customer/customer/autocomplete','','SSL');
		}
		// SMS Bulk End

		if(!empty($_SERVER['HTTP_REFERER'])) {
			$referer = $_SERVER['HTTP_REFERER'];
			$url = parse_url($referer);
			
		}
		

        $this->data['header']  					 = $this->load->controller('common/header');
		$this->data['column_left']				= $this->load->controller('common/column_left');
		$this->data['footer']					 = $this->load->controller('common/footer');
        $this->response->setOutput($this->load->view($this->module_path.'.tpl', $this->data));
    }

    public function saveApiKey() {
    	header("Content-Type: application/json", true);
    	if(isset($this->request->get['store_id']) && !empty($this->request->get['api_key'])) {
	    	$data = array(
	    		'store_id' => $this->request->get['store_id'],
	    		'SMSIR' => array (
	    			'apiKey' => $this->request->get['apiKey'],
	    			'linenumber' => $this->request->get['linenumber'],
	    			'SecretKey' => $this->request->get['SecretKey'],
	    			'apidomain' => $this->request->get['apidomain'],
	    			'IsCustomerClubNum' => $this->request->get['IsCustomerClubNum']
	    		)
	    	);

	    	$this->model_setting_setting->editSetting('SMSIR', $data, $data['store_id']);
	    	$result = array(
	    		'status' => 'success',
	    		'redirect_url' => $this->url->link($this->module_path, 'token=' . $this->session->data['token'].'&store_id='.$data['store_id'], 'SSL')
	    	);
	    	
			$this->response->setOutput(json_encode($result));
    	} else {
    		$result = array(
	    		'status' => 'error'
	    	);
	    	$this->response->setOutput(json_encode($result));
    	} 
		
    }

	private function GetCredit(){
		$this->library('smsir');
		$this->load->model('setting/setting');
		$SMSIR = $this->model_setting_setting->getSetting('SMSIR', $this->config->get('store_id'));
		
		@$APIKey = $SMSIR['SMSIR']['apiKey'];
		@$SecretKey = $SMSIR['SMSIR']['SecretKey'];
		@$apidomain = $SMSIR['SMSIR']['apidomain'];
		
		$Credit = SmsIR::GetCredit($apidomain, $APIKey, $SecretKey);
		
		return $Credit;
	}
	
    public function library($library) {
        $file = DIR_SYSTEM . 'library/' . str_replace('../', '', (string)$library) . '.php';

        if (file_exists($file)) {
            include_once($file);
        } else {
            trigger_error('Error: Could not load library ' . $file . '!');
            exit();
        }
    }	
	
    private function getCatalogURL() {
        if (isset($_SERVER['HTTPS']) && (($_SERVER['HTTPS'] == 'on') || ($_SERVER['HTTPS'] == '1'))) {
            $storeURL = HTTPS_CATALOG;
        } else {
            $storeURL = HTTP_CATALOG;
        } 
        return $storeURL;
    }

    private function getServerURL() {
        if (isset($_SERVER['HTTPS']) && (($_SERVER['HTTPS'] == 'on') || ($_SERVER['HTTPS'] == '1'))) {
            $storeURL = HTTPS_SERVER;
        } else {
            $storeURL = HTTP_SERVER;
        } 
        return $storeURL;
    }

    private function getCurrentStore($store_id) {    
        if($store_id && $store_id != 0) {
            $store = $this->model_setting_store->getStore($store_id);
        } else {
            $store['store_id'] = 0;
            $store['name'] = $this->config->get('config_name');
            $store['url'] = $this->getCatalogURL(); 
        }
        return $store;
    }
    
    public function install() {
	    $this->smsir_model->install();
    }

    public function uninstall() {
        $this->smsir_model->uninstall();
    }
	
	public function send() {
		$json = array();
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			if (!$this->user->hasPermission('modify', $this->module_path)) {
				$json['error']['warning'] = $this->language->get('smsir_permission_deniy_action');
			}
			if (!$this->request->post['message']) {
				$json['error']['message'] = $this->language->get('smsir_fill_message_field');
			}
			if (!$json) {
				
				$store_info = $this->model_setting_store->getStore($this->request->post['store_id']);			
				if ($store_info) {
					$store_name = $store_info['name'];
				} else {
					$store_name = $this->config->get('config_name');
				}
				
				if (isset($this->request->get['page'])) {
					$page = $this->request->get['page'];
				} else {
					$page = 1;
				}

				$telephones_total = 0;
				$json['telephones'] = array();
				$telephones = array();
				$json_telephones = array();
				$AllCustomerClub = '';
				
				switch ($this->request->post['to']) {
					case 'telephones':
						$phones = isset($this->request->post['phones']) ? $this->request->post['phones'] : array();
						foreach ($phones as $result) {							
							$telephones[] = $result;							
						}
						break;
					case 'newsletter':
						$customer_data = array(
							'filter_newsletter' => 1,
							'start'             => ($page - 1) * 10
						);
						$telephones_total = $this->smsir_model->getTotalCustomers($customer_data);
						$results = $this->smsir_model->getCustomers($customer_data);
						foreach ($results as $result) {
							$validPhone = $this->smsir_model->sendCheck($result['telephone']);
							if ($validPhone){
								$telephones[] = $validPhone;
							}
						}
						break;
					case 'customer_all':
						$customer_data = array(
							'start'  => ($page - 1) * 10
						);
						$telephones_total = $this->smsir_model->getTotalCustomers($customer_data);
						$results = $this->smsir_model->getCustomers($customer_data);
						foreach ($results as $result) {
							$validPhone = $this->smsir_model->sendCheck($result['telephone']);
							if ($validPhone){
								$telephones[] = $validPhone;
							}

						}						
						break;
					case 'customer_group':
						$customer_data = array(
							'filter_customer_group_id' => $this->request->post['customer_group_id'],
							'start'                    => ($page - 1) * 10
						);
						$telephones_total = $this->smsir_model->getTotalCustomers($customer_data);
						$results = $this->smsir_model->getCustomers($customer_data);
						foreach ($results as $result) {
							$validPhone = $this->smsir_model->sendCheck($result['telephone']);
							if ($validPhone){
								$telephones[] = $validPhone;
							}

						}						
						break;
					case 'customer':
						if (!empty($this->request->post['customer'])) {					
							foreach ($this->request->post['customer'] as $customer_id) {
								$customer_info = $this->smsir_model->getCustomer($customer_id);
								if ($customer_info) {
									$validPhone = $this->smsir_model->sendCheck($customer_info['telephone']);
									if ($validPhone){
										$telephones[] = $validPhone;
									}
									
								}
							}
						}
						break;	
					case 'affiliate_all':
						$affiliate_data = array(
							'start'  => ($page - 1) * 10
						);
						$telephones_total = $this->smsir_model->getTotalAffiliates($affiliate_data);		
						$results = $this->smsir_model->getAffiliates($affiliate_data);
						foreach ($results as $result) {
							$validPhone = $this->smsir_model->sendCheck($result['telephone']);
							if ($validPhone){
								$telephones[] = $validPhone;
							}

						}						
						break;	
					case 'affiliate':
						if (!empty($this->request->post['affiliate'])) {					
							foreach ($this->request->post['affiliate'] as $affiliate_id) {
								$affiliate_info = $this->smsir_model->getAffiliate($affiliate_id);
								if ($affiliate_info) {
									$validPhone = $this->smsir_model->sendCheck($affiliate_info['telephone']);
									if ($validPhone){
										$telephones[] = $validPhone;
									}
								}
							}
						}
						break;											
					case 'product':
						if (isset($this->request->post['product'])) {
							$telephones_total = $this->smsir_model->getTotalTelephonesByProductsOrdered($this->request->post['product']);	
							$results = $this->smsir_model->getTelephonesByProductsOrdered($this->request->post['product'], ($page - 1) * 10, 10);
							foreach ($results as $result) {
								$validPhone = $this->smsir_model->sendCheck($result['telephone']);
								if ($validPhone){
									$telephones[] = $validPhone;
								}
							}
						}
						break;												
					case 'AllCustomerClub':
						$AllCustomerClub = 'ON';
						break;											
				}
				$this->library('smsir');
				foreach($telephones as $key=>$value){
					if((SmsIR::is_mobile($value)) || (SmsIR::is_mobile_withouthZero($value))){
						$json_telephones[] = doubleval($value);
					}
				}
				
				$json['telephones'] = array_unique($json_telephones);
				$json['telephonesTotal'] = $telephones_total;
				
				if (($json['telephones']) || ($AllCustomerClub == 'ON')) {
						$json['success'] = $this->language->get('text_success');
						if($AllCustomerClub == 'ON'){
							$json['AllCustomerClub'] = 'ON';
						}
				} else {
					$json['error']['message'] = $this->language->get('smsir_no_number_to_send');
				}
			}
		}
		$this->response->setOutput(json_encode($json));	
	}
	
	public function SendRequest(){
		$this->library('smsir');
		$this->load->model('setting/setting');
		$SMSIR = $this->model_setting_setting->getSetting('SMSIR', $this->config->get('store_id'));
		
		$Mobiles = array();
		$Mobile = array();
		
		$Messages[] = $_POST['Messages'];
		$type = $_POST['type'];

		$LineNumber = $SMSIR['SMSIR']['linenumber'];
		$APIKey = $SMSIR['SMSIR']['apiKey'];
		$SecretKey = $SMSIR['SMSIR']['SecretKey'];
		$apidomain = $SMSIR['SMSIR']['apidomain'];

		if($type == "AllCustomerClub"){
			$sendToAllCustomerClub = SmsIR::sendToAllCustomerClub($apidomain, $APIKey, $SecretKey, $Messages);

			$result = json_decode($sendToAllCustomerClub);
			if($result){
				if(is_object($result)){
					$resultVars = get_object_vars($result);

					if(is_array($resultVars)){
						@$result_IsSuccessful = $resultVars['IsSuccessful'];
						@$result_Message = $resultVars['Message'];
					}
				}

				if($result_IsSuccessful){
					if($result_IsSuccessful == true){
						$json['success'] = $result_Message;
					} else {
						$json['error'] = $result_Message;
					}	
				} else {
					$json['error'] = $result_Message;
				}
			} else {
				$json['error'] = $this->language->get('smsir_send_request_error');
			}
		} else {
			$MobileNumbers = $_POST['MobileNumbers'];
			@$IsCustomerClubNum = $SMSIR['SMSIR']['IsCustomerClubNum'];
			
			if($MobileNumbers){
				foreach($MobileNumbers as $key=>$value){
					if((SmsIR::is_mobile($value)) || (SmsIR::is_mobile_withouthZero($value))){
						$Mobile[] = doubleval($value);
					}
				}
				$Mobiles = array_unique($Mobile);
				
				if((!empty($IsCustomerClubNum)) && ($IsCustomerClubNum == 'on')){
					$sendSingle = SmsIR::sendSingleCustomerClub($apidomain, $APIKey, $SecretKey, $Mobiles, $Messages);
				} else {
					$sendSingle = SmsIR::sendSingle($apidomain, $APIKey, $SecretKey, $LineNumber, $Mobiles, $Messages);
				}	
				
				$result = json_decode($sendSingle);
				if($result){
					if(is_object($result)){
						$resultVars = get_object_vars($result);

						if(is_array($resultVars)){
							@$result_IsSuccessful = $resultVars['IsSuccessful'];
							@$result_Message = $resultVars['Message'];
						}
					}
					if($result_IsSuccessful){
						if($result_IsSuccessful == true){
							$json['to'] = $Mobiles;
							$json['success'] = $result_Message;
						} else {
							$json['error'] = $result_Message;
						}	
					} else {
						$json['error'] = $result_Message;
					}
				} else {
					$json['error'] = $this->language->get('smsir_send_request_error');
				}
			} else {
				$json['error'] = $this->language->get('smsir_no_mobile');
			}		
		}
		$this->response->setOutput(json_encode($json));	
	}
}
