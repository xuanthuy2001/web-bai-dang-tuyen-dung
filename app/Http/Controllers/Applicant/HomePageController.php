<?php

namespace App\Http\Controllers\Applicant;

use App\Enums\SystemCacheKeyEnum;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomePageController extends Controller
{
    /**
     * @throws Exception
     */
    public function index(Request $request)
    {
        $searchCities = $request->get('cities', []);
        $arrCity = getAndCachePostCities();
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

        $posts = $query->paginate();
        // dd(session()->get('locale'));
        return view('applicant.index', [
            'posts' => $posts,
            'arrCity' => $arrCity,
            'searchCities' => $searchCities,
        ]);
    }
}
