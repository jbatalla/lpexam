<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;



class Orders extends Model
{
	protected $fillable = [
      'order_id',
      'customer_id',
      'product_id',
      'product_price',
      'remarks',
      'picking_station',
      'picking_station_distance',
      'payment_status',
      'price',
      'optimum_route'
    ];

      public function customer()
      {
            //return $this->hasOne('customers', 'customer_id');
            return $this->belongsTo('App\Customers', 'customer_id');
      }     

}
