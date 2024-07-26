<?php

namespace App\Http\Controllers\api\v1\employees;

use App\Filters\Employees\EmployeeFilters;
use App\Http\Controllers\Controller;
use App\Http\Requests\CSVImportRequest;
use App\Models\Employee;
use App\Services\EmployeeService;
use App\Services\ScaleService;
use Illuminate\Http\JsonResponse;

class GetEmployeesController extends Controller
{
    public function __construct(
        private readonly  EmployeeService $employeeService
    ){
    }


    public function __invoke(EmployeeFilters $filters): JsonResponse
    {
        $response = $this->employeeService->getWorkDay($filters);
        return response()->json($response);
    }

}
