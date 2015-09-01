<?php

namespace App\Http\Controllers;

use App\Api\Transformers\MakerTransformer;
use App\Http\Controllers\BaseApiController;

use App\Http\Requests\CreateMakerRequest;
use App\Maker;

use Illuminate\Support\Facades\Input;

class MakerController extends BaseApiController
{

    protected $makerTransformer;

    function __construct(MakerTransformer $makerTransformer)
    {
        $this->middleware('auth.basic.once');
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

    public function store(CreateMakerRequest $request)
    {
        $data = $request->only(['name', 'phone']);

        Maker::create($data);

        return $this->responseCreated('Maker was created.');
    }

    public function update(CreateMakerRequest $request, $id)
    {
        $maker = Maker::find($id);

        if (! $maker) {
            return $this->responseNotFound('Maker does not exist.');
        }

        $maker->name = $request->get('name');
        $maker->phone = $request->get('phone');
        $maker->save();

        return $this->setStatusCode(\Illuminate\Http\Response::HTTP_OK)
                    ->respond(['data' => $this->makerTransformer->transform($maker)]);
    }

    public function destroy($id)
    {
        $maker = Maker::find($id);

        if (! $maker) {
            return $this->responseNotFound('Maker does not exist.');
        }
        $vehicles = $maker->vehicles;

        if (sizeof($vehicles) > 0) {
            return $this->setStatusCode(\Illuminate\Http\Response::HTTP_NOT_FOUND)
                        ->responseWithError('This maker has associated with vehicles. Delete his vehicles first.');
        }

        $maker->delete();

        return $this->responseDeleted('The maker has been deleted successfully');
    }


}
