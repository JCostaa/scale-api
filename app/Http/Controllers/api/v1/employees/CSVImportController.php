<?php

namespace App\Http\Controllers\api\v1\employees;

use App\Http\Controllers\Controller;
use App\Http\Requests\CSVImportRequest;
use App\Services\EmployeeService;

class CSVImportController extends Controller
{
    public function __construct(private readonly EmployeeService $CSVImportService){

    }
    public function __invoke(CSVImportRequest $request){

        $response = $this->CSVImportService->createEmployee($request);
        return response()->json($response);
    }
}
