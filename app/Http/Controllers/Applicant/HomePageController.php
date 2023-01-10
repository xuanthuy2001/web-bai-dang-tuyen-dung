<?php

namespace App\Http\Controllers\Applicant;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Support\Facades\DB;

class HomePageController extends Controller
{
    public function index()
    {
         $posts = Post::with('language')->paginate();
       return view('applicant.index',compact('posts'));
    }
}
