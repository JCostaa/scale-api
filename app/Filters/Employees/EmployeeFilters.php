<?php

namespace App\Filters\Employees;

use App\Filters\QueryFilters;
use Illuminate\Http\Request;

class EmployeeFilters extends QueryFilters
{
    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        parent::__construct($request);
    }

    public function branch_code(string $term = '')
    {
        return $this->builder->where('employees.branch_code', $term);
    }



}
