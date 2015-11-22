<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'customers';


	public function getCustomerFullNameAttribute()
	{
        //return FIRST_NAME LAST_NAME (EMAIL ADDRESS) in the dropdown box of customer.
	    return $this->attributes['first_name'] .' '. $this->attributes['last_name'] .' ('.$this->attributes['email'].')';
	}

    public function orders()
    {
        return $this->hasMany(Orders::class);
    }

}
