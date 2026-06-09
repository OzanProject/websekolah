<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LocaleController extends Controller
{
    public function setLocale($locale)
    {
        $supportedLocales = ['id', 'en', 'ar'];

        if (in_array($locale, $supportedLocales)) {
            Session::put('locale', $locale);
        }

        return redirect()->back();
    }
}
