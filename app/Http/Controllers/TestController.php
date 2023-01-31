<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\File;
use App\Models\Post;
use App\Models\User;
use App\Models\Language;
use App\Enums\FileTypeEnum;
use Illuminate\Http\Request;
use App\Enums\PostStatusEnum;
use Illuminate\Support\Facades\View;

class TestController extends Controller
{
    private object $model;
    private string $table;
    /**
     * Class constructor.
     */
    public function __construct()
    {
        $this->model = User::query();
        $this->table = (new User)->getTable();

        View::share('title', ucfirst($this->table));
        View::share('table', $this->table);
    }
    public function test2()
    {

    }
    public function test()
  {
        dd(Language::query()->get());
  }

}
