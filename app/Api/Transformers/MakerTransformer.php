<?php
namespace App\Api\Transformers;


class MakerTransformer extends Transformer
{
    public function transform($maker)
    {
         return [
            'name' => $maker['name'],
            'phone' => $maker['phone']
        ];
    }

}