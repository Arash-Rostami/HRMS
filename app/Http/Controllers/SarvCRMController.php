<?php

namespace App\Http\Controllers;

use App\Services\CRM\SarvCrmService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class SarvCRMController extends Controller
{
    /**
     * The SarvCrmService instance.
     */
    protected SarvCrmService $sarvCrmService;

    /**
     * Inject the service dependency.
     */
    public function __construct(SarvCrmService $sarvCrmService)
    {
        $this->sarvCrmService = $sarvCrmService;
    }

    /**
     * Handle user login to the CRM.
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        try {
            $token = $this->sarvCrmService->login(
                $credentials['username'],
                $credentials['password']
            );
            $request->session()->put('crm_token', $token);

            return redirect()
                ->route('crm-login')
                ->with('success', 'ورود با موفقیت انجام شد.');
        } catch (\Exception $e) {
            $code = $e->getCode();
            $msg = $code === 401
                ? 'نام کاربری یا رمز عبور اشتباه است.'
                : 'مشکل در اتصال به سرویس؛ لطفاً بعداً دوباره تلاش کنید.';

            return back()
                ->withInput($request->only('username'))
                ->withErrors(['credentials' => $msg]);
        }
    }


    /**
     * Handle user logout from the CRM.
     */
    public function logout(Request $request): Response
    {
        $request->session()->forget('crm_token');

        $request->session()->flash('success', 'خروج با موفقیت انجام شد.');

        return response()
            ->noContent()
            ->withHeaders([
                'HX-Redirect' => route('user.panel')
            ]);
    }

    /**
     * Fetch and display data for a specific module.
     */
    public function index(Request $request): View|RedirectResponse
    {
        if (!$request->session()->has('crm_token')) {
            abort(403, 'Unauthorized Access.');
        }

        $token = $request->session()->get('crm_token');
        $module = $request->get('module');
        $moduleName = $module ?: $request->query('module');

        if (empty($moduleName)) {
            abort(400, 'Module name is required.');
        }

        $limit = $request->get('limit', 10);
        $offset = $request->get('offset', 0);


        $data = collect($this->sarvCrmService->getModuleData(
            $token,
            $module,
            $limit,
            $offset
        ))->map(fn($item) => (array)$item);

        $displayableKeys = $this->getDisplayableKeys($data);

        return view('api.modules', compact('data', 'limit', 'moduleName', 'displayableKeys'));
    }


    /**
     * Add another row to table prior to storing
     */
    public function create(Request $request): Response
    {
        if (!$request->session()->has('crm_token')) {
            abort(403, 'Unauthorized Access.');
        }

        try {
            $token = $request->session()->get('crm_token');
            $module = $request->get('module') ?: $request->query('module');
            $limit = $request->get('limit', 10);
            $offset = $request->get('offset', 0);

            $data = collect(
                $this->sarvCrmService
                    ->getModuleData($token, $module, $limit, $offset)
            )->map(fn($item) => (array)$item);

            $keys = $data->isEmpty()
                ? collect()
                : collect(array_keys($data->first()))
                    ->filter(fn($k) => $data->pluck($k)->filter()->isNotEmpty())
                    ->values();

            return response(
                $this->generateNewRecordRow($keys->all(), $module)
            );
        } catch (\Exception $e) {
            return response(
                '<p>Error: ' . e($e->getMessage()) . '</p>',
                500
            );
        }
    }

    /**
     * Generate new record row HTML
     */
    private function generateNewRecordRow(array $fields, string $moduleName): string
    {
        $cells = [];
        foreach ($fields as $field) {
            if ($field === 'id') {
                continue;
            }

            $placeholder = ucfirst(str_replace('_', ' ', $field));
            $cells[] = sprintf(
                '<td><input type="text" name="%s" placeholder="%s" class="editable-cell-input new-record-input" data-field-name="%s"></td>',
                htmlspecialchars($field, ENT_QUOTES),
                htmlspecialchars($placeholder, ENT_QUOTES),
                htmlspecialchars($field, ENT_QUOTES)
            );
        }

        return sprintf(
            '<tr id="new-record-row" class="new-record-row" style="display: table-row;"><td></td>%s</tr>',
            implode('', $cells)
        );
    }

    protected function getDisplayableKeys($data): array
    {
        if ($data->isEmpty()) return [];

        $processedData = $data->map(fn($item) => (array)$item);

        $firstItemKeys = array_keys($processedData->first());

        return collect($firstItemKeys)->filter(function ($key) use ($processedData) {
            return $processedData->pluck($key)->filter()->isNotEmpty();
        })->values()->all();
    }

    public function update(Request $request)
    {

        return $request;


//        if (!$request->session()->has('crm_token')) {
//            // Abort if no CRM token is present
//            abort(403, 'Unauthorized Access.');
//        }

        // Validate the incoming request for a single field update
//        $validator = Validator::make($request->all(), [
//            'module' => ['required', 'string'],
//            'record_id' => ['required', 'string'], // The ID of the record being updated
//            'field_name' => ['required', 'string'], // The specific field being updated
//            'field_value' => ['nullable', 'string'], // The new value for that field
//        ]);


//        if ($validator->fails()) {
//            // Return with errors if validation fails
//            return back()->withErrors($validator)->withInput()->with('error', 'Validation failed for update.');
//        }
//
//
//
//        $validated = $validator->validated();
//        $token = $request->session()->get('crm_token');
//
//        try {
        // Construct the 'fields' array as expected by the SarvCrmService
        // The Sarv CRM API's 'Save' method expects an associative array of fields to update
//            $fieldsToUpdate = [
//                $validated['field_name'] => $validated['field_value']
//            ];

//            $this->sarvCrmService->updateModuleRecord(
//                $token,
//                $validated['module'],
//                $validated['record_id'],
//                $fieldsToUpdate // Pass the constructed fields array
//            );

        // Return success message. HTMX can swap this into a message area.
//            return back()->with('success', 'Record updated successfully!');
//        } catch (\Exception $e) {
//            // Return error message. HTMX can swap this into a message area.
//            return back()->with('error', 'Failed to update record: ' . $e->getMessage());
//        }
    }
}
