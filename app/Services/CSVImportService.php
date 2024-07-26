<?php

namespace App\Services;

use App\Enum\CycleEnum;
use App\Http\Requests\CSVImportRequest;
use App\Models\Employee;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CSVImportService
{

    public function __construct(private  readonly  Employee $employee){

    }
    public function importCSV(CSVImportRequest $request) : array
    {
        try {
            $response = [];
            $file = $request->file('csv');
            $handle = fopen($file->path(), 'r');

            fgetcsv($handle);

            $chunk_size = 1000;

            while(!feof($handle))
            {
                $chunk_data = [];

                for($i = 0; $i<$chunk_size; $i++)
                {
                    $data = fgetcsv($handle);
                    if($data === false)
                    {
                        break;
                    }
                    $chunk_data[] = $data;
                }

                $response = $this->parserData($chunk_data);
            }
            fclose($handle);

            return $response;
        }
        catch (\Exception $exception){
            Log::error($exception->getMessage());
            return [];
        }
    }

    private function parserData(array $data): array
    {
        try{
          return  array_map(callback: function ($l) {
                $row = str_getcsv(array_shift($l), ';');
                return $row;
            },
                array: $data);
        }
        catch (\Exception $exception){
            Log::error($exception->getMessage());
            return [];
        }
    }
}
