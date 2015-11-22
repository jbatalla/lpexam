<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products';


	public function getProductShowInfoAttribute()
	{
        //return [BIN_LOCATION] (STOCK_LEVEL) PRODUCT NAME - PRODUCT PRICE in the dropdown box
	    return '['.$this->attributes['bin_location'].'] ('.$this->attributes['stock_level'].') ' .$this->attributes['product_name'] .' - '. $this->attributes['price'] ;
	}    
}
