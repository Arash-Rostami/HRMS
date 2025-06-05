<?php

namespace App\Http\Controllers;

use App\Services\CRM\SARV;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SarvCRMController extends Controller
{
    protected $sarv;

    public function __construct(SARV $sarv)
    {
        $this->sarv = $sarv;
    }

    public function loginCrm(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        if ($username && $password) {
            return $this->sarv->login($request);
        }

        return response()->json(['error' => 'Username and password are required'], 400);
    }

    public function logoutCrm(Request $request)
    {
        $request->session()->forget('crm_token');

        unset($this->sarv->data);

//        gc_collect_cycles();

        return redirect()->route('user.panel');
    }

    public function getModules(Request $request)
    {
        if (!$request->session()->has('crm_token')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $module = $request->input('module');
        if ($module) {
            $response = $this->sarv->getModuleData($request); // Assuming this returns an HTTP response

            if ($response->isOk()) {
                $data = $response->getData(true);
                $keysToShow = [];

                foreach ($data as $item) {
                    foreach ($item as $key => $value) {
                        if (!empty($value) && !isset($keysToShow[$key])) {
                            $keysToShow[$key] = true;
                        }
                    }
                }

                return view('api.modules', compact('data', 'keysToShow'));
            } else {
                $error = "Failed to fetch data: " . $response->status();
                return back()->withErrors(['msg' => $error]);
            }
        }
        return response()->json(['error' => 'Module is required'], 400);
    }
}
