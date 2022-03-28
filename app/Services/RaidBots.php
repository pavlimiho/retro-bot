<?php

namespace App\Services;

use App\Models\Encounter;
use App\Models\Instance;
use Illuminate\Support\Arr;

class RaidBots 
{
    private $instancesPath = 'https://www.raidbots.com/static/data/live/instances.json';

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
}
