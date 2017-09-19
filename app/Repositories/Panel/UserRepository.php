<?php

namespace App\Repositories\Panel;

use App\Models\User;

class UserRepository extends User
{

    /**
     * @var int
     */
    protected $totalPerPage = 20;

    /**
     * @var string
     */
    protected $role;

    /**
     * @var int
     */
    protected $companyId;

    /**
     * @var int
     */
    protected $providerId;

    /**
     * @param string $role
     * @return $this
     */
    public function setRole($role)
    {
        $this->role = $role;
        return $this;
    }

    /**
     * @param int $companyId
     * @return $this
     */
    public function setCompanyId($companyId)
    {
        $this->companyId = $companyId;
        return $this;
    }

    /**
     * @param int $providerId
     * @return $this
     */
    public function setProviderId($providerId)
    {
        $this->providerId = $providerId;
        return $this;
    }

    /**
     * @param array $filterAdd
     * @return array
     */
    public function filter(array $filterAdd = [])
    {
        $filters = [
            'admin' => [
                ['role', '=', 'admin']
            ],
            'company' => [
                ['role', '=', 'company'],
                ['companyId', '=', $this->companyId]
            ],
            'provider' => [
                ['role', '=', 'provider'],
                ['providerId', '=', $this->providerId]
            ]
        ];

        if (isset($filterAdd[0]) && is_array($filterAdd[0])) {
            foreach ($filterAdd as $add) {
                $filters[$this->role][] = $add;
            }
        } elseif (count($filterAdd) > 0) {
            $filters[$this->role][] = $filterAdd;
        }
        return $filters[$this->role];
    }

    /**
     * @param string $field
     * @param string|null $keyword
     * @return mixed
     */
    public function findLike($field, $keyword = null)
    {
        $filter = $this->filter([$field, 'like', "%{$keyword}%"]);
        return User::where($filter)
            ->paginate($this->totalPerPage);
    }

    /**
     * @param string $field
     * @param string $type
     * @return mixed
     */
    public function findOrderBy($field = 'id', $type = 'desc')
    {
        return User::where($this->filter())
            ->orderBy($field, $type)
            ->paginate($this->totalPerPage);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function findById($id)
    {
        $filter = $this->filter(['id', '=', $id]);
        return User::where($filter)->first();
    }

    /**
     * @param string $email
     * @return mixed
     */
    public function findByEmail($email)
    {
        return User::where('email', '=', $email)->first();
    }

    /**
     * @param string $token
     * @return mixed
     */
    public function findByDuoSha1Token($token)
    {
        return User::whereRaw(sprintf("SHA1(SHA1(email)) = '%s'", $token))->first();
    }

}