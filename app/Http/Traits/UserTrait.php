<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;

trait UserTrait
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $keyword = \Request::input('keyword');
        $users = ($keyword) ?
            $this->getUser()->findLike('name', $keyword) :
            $this->getUser()->findOrderBy();

        return view('panel.user.list', [
            'keyword' => $keyword,
            'users' => $users,
            'route' => "user-{$this->getRole()}"
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('panel.user.form', [
            'user' => $this->getUser(),
            'method' => 'POST',
            'routePrefix' => "user-{$this->getRole()}",
            'route' => "user-{$this->getRole()}.store",
            'parameters' => []
        ]);
    }

    /**
     * @param array $data
     * @return array
     */
    protected function formRequest($data)
    {
        $data['password'] = bcrypt($data['password']);
        $data['role'] = $this->getRole();
        $data['companyId'] = $this->getCompanyId();
        $data['providerId'] = $this->getProviderId();
        //$data['isAllPrivileges'] = isset($data['isAllPrivileges']) ? true : false;

        return $data;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->formRequest($request->all());
        $this->validate(
            $request, $this->getUser()->validateRules(), $this->getUser()->validateMessages()
        );
        $user = $this->getUser()->create($data);

        return redirect()
            ->route("user-{$this->getRole()}.create")
            ->with([
                'success' => 'Usu&aacute;rio cadastrado com sucesso!',
                'id' => $user->id
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('panel.user.show', [
            'user' => $this->getUser()->findById($id),
            'routePrefix' => "user-{$this->getRole()}"
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('panel.user.form', [
            'user' => $this->getUser()->findById($id),
            'method' => 'PUT',
            'routePrefix' => "user-{$this->getRole()}",
            'route' => "user-{$this->getRole()}.update",
            'parameters' => [$id]
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $this->formRequest($request->all());
        $this->validate(
            $request, $this->getUser()->validateRules(), $this->getUser()->validateMessages()
        );

        $this->getUser()
            ->findOrFail($id)
            ->update($data);

        return redirect()
            ->route("user-{$this->getRole()}.edit", $id)
            ->with([
                'success' => 'Usu&aacute;rio atualizado com sucesso!',
                'id' => $id
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->getUser()->destroy($id);
        return redirect()->route("user-{$this->getRole()}.index");
    }

}