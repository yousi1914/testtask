<?php
declare(strict_types=1);

namespace Esparksinc\Customer\Model\Customer\Attribute\Source;

class CustomerStatus extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{

    /**
     * getAllOptions
     *
     * @return array
     */
    public function getAllOptions()
    {
        if ($this->_options === null) {
            $this->_options = [
                ['value' => '1', 'label' => __('Enabled')],
                ['value' => '0', 'label' => __('Disabled')]
            ];
        }
        return $this->_options;
    }
}

