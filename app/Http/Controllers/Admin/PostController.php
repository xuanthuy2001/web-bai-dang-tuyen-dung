<?php

namespace App\Http\Controllers\Admin;

use Throwable;
use App\Models\Post;
use App\Imports\PostsImport;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;
use App\Enums\PostCurrencySalaryEnum;
use App\Http\Controllers\ResponseTrait;
use App\Http\Requests\Post\StoreRequest;

class PostController extends Controller
{
    use ResponseTrait;
    private object $model;
    private string $table;
    /**
     * Class constructor.
     */
    public function __construct()
    {
        $this->model = Post::query();
        $this->table = (new Post)->getTable();

        View::share('title', ucfirst($this->table));
        View::share('table', $this->table);
    }
    public function index()
    {

        return view('admin.posts.index');
    }
    public function create()
    {
        $currencies = PostCurrencySalaryEnum::asArray();
        return view('admin.posts.create', [
            'currencies' => $currencies
        ]);
    }
    public function store(StoreRequest $request)
    {
            return ($request ->all());
    }
    public function importCsv(Request $request)
    {

        Excel::import(new PostsImport, $request->file('file'));
        // try {
        //     $levels = $request->input('levels');
        //     $file   = $request->file('file');

        //     Excel::import(new PostsImport($levels), $file);

        //     return $this->successResponse();
        // } catch (Throwable $e) {
        //     return $this->errorResponse();
        // }
    }
}
