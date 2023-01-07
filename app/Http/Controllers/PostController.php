<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\ResponseTrait;
use App\Http\Requests\Post\CheckSlugRequest;
use App\Http\Requests\Post\GenerateSlugRequest;
use Cviebrock\EloquentSluggable\Services\SlugService;

class PostController extends Controller
{
    use ResponseTrait;
    private object $model;

    public function __construct()
    {
        $this->model = Post::query();
    }
    public function index()
    {
        $data = $this->model
            ->latest()
            ->paginate();
        foreach ($data as $key => $val) {
            $val->currency_salary =   $val->CurrencySalaryCode;
            $val->status          = $val->status_name;
        }
        $arr['data']       = $data->getCollection();
        $arr['pagination'] = $data->linkCollection();

        return $this->successResponse($arr);
    }
    public function generateSlug(GenerateSlugRequest $request)
    {
        try {
            $title = $request->get('title');
            $slug  = SlugService::createSlug(Post::class, 'slug', $title);
            return $this->successResponse($slug);
        } catch (Throwable $e) {
            return $this->errorResponse();
        }
    }
    public function checkSlug(CheckSlugRequest $request): JsonResponse
    {
        return $this->successResponse();
    }
}
