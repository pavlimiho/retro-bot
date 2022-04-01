<?php

namespace App\Services;

use App\Models\Encounter;
use App\Models\Instance;
use Illuminate\Support\Arr;

class RaidBots 
{
    private $instancesPath = 'https://www.raidbots.com/static/data/live/instances.json';
    private $itemsPath = 'https://www.raidbots.com/static/data/live/equippable-items.json';
    
    private $relevantInstances = [
        'Sepulcher of the First Ones'
    ];
    
    public function syncInstances()
    {
        $instances = json_decode(file_get_contents($this->instancesPath), true);
        
        foreach ($instances as $instance) {
            if (in_array(Arr::get($instance, 'name'), $this->relevantInstances)) {
                $this->syncInstance($instance);
            }
        }
    }
    
    public function syncInstance($data)
    {
        $instance = Instance::where('external_id', Arr::get($data, 'id'))->first();
        
        if (empty($instance)) {
            $instance = new Instance();
        }
        
        $instance->external_id = Arr::get($data, 'id');
        $instance->name = Arr::get($data, 'name');
        $instance->description = Arr::get($data, 'description');
        $instance->type = Arr::get($data, 'type');
        $instance->save();

        foreach (Arr::get($data, 'encounters') as $encounter) {
            $this->syncEncounter($instance, $encounter);
        }
    }
    
    public function syncEncounter(Instance $instance, $data)
    {
        $encounter = Encounter::where('external_id', Arr::get($data, 'id'))->first();
        
        if (empty($encounter)) {
            $encounter = new Encounter();
        } 
        
        $encounter->external_id = Arr::get($data, 'id');
        $encounter->instance_id = Arr::get($instance, 'id');
        $encounter->name = Arr::get($data, 'name');
        $encounter->order = Arr::get($data, 'order');
        $encounter->save();
    }
    
    public function syncItems()
    {
        $items = json_decode(file_get_contents(storage_path('app/public/items.json')), true);
        
        foreach ($items as $item) {
            dd($item);
            
            if (in_array(Arr::get($instance, 'name'), $this->relevantInstances)) {
                $this->syncInstance($instance);
            }
        }
    }
    
    public function getSimData(string $link)
    {
        $csvLink = $this->simToCsv($link);
        $data = parseCsvFile($csvLink);
        return $this->parseSimData($data);
    }
    
    public function simToCsv(string $link)
    {
        $ex = explode('/', $link);
        return 'https://www.raidbots.com/reports/'.$ex[5].'/data.csv';
    }
    
    public function getSimDataFromJson(string $link)
    {
        return json_decode(file_get_contents($this->simToJson($link)), true);
    }
    
    public function simToJson(string $link)
    {
        $ex = explode('/', $link);
        return 'https://www.raidbots.com/reports/'.$ex[5].'/data.json';
    }
    
    public function parseSimData($data)
    {
        $parsedData = [];
        
        $dpsBase = Arr::get($data[0], 'dps_mean');
        
        foreach ($data as $i => $item) {
            if ($i > 0) {
                $ex = explode('/', Arr::get($item, 'name'));
                $encounterId = $ex[1];
                
                // We don't need trash mobs
                if ($encounterId < 0) {
                    continue;
                }
                
                $dps = round(Arr::get($item, 'dps_mean') - $dpsBase);
                
                if ($dps <= 0) {
                    continue;
                }
                
                $parsedData[$encounterId][] = [
                    'item' => $ex[5],
                    'dps' => $dps
                ];
            }
        }
        
        return $parsedData;
    }
    
    public function getSimTimestamp(string $link)
    {
        return Arr::get($this->getSimDataFromJson($link), 'timestamp');
    }
}
