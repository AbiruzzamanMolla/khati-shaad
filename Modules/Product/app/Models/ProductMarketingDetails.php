<?php

namespace Modules\Product\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Product\Database\factories\ProductMarketingDetailsFactory;

class ProductMarketingDetails extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];
    
    protected static function newFactory(): ProductMarketingDetailsFactory
    {
        //return ProductMarketingDetailsFactory::new();
    }
}
