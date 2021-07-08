<?php

declare(strict_types=1);

namespace Tfscommerce\Customersync\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\Encryption\EncryptorInterface as Encryptor;
class Data extends AbstractHelper
{

	const Tfscommerce_API_PASSWORD = 'customer_sync/general/password';  
	const Tfscommerce_API_ENDPOINTS = 'customer_sync/general/api_endpoint_url';
	const Tfscommerce_API_USERNAME = 'customer_sync/general/api_username';
	protected $_storeManager;
    protected $_scopeConfig; 
    protected $_logger;
	protected $_encryptor;
    public function __construct(
		\Magento\Store\Model\StoreManagerInterface $storeManager,
		\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
		\Psr\Log\LoggerInterface $logger,
		Encryptor $encryptor
	)
   {
	   $this->_storeManager = $storeManager;
	   $this->_scopeConfig = $scopeConfig;
	   $this->_logger = $logger;
	   $this->_encryptor = $encryptor;   
	   
   }
   
   public function getTfscommerceEndpoints(){
	   $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
		return $this->_scopeConfig->getValue(self::Tfscommerce_API_ENDPOINTS,$storeScope);
	}

	public function getTfscommercePassword(){
		$storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
		return $this->_encryptor->decrypt($this->_scopeConfig->getValue(self::Tfscommerce_API_PASSWORD,$storeScope));
	}

	public function getTfscommerceUsername(){
		$storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
		return $this->_scopeConfig->getValue(self::Tfscommerce_API_USERNAME,$storeScope);
	}
	public function getBaseUrl() {	   
	 return  $this->_storeManager->getStore()->getBaseUrl();
   }
   public function TfscommerceAPI($customerId, $flow){
			
		$api_endpoint = $this->getTfscommerceEndpoints();
		$username = $this->getTfscommerceUsername();		
		$password = $this->getTfscommercePassword();
		$postData['username'] = $username;
		$postData['password'] = $password;
		if($api_endpoint == ''){
			$baseUrl = $this->getBaseUrl();
		}		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $baseUrl.'rest/V1/integration/admin/token');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);		
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'Content-Type: application/json',
				'Content-Length: '.strlen(json_encode($postData)),
			)
		);
		
		curl_setopt($ch, CURLOPT_POST, count($postData));
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
		$output = curl_exec($ch);
		curl_close($ch);
		$token = $output;
		
		if (isset($token) && $token != ''){	
				$headers = array(
					'Content-Type: application/json',
					'Authorization: Bearer '.json_decode($token),
				);
				$ch = curl_init();
				$postData = array(
							'param' => array(
									"customer_id" => $customerId,
									"flow" => $flow,
								)
							);
					
				curl_setopt($ch, CURLOPT_URL, $baseUrl.'rest/V1/Tfscommerce-customersync/synccustomer');
				curl_setopt($ch, CURLOPT_POST, count($postData));
				curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers
			);
			 return $output = curl_exec($ch);
		}
		return '';
	}
}

