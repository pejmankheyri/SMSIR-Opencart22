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

class SmsIR {
		
	/**
	* gets API Message Send Url.
	*
    * @return string Indicates the Url
	*/
	private static function getAPIMessageSendUrl() {
		return "api/MessageSend";
	}
	
	/**
	* gets Api Token Url.
	*
    * @return string Indicates the Url
	*/
	private static function getApiTokenUrl(){
		return "api/Token";
	}
	
	/**
	* gets Api Credit Url.
	*
    * @return string Indicates the Url
	*/
	private static function getApiCreditUrl(){
		return "api/credit";
	}

	/**
	* gets API Customer Club Add Contact And Send Url.
	*
    * @return string Indicates the Url
	*/
	private static function getAPICustomerClubAddContactAndSendUrl(){
		return "api/CustomerClub/AddContactAndSend";
	}

	/**
	* gets API Customer Club Send To Categories Url.
	*
    * @return string Indicates the Url
	*/
	private static function getAPICustomerClubSendToCategoriesUrl(){
		return "api/CustomerClub/SendToCategories";
	}

	/**
	* send sms with simple web service.
	*
	* @param string $apidomain api domain
	* @param string $APIKey API Key
	* @param string $SecretKey Secret Key
	* @param string $LineNumber Line Number
	* @param MobileNumbers[] $MobileNumbers array structure of mobile numbers
	* @param Messages[] $Messages array structure of messages
    * @return string Indicates the sent sms result
	*/
	public static function sendSingle($apidomain, $APIKey, $SecretKey, $LineNumber, $MobileNumbers, $Messages) {
		
		$token = SmsIR::GetToken($apidomain, $APIKey, $SecretKey);
		if($token != false){
			$postData = array(
				'Messages' => $Messages,
				'MobileNumbers' => $MobileNumbers,
				'LineNumber' => $LineNumber,
				'SendDateTime' => '',
				'CanContinueInCaseOfError' => 'false'
			);
			
			$url = $apidomain.SmsIR::getAPIMessageSendUrl();
			$result = SmsIR::execute($postData, $url, $token);

		} else {
			$result = false;
		}
		return $result;
	}

	/**
	* send sms with customer club web service.
	*
	* @param string $apidomain api domain
	* @param string $APIKey API Key
	* @param string $SecretKey Secret Key
	* @param MobileNumbers[] $MobileNumbers array structure of mobile numbers
	* @param Messages[] $Messages array structure of message
    * @return string Indicates the sent sms result
	*/
	public static function sendSingleCustomerClub($apidomain, $APIKey, $SecretKey, $MobileNumbers, $Messages) {
		
		$token = SmsIR::GetToken($apidomain, $APIKey, $SecretKey);

		if($token != false){
			
			foreach($MobileNumbers as $key => $value){
				$postData[] = array(
					'Prefix' => '',
					'FirstName' => '',
					'LastName' => '',
					'Mobile' => $value,
					'BirthDay' => '',
					'CategoryId' => '',
					'MessageText' => $Messages[0],
				);
			}
			
			$url = $apidomain.SmsIR::getAPICustomerClubAddContactAndSendUrl();
			$result = SmsIR::execute($postData, $url, $token);

		} else {
			$result = false;
		}
		
		return $result;
	}

	/**
	* send sms with customer club to all customer club contacts.
	*
	* @param string $apidomain api domain
	* @param string $APIKey API Key
	* @param string $SecretKey Secret Key
	* @param Messages[] $Messages array structure of message
    * @return string Indicates the sent sms result
	*/
	public static function sendToAllCustomerClub($apidomain, $APIKey, $SecretKey, $Messages) {

		$token = SmsIR::GetToken($apidomain, $APIKey, $SecretKey);
		
		if($token != false){
			$postData = array(
				'Messages' => $Messages[0],
				'contactsCustomerClubCategoryIds' => '',
				'SendDateTime' => '',
				'CanContinueInCaseOfError' => 'false'
			);
			
			$url = $apidomain.SmsIR::getAPICustomerClubSendToCategoriesUrl();
			$result = SmsIR::execute($postData, $url, $token);
			
		} else {
			$result = false;
		}
		return $result;
	}

	/**
	* executes the sms send methods.
	*
	* @param postData[] $postData array of json data
	* @param string $url url
	* @param string $token token string
    * @return string Indicates the curl execute result
	*/
	private static function execute($postData, $url, $token){
		
			$postString = json_encode($postData);

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
												'Content-Type: application/json',
												'x-sms-ir-secure-token: '.$token
												));		
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
			
			$result = curl_exec($ch);
			curl_close($ch);
			
			return $result;
	}
	
	/**
	* gets token key for all web service requests.
	*
	* @param string $apidomain api domain
	* @param string $APIKey API Key
	* @param string $SecretKey Secret Key
    * @return string Indicates the token key
	*/
	private static function GetToken($apidomain, $APIKey, $SecretKey){
		$postData = array(
			'UserApiKey' => $APIKey,
			'SecretKey' => $SecretKey,
			'System' => 'opencart_2_2_v_2_0'
		);
		$postString = json_encode($postData);

		$ch = curl_init($apidomain.SmsIR::getApiTokenUrl());
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                                            'Content-Type: application/json'
                                            ));		
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
		
		$result = curl_exec($ch);
		curl_close($ch);
		
		$response = json_decode($result);
		
		if(is_object($response)){
			$resultVars = get_object_vars($response);
			if(is_array($resultVars)){
				@$IsSuccessful = $resultVars['IsSuccessful'];
				if($IsSuccessful == true){
					@$TokenKey = $resultVars['TokenKey'];
					$resp = $TokenKey;
				} else {
					$resp = false;
				}
			}
		}
		
		return $resp;
	}

	/**
	* gets credit.
	*
	* @param string $apidomain api domain
	* @param string $APIKey API Key
	* @param string $SecretKey Secret Key
    * @return int Indicates the credit
	*/
	public static function GetCredit($apidomain, $APIKey,$SecretKey){

		$token = SmsIR::GetToken($apidomain, $APIKey, $SecretKey);
		if($token != false){

			$ch = curl_init($apidomain.SmsIR::getApiCreditUrl());
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
												'x-sms-ir-secure-token: '.$token
												));		
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
			
			$result = curl_exec($ch);
			curl_close($ch);
			
			$response = json_decode($result);
		
			if(is_object($response)){
				$resultVars = get_object_vars($response);
				if(is_array($resultVars)){
					@$IsSuccessful = $resultVars['IsSuccessful'];
					if($IsSuccessful == true){
						@$Credit = $resultVars['Credit'];
						$resp = $Credit;
					} else {
						$resp = false;
					}
				}
			}

		} else {
			$resp = false;
		}
		return $resp;
	}
	
	/**
	* check if mobile number is valid.
	*
	* @param string $mobile mobile number
    * @return boolean Indicates the mobile validation
	*/
	public static function is_mobile($mobile){
		if(preg_match('/^09(0[1-3]|1[0-9]|3[0-9]|2[0-2]|9[0])-?[0-9]{3}-?[0-9]{4}$/', $mobile)){
			return true;
		} else {
			return false;
		}
	}
	
	/**
	* check if mobile with zero number is valid.
	*
	* @param string $mobile mobile with zero number
    * @return boolean Indicates the mobile with zero validation
	*/
	public static function is_mobile_withouthZero($mobile){
		if(preg_match('/^9(0[1-3]|1[0-9]|3[0-9]|2[0-2]|9[0])-?[0-9]{3}-?[0-9]{4}$/', $mobile)){
			return true;
		} else {
			return false;
		}
	}
}
