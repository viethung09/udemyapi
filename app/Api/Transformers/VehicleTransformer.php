<?php
namespace App\Api\Transformers;


class VehicleTransformer extends Transformer
{
    public function transform($vehicle)
    {
         return [
            'color' => $vehicle['color'],
            'power' => $vehicle['power'],
            'capacity' => $vehicle['capacity'],
            'speed' => $vehicle['speed']
        ];
    }

}