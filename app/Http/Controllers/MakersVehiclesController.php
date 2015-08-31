<?php

namespace App\Http\Controllers;

use App\Api\Transformers\VehicleTransformer;
use App\Http\Controllers\BaseApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\CreateVehicleRequest;
use App\Maker;
use Illuminate\Http\Request;

class MakersVehiclesController extends BaseApiController
{

    protected $vehicleTransformer;

    function __construct(VehicleTransformer $vehicleTransformer)
    {
        $this->vehicleTransformer = $vehicleTransformer;
    }
    /**
     * Display the vehicles that associated with the maker.
     * @param int $makerId
     * @return Response
     */
    public function index($makerId = null)
    {

        if (! $vehicle = Maker::find($makerId)) {
            return $this->responseNotFound('Maker does not exist.');

        }

        return $this->setStatusCode(\Illuminate\Http\Response::HTTP_OK)
                    ->respond(['data' => [
                                Maker::find($makerId),
                                $this->vehicleTransformer->transformCollection(Maker::find($makerId)->vehicles->toArray())
        ]]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(CreateVehicleRequest $request, $makerId)
    {
        $maker = Maker::find($makerId);

        if (! $maker) {
            return $this->responseNotFound('Maker does not exist.');
        }
        $data = $request->all();
        $maker->vehicles()->create($data);

        return $this->responseCreated('The Vehicle associated with maker was created success!');
    }

    /**
     * Display the specified vehicle associated with with maker.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($makerId, $vehicleId)
    {
        if (! $maker = Maker::find($makerId)) {
            return $this->responseNotFound('Maker does not exist.');

        }
        $vehicle = $maker->vehicles->find($vehicleId); //dd($vehicle);
        if (! $vehicle) {
            return $this->responseNotFound('Vehicle does not exist.');
        }
        return $this->setStatusCode(\Illuminate\Http\Response::HTTP_OK)
                    ->respond(['data' => [
                                $maker,
                                $this->vehicleTransformer->transform($vehicle->toArray())
                              ]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
