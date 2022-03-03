<?php

namespace App\Core\Requests;

use Illuminate\Auth\Access\Response;

interface BaseRequestInterface
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): Response;

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array;
}
