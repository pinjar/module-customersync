<?php

declare(strict_types=1);

namespace Tfscommerce\Customersync\Model;
use Magento\Customer\Api\CustomerRepositoryInterface;
class SyncCustomerManagement implements \Tfscommerce\Customersync\Api\SyncCustomerManagementInterface
{
	protected $_TfscommerceLogResourceModel;
	protected $customerRepository;
	public function __construct(
		CustomerRepositoryInterface $customerRepository,
		\Tfscommerce\Customersync\Model\ResourceModel\Tfscommercelogs $TfscommerceLogResourceModel
	) {
		$this->customerRepository = $customerRepository;
		$this->_TfscommerceLogResourceModel = $TfscommerceLogResourceModel;
	}

    /**
     * {@inheritdoc}
     */
    public function SyncCustomer($param)
    {
       $paramArr = array();
	   $result =  json_encode($param);
	   $resultSet = json_decode($result,true);
	   $customerId = $resultSet['customer_id'];	
	   $flow = $resultSet['flow'];	   
	    try{
			$customerObj = $this->customerRepository->getById($customerId);
			$this->_TfscommerceLogResourceModel->log($flow,json_encode($param),json_encode($customerObj));
			return json_encode($resultSet,JSON_PRETTY_PRINT);
		}catch(\Exception $e){
			$this->_logger->info($e->getMessage());
		}
	   //die;
    }
}

