<?php

namespace App\Http\Controllers\Applicant;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Support\Facades\DB;

class HomePageController extends Controller
{
    public function index()
    {
    //    dd(session()->get('locale'));
    //    app()->setLocale('vi');
         $posts = Post::query()->with([
             'language',
             'company'=>function($q)
             {
                 return $q->select([
                     'id',
                     'name',
                     'logo'
                 ]);
             }
         ])
        ->latest()->paginate(2);
        // dd(session()->get('locale'));
       return view('applicant.index',compact('posts'));
    }
}
