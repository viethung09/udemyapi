<?php

namespace App\Http\Controllers;

use App\Api\Transformers\VehicleTransformer;
use App\Http\Controllers\BaseApiController;
use App\Http\Requests;
use App\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class VehicleController extends BaseApiController
{
    /**
     * Transform the vehicles
     * @var VehicleTransformer
     */
    protected $vehicleTransformer;

    function __construct(VehicleTransformer $vehicleTransformer)
    {
        $this->vehicleTransformer = $vehicleTransformer;
    }
    /**
     * Display a listing of the vehicles.
     *
     * @return Response
     */
    public function index()
    {
        $limit = Input::get('limit') ? : 5;
        $vehicles = Vehicle::paginate($limit);
        // dd(get_class_methods($lessons));
        $data = [
            'data' => $this->vehicleTransformer->transformCollection($vehicles->all())
        ];
        return $this->respondWithPagination($vehicles, $data);
    }

}
