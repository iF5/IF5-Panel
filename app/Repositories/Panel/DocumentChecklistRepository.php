<?php

namespace App\Repositories\Panel;

use App\Models\DocumentChecklist;
//use Illuminate\Database\Eloquent\ModelNotFoundException;

class DocumentChecklistRepository extends DocumentChecklist
{
    /**
     * @var int
     */
    protected $totalPerPage = 20;

}