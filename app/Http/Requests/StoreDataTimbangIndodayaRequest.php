<?php

namespace App\Http\Requests;

/** Goal: Validate store request for DataTimbangIndodaya, Caller: ApiDataTimbangIndodayaController, Deps: none */

use Illuminate\Foundation\Http\FormRequest;

class StoreDataTimbangIndodayaRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'no_seri' => 'nullable|string|max:255',
            'no_polisi' => 'nullable|string|max:255',
            'nm_relasi' => 'nullable|string|max:255',
            'nm_barang' => 'nullable|string|max:255',
            'nm_supir' => 'nullable|string|max:255',
            'referensi' => 'nullable|string|max:255',
            'timbang1' => 'nullable|numeric|min:0',
            'timbang2' => 'nullable|numeric|min:0',
            'potongan' => 'nullable|numeric|min:0',
            'netto' => 'nullable|numeric|min:0',
            'tanggal_m' => 'nullable|date',
            'tanggal_k' => 'nullable|date',
            'waktu1' => 'nullable|string|max:20',
            'waktu2' => 'nullable|string|max:20',
            'penimbang' => 'nullable|string|max:255',
            'nama_perusahaan' => 'nullable|string|max:255',
        ];
    }
}

