<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDeductionRequest extends FormRequest
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
            'donor_id' => ['required', 'integer', Rule::exists('donors', 'id')],
            'month' => ['required', 'date'],
            'due_date' => ['required', 'date'],
            'amount' => ['required', 'numeric', 'gt:0'],
            'status' => ['required', Rule::in(['paid', 'pending', 'late'])],
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
            'donor_id.required' => 'حقل المتبرع مطلوب.',
            'donor_id.integer' => 'يجب أن يكون معرف المتبرع رقمًا صحيحًا.',
            'donor_id.exists' => 'المتبرع المحدد غير موجود.',

            'month.required' => 'حقل الشهر مطلوب.',
            'month.date' => 'يجب أن يكون الشهر تاريخًا صحيحًا.',

            'due_date.required' => 'حقل تاريخ الاستحقاق مطلوب.',
            'due_date.date' => 'يجب أن يكون تاريخ الاستحقاق تاريخًا صحيحًا.',

            'amount.required' => 'حقل المبلغ مطلوب.',
            'amount.numeric' => 'يجب أن يكون المبلغ رقمًا.',
            'amount.gt' => 'يجب أن يكون المبلغ أكبر من صفر.',

            'status.required' => 'حقل الحالة مطلوب.',
            'status.in' => 'يجب أن تكون الحالة أحد القيم التالية: مدفوع، معلق، متأخر.',
        ];
    }
}
