<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\UserInterface;
use App\Repositories\Panel\CompanyRepository;
use App\Repositories\Panel\UserRepository;
use App\Http\Traits\UserTrait;
use App\Services\BreadcrumbService;


class UserCompanyController extends Controller implements UserInterface
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var CompanyRepository
     */
    private $companyRepository;

    /**
     * @var BreadcrumbService
     */
    private $breadcrumbService;

    use UserTrait;

    public function __construct(
        UserRepository $userRepository,
        CompanyRepository $companyRepository,
        BreadcrumbService $breadcrumbService
    )
    {
        $this->userRepository = $userRepository;
        $this->companyRepository = $companyRepository;
        $this->breadcrumbService = $breadcrumbService;
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
        return 'company';
    }

    /**
     * @return int
     */
    public function getCompanyId()
    {
        return (\Session::has('company')) ? \Session::get('company')->id : \Auth::user()->companyId;
    }

    /**
     * @return int
     */
    public function getProviderId()
    {
        return 0;
    }

    /**
     * Usability of the administrator to identify the content
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function identify($id)
    {
        \Session::put('company', $this->companyRepository->findById($id));
        return redirect()->route("user-{$this->getRole()}.index");
    }

    /**
     * @param string $location
     * @return array
     */
    protected function getBreadcrumb($location = null)
    {
        if (\Session::has('company')) {
            $company = \Session::get('company');
            $data = [
                'Empresas' => route('company.index'),
                $company->name => route('company.show', $company->id)
            ];
        }

        $data['Usu&aacute;rios'] = route("user-{$this->getRole()}.index");
        $data[$location] = null;
        return $this->breadcrumbService->push($data)->get();
    }

}
