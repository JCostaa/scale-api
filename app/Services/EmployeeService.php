<?php

namespace App\Services;

use App\Enum\CycleEnum;
use App\Filters\QueryFilters;
use App\Http\Requests\CSVImportRequest;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EmployeeService
{

    public function __construct(
        private readonly CSVImportService $CSVImportService,
        private  readonly Employee $employee,
        private readonly ScaleService $scaleService

    ){

    }

    public function createEmployee(CSVImportRequest $request): array {
        try {
            DB::beginTransaction();
            $csvData = $this->CSVImportService->importCSV($request);
            $this->employeeMapper($csvData);
            DB::commit();
            return ['message' => 'Operaçao Concluida com sucesso', 'code' => JsonResponse::HTTP_OK];
        }
        catch (\Exception $exception){
            Log::error($exception->getMessage());
            DB::rollBack();
            return ['message' => 'Não foi possivel concluir essa operação','code'=> JsonResponse::HTTP_BAD_REQUEST];
        }

    }


    private function employeeMapper(array $data) :void {
        array_map(callback: function ($row)  {
            $existEmployee = $this->employee->existEmployee($row[0]);
            if(!$existEmployee){
                $employee = $this->employee->create ([
                    'registration' => $row[0],
                    'name' => $row[1],
                    'branch_code' => $row[2],
                    'cycle' => CycleEnum::from($row[3])->name
                ]);

                $employee->daysOff()->create([
                   'date' => Carbon::createFromFormat('d/m/Y', $row[4])->format('Y-m-d')
                ]);
            }
            else{
                Log::info('O usuário: ' . $row[1]. ' já foi cadastrado');
            }
            return $row;
        },
            array: $data);
    }

    public function getWorkDay(QueryFilters  $filters) : array{
        $response = [];
        $employees = $this->employee->filter($filters)->paginate(10);

        $sundays = $this->scaleService->getSundays(['month' => $filters->get('month'), 'year' => $filters->get('year')]);
        foreach ($employees as $employee) {
            $scales = $this->scaleService->scaleCalculate(
                $employee->daysOff->date,
                (int)CycleEnum::fromName($employee['cycle']),
                $sundays
            );
            foreach ($scales as $sunday => $status) {
                $response[] = [
                    'id' => $employee->id,
                    'sunday' => Carbon::createFromFormat('Y-m-d',$sunday)->format('d/m/y'),
                    'name' => $employee->name,
                    'cycles' => $employee->cycle,
                    'registration' => $employee->registration,
                    'branch_code' => $employee->branch_code,
                    'status' => $status,

                ];
            }
        }
        return $response;
    }
}
