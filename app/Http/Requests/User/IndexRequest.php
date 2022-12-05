<?php

namespace App\Http\Requests\User;

use App\Pipes\Permission\EmailMustBeVerified;
use App\Pipes\Permission\UserMustBeActive;
use App\Services\Permission\PermissionService;
use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(PermissionService $permissionService)
    {
        return $permissionService->check(
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
