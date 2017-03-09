<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\UserInterface;
use App\User;
use App\Http\Traits\UserTrait;

class UserAdminController extends Controller implements UserInterface
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
        return 'admin';
    }

    public function getCompanyId()
    {
        return 0;
    }

    public function getProviderId()
    {
        return 0;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->user
            ->where('role', '=', $this->getRole())
            ->paginate($this->totalPerPage);

        $route = "user-{$this->getRole()}";

        return view('panel.user.list', compact('users', 'route'));
    }

}

