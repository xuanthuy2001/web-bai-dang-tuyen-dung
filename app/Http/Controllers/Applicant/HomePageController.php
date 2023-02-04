<?php

namespace App\Http\Controllers\Applicant;

use Exception;
use App\Models\Post;
use App\Models\Config;
use Illuminate\Http\Request;
use App\Enums\SystemCacheKeyEnum;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class HomePageController extends Controller
{
    /**
     * @throws Exception
     */
    public function index(Request $request)
    {
        $searchCities = $request->get('cities', []);
        $arrCity = getAndCachePostCities();
        $configs = Config::getAndCache(0);
        $minSalary  = $request->get('min_salary', $configs['filter_min_salary']);
        $maxSalary  = $request->get('max_salary', $configs['filter_max_salary']);
        $query = Post::query()->with([
            'language',
            'company' => function ($q) {
                return $q->select([
                    'id',
                    'name',
                    'logo'
                ]);
            }
        ])
            ->latest();

        if (!empty($searchCities)) {
            $query->where(function ($q) use ($searchCities) {
                foreach ($searchCities as $searchCity) {
                    $q->orWhere('city', 'like', '%' . $searchCity . '%');
                }
                $q->orWhereNull('city');
            });
        }
        if ($request->has('min_salary')) {
            $query->where(function ($q) use ($minSalary) {
                $q->orWhere('min_salary', '>=', $minSalary);
                $q->orWhereNull('min_salary');
            });
        }
        if ($request->has('max_salary')) {
            $query->where(function ($q) use ($maxSalary) {
                $q->orWhere('max_salary', '<=', $maxSalary);
                $q->orWhereNull('max_salary');
            });
        }

        $posts = $query->paginate();
        // dd($query->first()->salary);
        // dd(session()->get('locale'));
        return view('applicant.index', [
            'posts' => $posts,
            'arrCity' => $arrCity,
            'searchCities' => $searchCities,
            'configs' => $configs,
            'minSalary' => $minSalary,
            'maxSalary' => $maxSalary
        ]);
    }
}
