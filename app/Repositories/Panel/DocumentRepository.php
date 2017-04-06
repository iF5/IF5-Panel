<?php

namespace App\Repositories\Panel;

use App\Models\Document;
use Illuminate\Support\Facades\DB;

class DocumentRepository extends Document
{
    protected $totalPerPage = 20;

    public function getAllDocuments()
    {
        try {
            return Document::where([
                ['provider', '=', 0]
            ])->get();
        } catch (\Exception $e) {
            throw new ModelNotFoundException;
        }
    }

    /**
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function findByEmployee($id)
    {
        try {
            return DB::table('documents')
                     ->select(DB::raw('documents.*, employees_has_documents.*'))
                    ->leftJoin('employees_has_documents', 'employees_has_documents.employeeId', '=', 'documents.id')
                    ->leftJoin('employees', 'employees.id', '=', 'employees_has_documents.employeeId',
                                                                            'and', 'employees.id', '=', $id)->get();
        } catch (\Exception $e) {
            throw new ModelNotFoundException;
        }
    }
}