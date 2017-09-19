<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\UserInterface;
use App\Repositories\Panel\CompanyRepository;
use App\Repositories\Panel\ProviderRepository;
use App\Repositories\Panel\UserRepository;
use App\Http\Traits\UserTrait;
use App\Services\BreadcrumbService;

class UserProviderController extends Controller implements UserInterface
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
     * @var ProviderRepository
     */
    private $providerRepository;

    /**
     * @var BreadcrumbService
     */
    private $breadcrumbService;

    /**
     *
     */
    use UserTrait;

    public function __construct(
        UserRepository $userRepository,
        CompanyRepository $companyRepository,
        ProviderRepository $providerRepository,
        BreadcrumbService $breadcrumbService
    )
    {
        $this->userRepository = $userRepository;
        $this->companyRepository = $companyRepository;
        $this->providerRepository = $providerRepository;
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
        return 'provider';
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
        return (\Session::has('provider')) ? \Session::get('provider')->id : \Auth::user()->providerId;
    }

    /**
     * Usability of the administrator to identify the content
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function identify($id)
    {
        \Session::put('provider', $this->providerRepository->findById($id));
        return redirect()->route("user-{$this->getRole()}.index");
    }

    /**
     * @param string $location
     * @return array
     */
    protected function getBreadcrumb($location = null)
    {
        if (\Session::has('company') && \Session::has('provider')) {
            $company = \Session::get('company');
            $provider = \Session::get('provider');
            $data = [
                'Clientes' => route('company.index'),
                $company->name => route('company.show', $company->id),
                'Prestadores de servi&ccedil;os' => route('provider.index'),
                $provider->name => route('provider.show', $provider->id)
            ];
        }

        $data['Usu&aacute;rios'] = route("user-{$this->getRole()}.index");
        $data[$location] = null;
        return $this->breadcrumbService->push($data)->get();
    }

}

