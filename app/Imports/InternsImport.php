<?php
namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Validators\Failure;

class InternsImport implements 
    ToModel, 
    WithHeadingRow, 
    WithValidation, 
    SkipsOnFailure
{
    use Importable, SkipsFailures;

    protected $rows = 0;

    public function model(array $row)
    {
        $this->rows++;
        
        return new User([
            'first_name' => $row['first_name'],
            'last_name'  => $row['last_name'],
            'email'      => $row['email'],
            'password'   => Hash::make($row['password'] ?? 'default123'),
            'role_id'    => 3,
            'status'     => $row['status'] ?? 'active',
        ]);
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:100'],
            'last_name'  => ['required', 'string', 'max:100'],
            'email'      => ['required', 'email', 'unique:users,email'],
            'status'     => ['nullable', 'string', 'in:active,inactive,completed'],
        ];
    }

    public function customValidationMessages()
    {
        return [
            'first_name.required' => 'First name is required.',
            'last_name.required' => 'Last name is required.',
            'email.required' => 'Email is required.',
            'email.email' => 'Email must be valid.',
            'email.unique' => 'Email already exists.',
            'status.in' => 'Status must be one of: active, inactive, completed',
        ];
    }

    public function rows(): array
    {
        return array_fill(0, $this->rows, null);
    }
}