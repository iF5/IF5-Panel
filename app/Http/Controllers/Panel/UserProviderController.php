<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\UserInterface;
use App\Models\User;
use App\Http\Traits\UserTrait;

class UserProviderController extends Controller implements UserInterface
{
    private $user;

    private $totalPerPage = 2;

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
        return 'provider';
    }

    public function getCompanyId()
    {
        return (\Session::has('companyId'))? \Session::get('companyId') : \Auth::user()->companyId;
    }

    public function getProviderId()
    {
        return (\Session::has('providerId'))? \Session::get('providerId') : \Auth::user()->providerId;
    }

    /**
     * @param int $companyId
     * @param int $providerId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function identify($companyId, $providerId)
    {
        \Session::put('companyId', $companyId);
        \Session::put('providerId', $providerId);
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
            ['companyId', '=', $this->getCompanyId()],
            ['providerId', '=', $this->getProviderId()]
        ])->paginate($this->totalPerPage);

        $route = "user-{$this->getRole()}";

        return view('panel.user.list', compact('users', 'route'));
    }

}

