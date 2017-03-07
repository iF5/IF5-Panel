<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\UserInterface;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Traits\UserTrait;

class UserCompanyController extends Controller implements UserInterface
{
    private $user;

    use UserTrait;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getRole()
    {
        return 'company';
    }

    public function getCompanyId()
    {
        $companyId = Auth::user()->companyId;
        if (Session::has('companyId')) {
            $companyId = Session::get('companyId');
        }

        return $companyId;
    }

    public function getProviderId()
    {
        return 0;
    }

    /**
     * @param $companyId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function identify($companyId)
    {
        Session::put('companyId', $companyId);
        return redirect()->route("user-{$this->getRole()}.index");
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->user->where([
            ['role', '=', $this->getRole()],
            ['companyId', '=', $this->getCompanyId()]
        ])->get();

        $route = "user-{$this->getRole()}";

        return view('panel.user.list', compact('users', 'route'));
    }

}
