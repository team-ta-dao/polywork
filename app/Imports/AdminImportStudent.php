<?php

namespace App\Imports;

use App\Admin;
use App\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Validators\Failure;
use Throwable;
class AdminImportStudent implements
ToCollection,
WithHeadingRow,
SkipsOnError,
SkipsOnFailure,
WithChunkReading,
WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    use Importable, SkipsErrors, SkipsFailures;

    public function collection(Collection $rows)
    {
        foreach($rows as $row){
            $username = explode('@',$row['email']);
            $student = Student::create([
                'fullname' => $row['ho_va_ten'],
                'email' => $row['email'],
                'username'=> $username[0],
                'password' => Hash::make($row['mssv'])
            ]);
        }
    }
    public function rules(): array
    {
            return [
                '*.email' => ['email', 'unique:student,email'],
                '*.username' => ['username', 'unique:student,username'],
            ];
    }
    public function chunkSize(): int
        {
            return 1000;
        }
}
