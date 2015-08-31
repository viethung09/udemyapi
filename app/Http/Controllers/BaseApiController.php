<?php
namespace App\Http\Controllers;

use App\Api\Transformers\MakerTransformer;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Response;

class BaseApiController extends Controller
{
    protected $makerTransformer;

    function __construct(MakerTransformer $makerTransformer)
    {
        $this->makerTransformer = $makerTransformer;
    }

    private $statusCode = \Illuminate\Http\Response::HTTP_OK;

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

    public function responseNotFound($message = 'Not Found!')
    {
        return $this->setStatusCode(\Illuminate\Http\Response::HTTP_NOT_FOUND)
                    ->responseWithError($message);
    }

    public function responseInternalError($message = 'Internal Error!')
    {
        return $this->setStatusCode(\Illuminate\Http\Response::HTTP_INTERNAL_SERVER_ERROR)
                    ->responseWithError($message);
    }

    public function respond($data, $headers = [])
    {
        return Response::json(
            $data,
            $this->getStatusCode(),
            $headers
        );
    }

    protected function respondWithPagination(LengthAwarePaginator $lenhthAwarePaginator, $data)
    {
        $data = array_merge($data, [
            'paginator' => [
                'total_count' => $lenhthAwarePaginator->total(),
                'total_pages' => ceil($lenhthAwarePaginator->total() / $lenhthAwarePaginator->perPage()),
                'current_page' => $lenhthAwarePaginator->currentPage(),
                'limit'         => $lenhthAwarePaginator->perPage()
            ]
        ]);

        return $this->respond($data);
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

    /**
     * The responese code and message for the passed.
     * @param  string $message
     * @return mixed
     */
    public function responseCreated($message)
    {
        return $this->setStatusCode(\Illuminate\Http\Response::HTTP_CREATED)
                    ->respond([
                        'status' => 'Successfull',
                        'message' => $message
        ]);
    }

}