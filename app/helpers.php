<?php

use Illuminate\Support\Arr;

/**
 * Maps data array into Model
 * @param Model $model
 * @param Array $data
 * @return Model
 */
if (!function_exists('mapModel')) {
    function mapModel($model = null, $data = null) 
    {
        if ($model && $data) {
            dd($model->getAttributes);
            foreach ($model->getAttributes(false) as $key) {
                if ($key === $model->getKeyName()) {
                    continue;
                }
                if (Arr::has($data, $key)) {
                    Arr::set($model, $key, $data[$key]);
                }
            }
        }
        return $model;
    }
}