<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Post;
use App\Models\User;
use App\Models\Config;
use App\Models\Company;
use App\Models\Language;
use App\Enums\FileTypeEnum;
use Illuminate\Http\Request;
use App\Enums\PostStatusEnum;
use Illuminate\Cache\CacheManager;
use Illuminate\Support\Facades\View;
use App\Enums\PostCurrencySalaryEnum;
use Illuminate\Support\Facades\Redis;
use PhpParser\Node\Expr\Cast\Double;

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

  public function test()
  {
   
  
  }
}
