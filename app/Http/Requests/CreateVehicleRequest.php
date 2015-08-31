<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Response;

class CreateVehicleRequest extends Request
{
    protected $statusCode = \Illuminate\Http\Response::HTTP_OK;

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * The status code will set
     * @param mix $statusCode
     * @return $this
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    public function responseWithError($message)
    {
        return $this->respond([
            'error' => [
                'message' => $message,
                'status'  => $this->getStatusCode()
            ]
        ]);
    }

    public function respond($data, $headers = [])
    {
        return Response::json(
            $data,
            $this->getStatusCode(),
            $headers
        );
    }

    /**
     * Get the proper failed validation response for the request.
     *
     * @param  array  $errors
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function response(array $error)
    {
        var_dump($error);
        return $this->setStatusCode(\Illuminate\Http\Response::HTTP_UNPROCESSABLE_ENTITY)->responseWithJsonError('Validation Failed! You must specify .');
    }

    private function responseWithJsonError($message)
    {
        return $this->respond([
            'error' => [
                'message' => $message,
                'status'  => $this->getStatusCode()
            ]
        ]);
    }

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
}
