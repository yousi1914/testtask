<?php
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Esparksinc\Customer\Controller\Customer;

use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;
use Magento\Contact\Model\ConfigInterface;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Exception\LocalizedException;
use Psr\Log\LoggerInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\DataObject;

class Post extends \Magento\Contact\Controller\Index implements HttpPostActionInterface
{
    /**
     * @var Context
     */
    private $context;

    protected $httpContext;

    protected $customerFactory;


    public function __construct(
        Context $context,
        ConfigInterface $contactsConfig,
        \Magento\Framework\App\Http\Context $httpContext,
        \Magento\Customer\Model\CustomerFactory $customerFactory
    ) {
        parent::__construct($context, $contactsConfig);
        $this->httpContext = $httpContext;
        $this->customerFactory = $customerFactory;
        $this->context = $context;
    }

    /**
     * Post user question
     *
     * @return Redirect
     */
    public function execute()
    {
        try {
            $this->validatedParams();
            $params = $this->getRequest()->getParams();
            $customerId =  $this->httpContext->getValue('customer_id');
            $customerSave = $this->customerFactory->create()->load($customerId);
            
            $customerSave->setCustomerStatus($params['customer_status']);
            $customerSave->save();
            
            $this->messageManager->addSuccessMessage(
                __('Your Status Updated.')
            );
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(
                __('An error occurred while processing your form. Please try again later.')
            );
        }
        return $this->resultRedirectFactory->create()->setPath('status/customer/index');
    }

    /**
     * @return array
     * @throws \Exception
     */
    private function validatedParams()
    {
        $request = $this->getRequest();
        if (trim($request->getParam('customer_status')) === '') {
            throw new LocalizedException(__('Select the status and try again.'));
        }

        return $request->getParams();
    }
}
