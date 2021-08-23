<?php
namespace Esparksinc\Customer\Controller\Customer;

use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\App\Action\Context;


class Index extends \Magento\Framework\App\Action\Action
{
    protected $httpContext;

    public function __construct(
      Context $context,
        \Magento\Framework\App\Http\Context $httpContext
    ) {
        $this->httpContext = $httpContext;
        $this->context = $context;
        parent::__construct($context);
    }
    /**
  * Index Action*
  * @return void
  */
    public function execute()
    {
        if ($loggedIn = $this->getCustomerIsLoggedIn()) {
            $this->_view->loadLayout();
            $this->_view->renderLayout();
        } 
        else {
            return $this->resultRedirectFactory->create()->setPath('customer/account/login');
        }
    }

    public function getCustomerIsLoggedIn()
    {
        return (bool)$this->httpContext->getValue(\Magento\Customer\Model\Context::CONTEXT_AUTH);
    }
}
