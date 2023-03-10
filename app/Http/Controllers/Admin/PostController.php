<?php

namespace App\Http\Controllers\Admin;

use Throwable;
use App\Models\Post;
use App\Models\Company;
use App\Models\Language;
use App\Imports\PostImport;
use Illuminate\Http\Request;
use App\Models\ObjectLanguage;
use App\Enums\PostRemotableEnum;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;
use App\Enums\ObjectLanguageTypeEnum;
use App\Enums\PostCurrencySalaryEnum;
use App\Http\Controllers\ResponseTrait;
use App\Http\Requests\Post\StoreRequest;
use App\Http\Controllers\SystemConfigController;

class PostController extends Controller
{
    use ResponseTrait;

    private object $model;
    private string $table;

    public function __construct()
    {
        $this->model = Post::query();
        $this->table = (new Post())->getTable();

        View::share('title', ucwords($this->table));
        View::share('table', $this->table);
    }

    public function index()
    {
        return view('admin.posts.index');
    }

    public function create()
    {
        $configs = SystemConfigController::getAndCache();

        return view('admin.posts.create', [
            'currencies' => $configs['currencies'],
            'countries' => $configs['countries'],
        ]);
    }


    public function store(StoreRequest $request)
    {
        // khái niện Transaction: nếu toàn bộ thành công hết thì commit(gửi lên) còn không sẽ quay ngược lại
        DB::beginTransaction();
        try {
            $arr = $request->only([
                'job_title',
                'city',
                "district",
                "min_salary",
                "max_salary",
                "currency_salary",
                "requirement",
                "start_date",
                "end_date",
                "number_applicants",
                "slug",
            ]);
            $companyName = $request->get('company');

            if (!empty($companyName)) {
                $arr['company_id'] = Company::firstOrCreate(['name' => $companyName])->id;
            }
            if ($request->has('remotables')) {
                $remotables = $request->get('remotables');
                if (!empty($remotables['remote']) && !empty($remotables['office'])) {
                    $arr['remotable'] = PostRemotableEnum::DYNAMIC;
                } elseif (!empty($remotables['remote'])) {
                    $arr['remotable'] = PostRemotableEnum::REMOTE_ONLY;
                } else {
                    $arr['remotable'] = PostRemotableEnum::OFFICE_ONLY;
                }
            }
            if ($request->has('can_parttime')) {
                $arr['can_parttime'] = 1;
            }
            $post = Post::create($arr);
            $languages = $request->get('languages');
            foreach ($languages as $language) {
                $language = Language::firstOrCreate(['name' => $language]);
                ObjectLanguage::create([
                    'object_id' => $post->id,
                    'language_id' => $language->id,
                    'object_type' => Post::class,
                ]);
            }

            DB::commit();
            return $this->successResponse();
        } catch (Throwable $e) {
            DB::rollBack();
            return $this->errorResponse($e->getMessage());
        }
    }
}
