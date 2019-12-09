<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table="customers";
     public function customer_has_invoices() {
        return $this->hasMany('App\Invoice');
    }
}
