<?php
namespace Tfscommerce\Customersync\Controller\Adminhtml\Tfscommerce;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Model\ResourceModel\Customer\CollectionFactory;
class Syncapi extends Action
{
   
    protected $filter;   
    protected $customerRepository;
    protected $_logger;	
    protected $customerFactory;
	protected $TfscommerceHelper;
    public function __construct(
        Context $context,
        Filter $filter,
        CustomerRepositoryInterface $customerRepository,
        CollectionFactory $customerFactory,
		\Psr\Log\LoggerInterface $logger,
		\Tfscommerce\Customersync\Helper\Data $TfscommerceHelper
    ) {
        $this->filter = $filter;
        $this->customerRepository = $customerRepository;
        $this->customerFactory = $customerFactory;
		$this->_logger = $logger;
		$this->TfscommerceHelper = $TfscommerceHelper;
        parent::__construct($context);
    }

    public function execute()
    {
		$flow = 'Admin Grid sync';
		try{
			$collection = $this->filter->getCollection($this->customerFactory->create());
			foreach ($collection->getAllIds() as $customerId) {				
				$this->TfscommerceHelper->TfscommerceAPI($customerId,$flow);            
			}
			$this->messageManager->addSuccess(__('A total of %1 record(s) have been synced with API.', $collection->getSize()));        
			$resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
			return $resultRedirect->setPath('customer/index/index');
		}catch(\Exception $e){
			$this->_logger->info($e->getMessage());
		}
    }
	
	
}