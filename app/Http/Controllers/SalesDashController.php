<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SalesDashController extends Controller
{
    public function index()
    {
        $pythonScriptPath = base_path('app/Http/Controllers/crm/sales.py');

        if (File::exists($pythonScriptPath)) {
            // Run the Dash application
            exec('python ' . $pythonScriptPath);


            sleep(15);
            // Dash application started successfully
            return redirect()->away('http://127.0.0.1:8050/'); // Assuming you have a named route for the sales dashboard

        } else {
            return "Python script does not exist.";
        }

    }
}
