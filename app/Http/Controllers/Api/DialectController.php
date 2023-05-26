<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Dialect;
use Illuminate\Http\Request;

class DialectController extends Controller
{
    function index() {
        $dialects  = Dialect::get();
        return $dialects;
    }
}
