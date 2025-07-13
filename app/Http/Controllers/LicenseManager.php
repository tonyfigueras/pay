<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LicenseManager extends Controller
{
    public function registerSchool(Request $request){
        $validatedData = $request->validate([
            'name' => 'required',
        ]);
    }
}
