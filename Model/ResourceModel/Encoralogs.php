<?php
namespace Tfscommerce\Customersync\Model\ResourceModel;
class Tfscommercelogs extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
	protected $_TfscommercelogsFactory;
	
	public function __construct(
		\Magento\Framework\Model\ResourceModel\Db\Context $context,
		\Tfscommerce\Customersync\Model\TfscommercelogsFactory $TfscommercelogsFactory
	)
	{
		$this->_TfscommercelogsFactory = $TfscommercelogsFactory;
		parent::__construct($context);
	}
	
	protected function _construct()
	{
		$this->_init('Tfscommerce_logs', 'id');
	}

	public function log($flow,$request,$response) {
		
		$log = $this->_TfscommercelogsFactory->create();
		$log->setApiFlow($flow);
		$log->setRequest($request);
		$log->setResponse($response);
		$log->save();
	}
	
}