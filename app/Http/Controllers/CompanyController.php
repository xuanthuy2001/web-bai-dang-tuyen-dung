<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\ResponseTrait;
use App\Http\Requests\Company\StoreRequest;

class CompanyController extends Controller
{
    use ResponseTrait;

    private object $model;

    public function __construct()
    {
        $this->model = Company::query();
    }

    public function index(Request $request): JsonResponse
    {
        $data = $this->model
            ->where('name', 'like', '%' . $request->get('q') . '%')
            ->get();

        return $this->successResponse($data);
    }
    public function check($companyName): JsonResponse
    {
        $check = $this->model
            ->where('name', $companyName)
            ->exists();

        return $this->successResponse($check);
    }
    public function store(StoreRequest $request)
    {
        try {
            $arr         = $request->validated();
            // optional: nếu null bỏ qua
            $arr['logo'] = optional($request->file('logo'))->store('company_logo');
            Company::create($arr);
            return $this->successResponse();
        } catch (Throwable $e) {
            $message = '';
            if ($e->getCode() === '23000') {
                $message = 'Duplicate company name';
            }

            return $this->errorResponse($message);
        }
    }
}
