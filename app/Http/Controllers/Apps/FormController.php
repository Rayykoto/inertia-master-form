<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FormController extends Controller
{
    //
    public function index()
    {
        
        return Inertia('Apps/Forms/Index', [
            
        ]);
    }
}
