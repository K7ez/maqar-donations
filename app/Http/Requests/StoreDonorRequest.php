<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDonorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'full_name' => ['required', 'string', 'max:255'],
            'national_id' => ['required', 'string', 'max:20', Rule::unique('donors', 'national_id')],
            'phone' => ['required', 'regex:/^05\d{8}$/'],
            'deduction_type' => ['required', Rule::in(['monthly', 'yearly', 'one_time'])],
            'amount' => ['required', 'numeric', 'gt:0'],
            'status' => ['required', Rule::in(['active', 'suspended'])],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'full_name.required' => 'حقل الاسم الكامل مطلوب.',
            'full_name.string' => 'يجب أن يكون الاسم الكامل نصًا.',
            'full_name.max' => 'يجب ألا يتجاوز الاسم الكامل 255 حرفًا.',

            'national_id.required' => 'حقل رقم الهوية الوطنية مطلوب.',
            'national_id.string' => 'يجب أن يكون رقم الهوية الوطنية نصًا.',
            'national_id.max' => 'يجب ألا يتجاوز رقم الهوية الوطنية 20 حرفًا.',
            'national_id.unique' => 'رقم الهوية الوطنية مستخدم من قبل.',

            'phone.required' => 'حقل رقم الجوال مطلوب.',
            'phone.regex' => 'يجب أن يكون رقم الجوال بصيغة سعودية صحيحة (يبدأ بـ 05 ويتكون من 10 أرقام).',

            'deduction_type.required' => 'حقل نوع الاستقطاع مطلوب.',
            'deduction_type.in' => 'يجب أن يكون نوع الاستقطاع أحد القيم التالية: شهري، سنوي، لمرة واحدة.',

            'amount.required' => 'حقل المبلغ مطلوب.',
            'amount.numeric' => 'يجب أن يكون المبلغ رقمًا.',
            'amount.gt' => 'يجب أن يكون المبلغ أكبر من صفر.',

            'status.required' => 'حقل الحالة مطلوب.',
            'status.in' => 'يجب أن تكون الحالة إما نشط أو موقوف.',
        ];
    }
}
