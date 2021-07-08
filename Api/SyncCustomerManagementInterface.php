<?php

declare(strict_types=1);

namespace Tfscommerce\Customersync\Api;

interface SyncCustomerManagementInterface
{

	 /**
     * POST for syncCustomer api
     * @param mixed $param
     * @return array
     */
    public function syncCustomer($param);
}

