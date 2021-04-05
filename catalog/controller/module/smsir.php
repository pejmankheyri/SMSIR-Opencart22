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
	private $call_model = 'model_module_smsir';
	private $module_path = 'module/smsir';
	private $model_class = 'ModelModuleSmsir';
	private $smsir_model;
	
	public function __construct($registry){
		parent::__construct($registry);
		//cross version check and module specific declarations
		if (version_compare(VERSION, '2.3.0.0', '>=')) {
			$this->call_model = 'model_extension_module_smsir';
			$this->module_path = 'extension/module/smsir';
			$this->model_class = 'ModelExtensionModuleSmsir';
		}
		//SMSIR model		 
		$this->load->model($this->module_path);
		//Settings model
		$this->load->model('setting/setting');
		
		$this->smsir_model = $this->{$this->call_model};
	}

	public function onCheckout($data = 0) {
      	if (isset($this->session->data['order_id'])) {
           $order_id = $this->session->data['order_id'];
        } else {
            $order_id = 0;
        } 
		$order_id = $data;

		if ($order_id != 0) {

			$this->smsir_model->SMSIROnCheckout($order_id);
		}
    }

    public function onHistoryChange($order_id, $route = '', $data = '') {
    	if (version_compare(VERSION, '2.2.0.0', ">=") && version_compare(VERSION, '2.3.0.0', "<")) {
    		$order_id = $data;    		
    	} else if(version_compare(VERSION, '2.3.0.0', ">=")){
    		$order_id = $route[0];
    	}

    	//Send SMS when the status order is changed
    	$this->load->model('checkout/order');
		$order_info = $this->model_checkout_order->getOrder($order_id);	
		
		$SMSIR = $this->model_setting_setting->getSetting('SMSIR', $order_info['store_id']);
		
		if(strcmp(VERSION,"2.1.0.1") < 0) {
			$this->library('smsir');
		}

		$LineNumber = $SMSIR['SMSIR']['linenumber'];
		$APIKey = $SMSIR['SMSIR']['apiKey'];
		$SecretKey = $SMSIR['SMSIR']['SecretKey'];
		$apidomain = $SMSIR['SMSIR']['apidomain'];
		@$IsCustomerClubNum = $SMSIR['SMSIR']['IsCustomerClubNum'];

    	if(isset($SMSIR) && ($SMSIR['SMSIR']['Enabled'] == 'yes') && ($SMSIR['SMSIR']['OrderStatusChange']['Enabled'] == 'yes')) {

    		$result = $this->db->query("SELECT count(*) as counter FROM " . DB_PREFIX ."order_history WHERE order_id = ". $order_id);
			if ($order_info['order_status_id'] && $result->row['counter'] > 1 && (!empty($SMSIR['SMSIR']['OrderStatusChange']['OrderStatus']) && (in_array($order_info['order_status_id'], $SMSIR['SMSIR']['OrderStatusChange']['OrderStatus'])))) {
				if(isset($order_info['order_status']))
					$Status = $order_info['order_status'];
				else
					$Status = "";
				
				$language 		= $order_info['language_id'];	
				$last_order_status = $this->smsir_model->getLastOrderStatuses($order_id,$language);
                
                $Status1 =      !empty($last_order_status[1]['name']) ? $last_order_status[1]['name'] : '';
               
                $Status2 =      $Status;
				$original		= array("{SiteName}","{OrderID}","{Status}","{Status1}","{Status2}","{StatusFrom}","{StatusTo}");
				$replace		= array($this->config->get('config_name'), $order_id, $Status,$Status1,$Status2,$Status1, $Status2);

				$Message[] = str_replace($original, $replace, $SMSIR['SMSIR']['OrderStatusChangeText'][$language]);
				$phone = $order_info['telephone'];
				
				$sendCheck[] = $this->smsir_model->sendCheck($phone);
				
				$Mobiles = array();
				$Mobile = array();
				
				foreach($sendCheck as $keys => $values){
					if((SmsIR::is_mobile($values)) || (SmsIR::is_mobile_withouthZero($values))){
						$Mobile[] = doubleval($values);
					}
				}
				$Mobiles = array_unique($Mobile);
				
				if($Mobiles && $Message){
					if((!empty($IsCustomerClubNum)) && ($IsCustomerClubNum == 'on')){
						$SendSingle = SmsIR::sendSingleCustomerClub($apidomain, $APIKey, $SecretKey, $Mobiles, $Message);
					} else {
						$SendSingle = SmsIR::sendSingle($apidomain, $APIKey, $SecretKey, $LineNumber, $Mobiles, $Message);
					}	
				}
			}
		}
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

    public function onRegister() {
    	if (func_num_args() > 1) {
    		$temp_id = !is_array(func_get_arg(1)) ? func_get_arg(1) : func_get_arg(2);
    	} else {
    		$temp_id = func_get_arg(0);
    	}
    	$customer_id = $temp_id;
    
		$this->load->model('setting/setting');

		$SMSIR = $this->model_setting_setting->getSetting('SMSIR', $this->config->get('store_id'));
		if(strcmp(VERSION,"2.1.0.1") < 0) {
			$this->library('smsir');
		}
		
		$LineNumber = $SMSIR['SMSIR']['linenumber'];
		$APIKey = $SMSIR['SMSIR']['apiKey'];
		$SecretKey = $SMSIR['SMSIR']['SecretKey'];
		$apidomain = $SMSIR['SMSIR']['apidomain'];
		@$IsCustomerClubNum = $SMSIR['SMSIR']['IsCustomerClubNum'];

		//Send SMS to the admin when new user is registered
    	if(isset($SMSIR) && ($SMSIR['SMSIR']['Enabled'] == 'yes') && ($SMSIR['SMSIR']['AdminRegister']['Enabled'] == 'yes')) {
			$customer = $this->db->query("SELECT firstname,lastname,telephone FROM `" . DB_PREFIX ."customer` WHERE customer_id = ".(int)$customer_id);

			if ($customer->row) {
				$nameCustomer = $customer->row['firstname']." ".$customer->row['lastname'];
			} else {
				$nameCustomer = '';
			}
				
			$original		= array("{SiteName}","{CustomerName}");
			$replace		= array($this->config->get('config_name'), $nameCustomer);

			$AdminMessage[] = str_replace($original, $replace, $SMSIR['SMSIR']['AdminRegisterText']);

			$adminNumbers = isset($SMSIR['SMSIR']['StoreOwnerPhoneNumber']) ? $SMSIR['SMSIR']['StoreOwnerPhoneNumber'] : array();
						
			$AdminMobiles = array();
			$AdminMobile = array();
			
			foreach($adminNumbers as $key => $value){
				if((SmsIR::is_mobile($value)) || (SmsIR::is_mobile_withouthZero($value))){
					$AdminMobile[] = doubleval($value);
				}
			}
			$AdminMobiles = array_unique($AdminMobile);
			
			if($AdminMobiles && $AdminMessage){
				if((!empty($IsCustomerClubNum)) && ($IsCustomerClubNum == 'on')){
					$AdminSendSingle = SmsIR::sendSingleCustomerClub($apidomain, $APIKey, $SecretKey, $AdminMobiles, $AdminMessage);
				} else {
					$AdminSendSingle = SmsIR::sendSingle($apidomain, $APIKey, $SecretKey, $LineNumber, $AdminMobiles, $AdminMessage);
				}	
			}
		}

		//Send SMS to the user when the registration is successful
		if(isset($SMSIR) && ($SMSIR['SMSIR']['Enabled'] == 'yes') && ($SMSIR['SMSIR']['CustomerRegister']['Enabled'] == 'yes')) {
			$customer = $this->db->query("SELECT firstname,lastname,telephone FROM `" . DB_PREFIX ."customer` WHERE customer_id = ".(int)$customer_id);

			if ($customer->row) {
				$phone = $customer->row['telephone'];
				$nameCustomer = $customer->row['firstname']." ".$customer->row['lastname'];
			} else {
				$phone = '';
				$nameCustomer = '';
			}					
			
			$language 		= $this->config->get('config_language_id');
			$original		= array("{SiteName}","{CustomerName}");
			$replace		= array($this->config->get('config_name'), $nameCustomer);
			
			$UserMessage[] = str_replace($original, $replace, $SMSIR['SMSIR']['CustomerRegisterText'][$language]);
			
			$sendCheck[] = $this->smsir_model->sendCheck($phone);

			$UserMobiles = array();
			$UserMobile = array();
			
			foreach($sendCheck as $keys => $values){
				if((SmsIR::is_mobile($values)) || (SmsIR::is_mobile_withouthZero($values))){
					$UserMobile[] = doubleval($values);
				}
			}
			$UserMobiles = array_unique($UserMobile);
			
			if($UserMobiles && $UserMessage){
				if((!empty($IsCustomerClubNum)) && ($IsCustomerClubNum == 'on')){
					$UserSendSingle = SmsIR::sendSingleCustomerClub($apidomain, $APIKey, $SecretKey, $UserMobiles, $UserMessage);
				} else {
					$UserSendSingle = SmsIR::sendSingle($apidomain, $APIKey, $SecretKey, $LineNumber, $UserMobiles, $UserMessage);
				}	
			}
		}	
    }

    private function log($text) {
		$log = new Log("smsir_error_log.txt");
		$log->write($text);	
	}
}
