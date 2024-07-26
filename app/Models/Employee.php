<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Employee extends Model
{
    use HasFactory, Filterable;

    protected $fillable = ['registration','name','branch_code', 'cycle'];


    public  function existEmployee(string $registration){
        return $this->whereRegistration($registration)->exists();
    }

    public function daysOff(): HasOne
    {
        return $this->HasOne(DayOff::class)->orderBy('date');
    }
}
