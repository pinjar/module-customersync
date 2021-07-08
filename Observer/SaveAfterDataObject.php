<?php

declare(strict_types=1);

namespace Tfscommerce\Customersync\Observer;

class SaveAfterDataObject implements \Magento\Framework\Event\ObserverInterface
{
	protected $_logger;	
	protected $TfscommerceHelper;
	public function __construct(
	 \Psr\Log\LoggerInterface $logger,
	 \Tfscommerce\Customersync\Helper\Data $TfscommerceHelper
	 ) {        
		$this->_logger = $logger;
		$this->TfscommerceHelper = $TfscommerceHelper;
    }
    public function execute(
        \Magento\Framework\Event\Observer $observer
    ) {
	   $flow = "Customer Save Event";
       $customer = $observer->getCustomerDataObject();
       $customerId = $customer->getId();
	   $this->_logger->info('--customerId event save-'.$customerId);
	   $this->TfscommerceHelper->TfscommerceAPI($customerId,$flow);  
    }
}

