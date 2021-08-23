<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Esparksinc\Customer\Block\Html;

/**
 * Html page header block
 *
 * @api
 * @since 100.0.2
 */
class Header extends \Magento\Framework\View\Element\Template
{
    protected $httpContext;

    public function __construct(
    	\Magento\Framework\View\Element\Template\Context $context,
    	\Magento\Framework\App\Http\Context $httpContext,
        \Magento\Customer\Model\CustomerFactory $customerFactory,
    	array $data = []
    ) {
    	$this->httpContext = $httpContext;
        $this->customerFactory = $customerFactory;
    	parent::__construct($context, $data);
    }
    /**
     * Current template name
     *
     * @var string
     */
    protected $_template = 'Esparksinc_Customer::html/header.phtml';

    /**
     * Retrieve welcome text
     *
     * @return string
     */
    public function getWelcome()
    {
        if (empty($this->_data['welcome'])) {
            $this->_data['welcome'] = $this->_scopeConfig->getValue(
                'design/header/welcome',
                \Magento\Store\Model\ScopeInterface::SCOPE_STORE
            );
        }
        return __($this->_data['welcome']);
    }

    public function getCustomerDetails()
    {
    	$customerId =  $this->httpContext->getValue('customer_id');
        $customer = $this->customerFactory->create()->load($customerId);
        return $customer->getData('customer_status');
    }

    public function getCustomerIsLoggedIn()
    {
    	return (bool)$this->httpContext->getValue(\Magento\Customer\Model\Context::CONTEXT_AUTH);
    }
}
