<?php
namespace Tfscommerce\Customersync\Model\ResourceModel\Tfscommercelogs;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	/**
     * Define model & resource model
     */
    protected function _construct() {
        $this->_init(
            'Tfscommerce\Customersync\Model\Tfscommercelogs',
            'Tfscommerce\Customersync\Model\ResourceModel\Tfscommercelogs'
        );
    }

}