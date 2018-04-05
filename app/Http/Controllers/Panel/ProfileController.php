<?php

namespace App\Http\Controllers\Panel;

use App\Http\Traits\LogTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Panel\UserRepository;
use App\Services\BreadcrumbService;

class ProfileController extends Controller
{

    use LogTrait;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var BreadcrumbService
     */
    private $breadcrumbService;

    /**
     * @var array
     */
    private $extensions = ['jpeg', 'jpg', 'png', 'gif'];

    public function __construct(
        UserRepository $userRepository,
        BreadcrumbService $breadcrumbService
    )
    {
        $this->userRepository = $userRepository;
        $this->breadcrumbService = $breadcrumbService;
    }

    /**
     * @return string
     */
    protected function logTitle()
    {
        return 'Perfil';
    }

    /**
     * @return mixed
     */
    protected function getId()
    {
        return \Auth::user()->id;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $user = $this->userRepository->findById($this->getId());

        return view('panel.user.show', [
            'user' => $user,
            'routePrefix' => 'profile',
            'breadcrumbs' => $this->getBreadcrumb()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $id = $this->getId();
        return view('panel.user.form', [
            'user' => $this->userRepository->findById($id),
            'method' => 'PUT',
            'routePrefix' => 'profile',
            'route' => 'profile.update',
            'parameters' => [$id],
            'breadcrumbs' => $this->getBreadcrumb('Editar')
        ]);
    }

    /**
     * @param array $data
     * @return array
     */
    protected function formRequest($data)
    {
        $data['password'] = bcrypt($data['password']);
        return $data;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $this->getId();
        $data = $this->formRequest($request->all());
        $this->validate(
            $request, $this->userRepository->validateRules($id), $this->userRepository->validateMessages()
        );

        $this->userRepository->findOrFail($id)->update($data);

        $this->createLog('PUT', $data);

        return redirect()->route('profile.edit')->with([
            'success' => true,
            'message' => 'Meu perfil foi atualizado com sucesso!'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function image()
    {
        return view('panel.user.form-image', [
            'id' => $this->getId(),
            'breadcrumbs' => $this->getBreadcrumb('Imagem')
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload(Request $request)
    {
        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();
        if (!in_array($extension, $this->extensions)) {
            return response()->json([
                'message' => 'Só são permitidos arquivos do tipo ' . implode(', ', $this->extensions) . '.'
            ]);
        }

        $dir = public_path() . '/images/profile/';
        $name = sprintf('%s.%s', sha1($this->getId()), $extension);
        $isMoved = $file->move($dir, $name);
        if (!$isMoved) {
            return response()->json([
                'message' => "Falha ao enviar o arquivo <b>{$file->getClientOriginalName()}</b> por favor tente novamente!"
            ]);
        }

        $this->userRepository->find($this->getId())->update(['image' => $name]);

        $this->createLog('PUT', ['image' => $name]);

        return response()->json([
            'message' => "O arquivo <b>{$file->getClientOriginalName()}</b> foi enviado com sucesso!"
        ]);
    }

    /**
     * @param string $location
     * @return array
     */
    protected function getBreadcrumb($location = null)
    {
        return $this->breadcrumbService->push([
            'Meu Perfil' => route('profile.index'),
            $location => null
        ])->get();
    }

}

