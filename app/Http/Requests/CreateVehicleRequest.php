<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Http\JsonResponse;

class CreateVehicleRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'color' => 'required',
            'power' => 'required',
            'capacity' => 'required',
            'speed' => 'required'
        ];
    }


    /**
     * Get the proper failed validation response for the request.
     *
     * @param  array  $errors
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function response(array $error)
    {
        return new JsonResponse(['error' => ['message' => $error, 'status' => 422]], 422);
    }
}
