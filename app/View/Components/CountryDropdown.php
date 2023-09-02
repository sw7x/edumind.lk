<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CountryDropdown extends Component
{
    public $id;
    public $name;
    public $cls;
    public $req;
    public $selectedVal;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id = '', $name = '', $cls = '', $req='',$selectedVal='')
    {
        $this->id           = $id;
        $this->name         = $name;   
        $this->cls          = $cls;
        $this->req          = ($req == 'required')?true:false;
        $this->selectedVal  = $selectedVal;        
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('includes.components.country-dropdown');
    }
}
