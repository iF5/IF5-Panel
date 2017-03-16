<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\UserInterface;
use App\Repositories\Panel\UserRepository;
use App\Http\Traits\UserTrait;

class UserProviderController extends Controller implements UserInterface
{
    private $userRepository;

    use UserTrait;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @return UserRepository
     */
    public function getUser()
    {
        return $this->userRepository
            ->setRole($this->getRole())
            ->setCompanyId($this->getCompanyId())
            ->setProviderId($this->getProviderId());
    }

    /**
     * @return string
     */
    public function getRole()
    {
        return 'provider';
    }

    /**
     * @return int
     */
    public function getCompanyId()
    {
        return (\Session::has('companyId')) ? \Session::get('companyId') : \Auth::user()->companyId;
    }

    /**
     * @return int
     */
    public function getProviderId()
    {
        return (\Session::has('providerId')) ? \Session::get('providerId') : \Auth::user()->providerId;
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

}

