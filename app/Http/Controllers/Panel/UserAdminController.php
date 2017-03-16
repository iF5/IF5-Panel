<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\UserInterface;
use App\Repositories\Panel\UserRepository;
use App\Http\Traits\UserTrait;

class UserAdminController extends Controller implements UserInterface
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
        return 'admin';
    }

    /**
     * @return int
     */
    public function getCompanyId()
    {
        return 0;
    }

    /**
     * @return int
     */
    public function getProviderId()
    {
        return 0;
    }

}

