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
        // Phương thức combine hợp nhất key của một collection với value của một mảng hoặc collection khác:
        $collection1 = collect(['name', 'age']);
        $combined = $collection1->combine(['George', 29]);
        // dd($combined);

        // Phương thức contains xác định xem colletion có bao gồm item đã cho hay không:
        $collection2 = collect(['name' => 'Desk', 'price' => 100]);
        $collection2->contains('Desk'); // true
        $collection2->contains('New York'); // false

        // kiểm tra cặp key-value có tồn tại trong colection hay không
        $collection3 = collect([
            ['product' => 'Desk', 'price' => 200],
            ['product' => 'Chair', 'price' => 100],
        ]);
        $collection3->contains('product', 'Desk'); // true

        // phương thưc except() => loại trừ
        $collection4 = collect(['product_id' => 1, 'name' => 'Desk', 'price' => 100, 'discount' => false]);
        $filtered  = $collection4->except('price')->all();  //array:3 [▼"product_id" => 1"name" => "Desk""discount" => false]


        // phương thức filter truyền vào callback cặp key-value trả về kết quả phù hợp với loggic
        $dataUser = Company::all();
        $filtered = $dataUser->filter(function ($key, $value) {
            return $key->city == "Hà Nội";
        });
        // dd($filtered->all());
        // ở phương thức nếu muốn lấy bản ghi đầu tiên ta co thể chỉ định đến hàm first hoặc ta thực hiện hàm bên dưới để chỉ phải lấy ra 1 bản ghi mà không lấy hết
        $filtered_first = $dataUser->first(function ($key, $value) {
            return $key->city == "Hà Nội";
        });
        // dd($filtered_first);

        $collection = collect([
            ['name' => 'Sally'],
            ['school' => 'Arkansas'],
            ['age' => 28]
        ]);
    }

}
