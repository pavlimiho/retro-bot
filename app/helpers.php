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

if (!function_exists('parseCsvFile')) {
    function parseCsvFile($file, $hasHeaders = true, $startAtRow = 1) 
    {
        $rows = [];
        
        $fh = fopen($file, 'r');
        
        $counter = 0;
        
        while (!feof($fh)) {
            if ($hasHeaders) {
                if ($counter === 0) {
                    $headers = fgetcsv($fh);
                } elseif ($counter >= $startAtRow) {
                    $rows[] = fgetcsv($fh);
                } else {
                    fgetcsv($fh);
                }
            } else {
                $rows[] = fgetcsv($fh);
            }
            
            $counter++;
        }
        
        fclose($fh);
        
        $data = [];
        
        foreach ($rows as $row) {
            $data[] = array_combine($headers, $row);
        }
        
        return $data;
    }
}

if (!function_exists('printDate')) {
    function printDate(string $date = null)
    {
        if (empty($date)) {
            return '';
        }
        
        $newDate = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date);
        return $newDate->format('d/m/Y H:i:s');
    }
}

/**
 * Gets Datetime stored in DB as UTC and shows as Browser's local DateTime
 * @param String $datetime
 * @return Carbon DateTime
 */
if (!function_exists('displayLocalDateTime')) {
    function displayLocalDateTime($datetime, $tz = 'Europe/Paris') 
    {
        $timezone = $tz ? $tz : session('timezone');
        $datetime = \Carbon\Carbon::parse($datetime);
        return $timezone ? $datetime->setTimezone($timezone) : $datetime;
    }
}
