<?php
namespace Tfscommerce\Customersync\Controller\Adminhtml\Log;
 
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\App\Action;
 
class Index extends Action
{
    const ADMIN_RESOURCE = 'Tfscommerce_Customersync::apilog';
 
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;
 
    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }
 
    /**
     * Index action
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Tfscommerce_Customersync::apilog');
        $resultPage->addBreadcrumb(__('Tfscommerce'), __('Tfscommerce'));
        $resultPage->addBreadcrumb(__('Manage Tfscommerce Api Logs'), __('Manage Tfscommerce Api Logs'));
        $resultPage->getConfig()->getTitle()->prepend(__('Tfscommerce API Logs'));
        return $resultPage;
    }
}