<?php

namespace Modules\Product\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductMarketingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function marketingDetails()
    {
        return view('product::products.marketing.index');
    }
}
