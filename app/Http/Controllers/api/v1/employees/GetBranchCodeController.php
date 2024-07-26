<?php

namespace App\Http\Controllers\api\v1\employees;

use App\Http\Controllers\Controller;
use App\Http\Resources\BranchCodeCollection;
use App\Models\Employee;

class GetBranchCodeController extends Controller
{
    public function __construct(private readonly  Employee $employee){

    }

    public function __invoke(){
        return new BranchCodeCollection($this->employee->all());
    }
}
