<?php
namespace Esparksinc\Customer\Block;

use Magento\Eav\Model\Config;

class Status extends \Magento\Framework\View\Element\Template
{
	protected $httpContext;

	protected $customerFactory;

	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
		\Magento\Framework\App\Http\Context $httpContext,
        \Magento\Customer\Model\CustomerFactory $customerFactory,
		Config $eavConfig
		
		)
	{
		$this->eavConfig = $eavConfig;
		$this->httpContext = $httpContext;
        $this->customerFactory = $customerFactory;
		parent::__construct($context);
	}

	public function getAllStatus(){

        $attribute = $this->eavConfig->getAttribute('customer', 'customer_status');
        $options = $attribute->getSource()->getAllOptions();
        return $options;

    }

	public function getCustomerStatus(){

        $customerId =  $this->httpContext->getValue('customer_id');
        $customer = $this->customerFactory->create()->load($customerId);
        return $customer->getData('customer_status');

    }
}