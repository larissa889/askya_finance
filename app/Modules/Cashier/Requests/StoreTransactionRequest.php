<?php

namespace App\Modules\Cashier\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransactionRequest extends FormRequest
{
    /**
     * Only authenticated cashiers can create transactions.
     */
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * Validation rules for creating a new transaction.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'client_name'      => ['required', 'string', 'min:2', 'max:150'],
            'phone_number'     => ['required', 'string', 'max:20'],
            'service_type'     => ['required', 'string', 'in:RIA,MoneyGram,Western Union,Internal,Ria'],
            'transaction_type' => ['required', 'in:send,receive'],
            'amount'           => ['required', 'numeric', 'min:0.01', 'max:9999999.99'],
            'fees'             => ['required', 'numeric', 'min:0', 'max:9999999.99'],
            'notes'            => ['nullable', 'string', 'max:500'],
        ];
    }

    /**
     * Custom human-readable error messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'client_name.required'      => 'Le nom du client est obligatoire.',
            'client_name.min'           => 'Le nom doit contenir au moins 2 caractères.',
            'phone_number.required'     => 'Le numéro de téléphone est obligatoire.',
            'service_type.required'     => 'Le type de service est obligatoire.',
            'service_type.in'           => 'Service invalide. Choisissez : RIA, MoneyGram, Western Union, Internal.',
            'transaction_type.required' => 'Le type de transaction est obligatoire (send ou receive).',
            'transaction_type.in'       => 'Type invalide. Choisissez send ou receive.',
            'amount.required'           => 'Le montant est obligatoire.',
            'amount.numeric'            => 'Le montant doit être un nombre.',
            'amount.min'                => 'Le montant doit être supérieur à 0.',
            'fees.required'             => 'Les frais sont obligatoires (mettez 0 si aucun frais).',
            'fees.numeric'              => 'Les frais doivent être un nombre.',
        ];
    }
}
