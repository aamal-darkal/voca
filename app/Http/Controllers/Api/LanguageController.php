<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Language;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    function show(Language $language) {
        $language = Language::find($language);
        return $language;
    }
}
