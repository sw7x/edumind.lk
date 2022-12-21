<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FlashMessage extends Component
{
    public $title;
    public $message;
    public $message2;
    public $canClose;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title=null, $message=null, $message2=null, $canClose=true)
    {
        
        $canClose = ($canClose === false) ? false : true;

        $this->title      = $title;
        $this->message    = $message;
        $this->message2   = $message2;
        $this->canClose   = $canClose;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('includes.components.flash-message');
    }
}
