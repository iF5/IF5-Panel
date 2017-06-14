<?php

namespace App\Repositories\Panel;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Traits\AuthTrait;

class DashboardRepository
{

    use AuthTrait;

    private $limit = 20;

    private $bindings = [];

    /**
     * @param $value
     * @param bool $overwrite
     */
    private function addBindings($value, $overwrite = false)
    {
        if ($overwrite) {
            $this->bindings = $value;
        } else {
            $this->bindings[] = $value;
        }
    }

    /**
     * @return mixed
     */
    protected function prepareDocumentsByEmployees()
    {
        $stmt = \DB::table('documents')->selectRaw('
                employees_has_documents.documentId,
                count(employees_has_documents.documentId) AS documentQuantity,
                employees.providerId
            ')->leftJoin('employees_has_documents', function ($join) {
            $join->on('employees_has_documents.documentId', '=', 'documents.id');
        })->join('employees', function ($join) {
            $join->on('employees.id', '=', 'employees_has_documents.employeeId');
        })->where([
            ['employees_has_documents.validated', '=', '?']
        ]);

        if ($this->getRole() === 'company') {
            $this->addBindings($this->getCompanyId());
            $stmt->whereIn('employees.id', function ($query) {
                $query->select('employeeId')->from('employees_has_companies')->where('companyId', '=', '?');
            });
        }
        return $stmt->groupBy('documents.id', 'employees.providerId');
    }

    /**
     * @param $keyword
     * @return mixed
     */
    protected function prepareEmployeesByProviders($keyword)
    {
        $stmt = \DB::table('providers')->selectRaw('
                providers.id AS providerId,
                providers.name AS providerName,
                count(employees.id) AS employeeQuantity
            ')->join('employees', function ($join) {
            $join->on('employees.providerId', '=', 'providers.id');
        });

        if ($this->getRole() === 'company') {
            $this->addBindings($this->getCompanyId());
            $stmt->whereIn('employees.id', function ($query) {
                $query->select('employeeId')->from('employees_has_companies')->where('companyId', '=', '?');
            });
        }

        if ($keyword) {
            $this->addBindings("%{$keyword}%");
            $stmt->where('providers.name', 'like', '?');
        }
        return $stmt->groupBy('providers.id')->limit($this->limit);
    }

    /**
     * @param string $keyword
     * @return mixed
     */
    public function findProviders($keyword = null)
    {
        try {
            $this->addBindings(1);
            $a = $this->prepareDocumentsByEmployees();
            $b = $this->prepareEmployeesByProviders($keyword);
            $stmt = \DB::table(null)->selectRaw('
                a.documentId,
                a.documentQuantity,
                b.providerId,
                b.providerName,
                b.employeeQuantity
            ', $this->bindings)->from(\DB::raw("
                ({$a->toSql()}) AS a, 
                ({$b->toSql()}) AS b
             "))->whereRaw('a.providerId = b.providerId');

            return $stmt->get();

        } catch (\Exception $e) {
            throw new ModelNotFoundException;
        }
    }

    /**
     * @param int $providerId
     * @return mixed
     */
    public function findEmployeesByProviderId($providerId)
    {
        try {
            $this->addBindings([$providerId, 1, $this->getCompanyId()], true);

            $stmt = \DB::table('documents')->selectRaw('
                employees_has_documents.documentId,
                count(employees_has_documents.documentId) AS documentQuantity,
                employees.id AS employeeId,
                employees.name AS employeeName
            ', $this->bindings)->leftJoin('employees_has_documents', function ($join) {
                $join->on('employees_has_documents.documentId', '=', 'documents.id');
            })->join('employees', function ($join) {
                $join->on('employees.id', '=', 'employees_has_documents.employeeId');
            })->where([
                ['employees.providerId', '=', '?'],
                ['employees_has_documents.validated', '=', '?']
            ]);

            if ($this->getRole() === 'company') {
                $stmt->whereIn('employees.id', function ($query) {
                    $query->select('employeeId')->from('employees_has_companies')->where('companyId', '=', '?');
                });
            }

            return $stmt->groupBy('documents.id', 'employees.id')->get();

        } catch (\Exception $e) {
            throw new ModelNotFoundException;
        }
    }

}