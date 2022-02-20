<?php

namespace App\Repositories;

use App\Models\PaymentType;

class PaymentTypeRepository extends Repository
{

    /**
     * constructor method
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = new PaymentType();
    }
}
