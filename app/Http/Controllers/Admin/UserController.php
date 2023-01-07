<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Company;
use App\Enums\UserRoleEnum;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\View;
use function PHPUnit\Framework\isNull;

class UserController extends Controller
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

        View::share('title',ucfirst($this->table));
        View::share('table',$this->table);
    }
    public function index(Request  $request)
    {
        $selectedRole    = $request->get('role');
        $selectedCity    = $request->get('city');
        $selectedCompany = $request->get('company');

        $query = $this->model
        ->with('company:id,name')
        ->latest('id');
        if(!is_null($selectedRole)){
            $query->where('role', $selectedRole);
        }
        if(!is_null($selectedCity)){
            $query->where('role', $selectedCity);
        }
        if(!is_null($selectedCompany)){
            $query->whereHas('company', function ($q) use ($selectedCompany) {
                return $q->where('id', $selectedCompany);
            });
        }
        $data = $query->paginate()  ->appends($request->all());

        $roles = UserRoleEnum::asArray();
        $companies = Company::query()
            ->get([
                'id',
                'name',
            ]);
            $cities = $this->model->clone()
            ->distinct()
            ->limit(10)
            ->whereNotNull('city')
            ->pluck('city');
        return view("admin.$this->table.index",[
            'data'=>$data,
            'roles'=>$roles,
            'cities'=>$cities,
            'companies'=>$companies,
            'selectedCompany'=>$selectedCompany,
            'selectedRole'=>request('role'),
            'selectedCity'=>$selectedCity
        ]);
    }
    public function show()
    {
        echo "show";
    }
    public function destroy($userId)
    {
        User::destroy($userId);
        return redirect()->back();
    }
}
