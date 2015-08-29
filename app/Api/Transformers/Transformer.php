<?php
namespace App\Api\Transformers;


abstract class Transformer
{
    /**
     * Transform a collection of lessons
     * @param  Collection $lessons
     * @return array
     */
    public function transformCollection(array $items)
    {
        return array_map([$this, 'transform'], $items);
    }

    public abstract function transform($item);
}