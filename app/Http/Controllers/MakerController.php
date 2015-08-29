<?php

namespace App\Http\Controllers;

use App\Api\Transformers\MakerTransformer;
use App\Http\Controllers\BaseApiController;
use App\Http\Requests;
use App\Maker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class MakerController extends BaseApiController
{

    protected $makerTransformer;

    function __construct(MakerTransformer $makerTransformer)
    {
        $this->makerTransformer = $makerTransformer;
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $limit = Input::get('limit') ? : 5;
        $makers = Maker::paginate($limit);
        // dd(get_class_methods($lessons));
        $data = [
            'data' => $this->makerTransformer->transformCollection($makers->all())
        ];
        return $this->respondWithPagination($makers, $data);
    }

    /**
     * Display the specified maker.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $maker = Maker::find($id);

        if (! $maker) {
            return $this->responseNotFound('Maker does not exist.');
        }

        return $this->setStatusCode(\Illuminate\Http\Response::HTTP_OK)
                    ->respond(['data' => $this->makerTransformer->transform($maker)]);
    }


}
