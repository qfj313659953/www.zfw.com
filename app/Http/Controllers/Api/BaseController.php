<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    protected $pagesize = 1;

    public function __construct()
    {
        $this->pagesize = config('wx.pagesize');
    }




}
