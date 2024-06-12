<?php
namespace App\Http\Imports;

use App\Models\Excel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ExcelImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use SkipsFailures;

    protected $errors = [];

    public function model(array $row)
    {
        $validator = \Validator::make($row, [
            'email' => [
                'required',
                'email',
                function ($attribute, $value, $fail) {
                    $conflictingEmails = Excel::where('email', $value)->pluck('email');
                    if ($conflictingEmails->isNotEmpty()) {
                        $fail("The email has already been taken by: " . $conflictingEmails->implode(', '));
                    }
                }
            ],
            'name' => 'required|string|max:255',

            'contact' => [
                'required',
                'numeric',
                'digits_between:10,15'
            ],
        ], $this->customValidationMessages());
    
        if ($validator->fails()) {
            $this->errors[] = [
                'row' => $row,
                'errors' => $validator->errors()->all(),
            ];
            return null;
        }
    
        return new Excel([
            'name' => $row['name'],
            'email' => $row['email'],
            'contact' => $row['contact'],
        ]);
    }
    
    public function rules(): array
    {
        return [
            '*.name' => 'required|string|max:255',
            '*.contact' => [
                'required',
                'numeric',
                'digits_between:10,15'
            ],
        ];
    }
    

    public function customValidationMessages()
    {
        return [
            'email.required' => 'Email is required.',
            'email.email' => 'The email format is invalid.',
            'email.unique' => 'The email has already been taken.',
            'name.required' => 'Name is required.',
            'name.string' => 'Name must be a string.',
            'name.max' => 'Name must not exceed 255 characters.',
            'contact.required' => 'Contact is required.',
            'contact.digits_between' => 'Contact must be between 10 and 15 digits.',
        ];
    }

    public function onFailure(...$failures)
    {
        foreach ($failures as $failure) {
            $this->errors[] = [
                'row' => $failure->values(),
                'errors' => $failure->errors()
            ];
        }
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
