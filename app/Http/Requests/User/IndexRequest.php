<?php

namespace App\Http\Requests\User;

use App\Pipes\EmailMustBeVerified;
use App\Pipes\UserMustBeActive;
use App\Services\Pipeline\PipelineService;
use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(PipelineService $pipelineService)
    {
        return $pipelineService->check(
            $this,
            [
                EmailMustBeVerified::class, // This is just an example.
                UserMustBeActive::class // This is just an example.
            ]
        );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
