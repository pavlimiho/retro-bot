<?php

namespace App\View\Components\Members;

use App\Models\WowClass;
use Illuminate\Support\Arr;
use Illuminate\View\Component;

class Form extends Component
{
    public $wowClasses;
    public $selectedClass;
    public $member;
    
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($member = null)
    {
        $this->wowClasses = WowClass::orderBy('name')->get();
        $this->member = $member;
        $this->selectedClass = Arr::get($this->member, 'wow_class_id');
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.members.form');
    }
    
    /**
     * Determine if the given option is the currently selected option.
     *
     * @param  string  $option
     * @return bool
     */
    public function isSelected($option) 
    {
        return $option === $this->selectedClass;
    }

}
