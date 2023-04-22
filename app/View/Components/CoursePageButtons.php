<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CoursePageButtons extends Component
{
    public $enroll_status;
    public $data_arr;
    public $page;
       
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($enrollStatus = null, $dataArr = array(), $page = null)
    {
        $this->enroll_status = $enrollStatus;
        $this->data_arr      = $dataArr;   
        $this->page          = $page;
        //dump($enrollStatus);
        //dd($dataArr); 
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('includes.components.course-page-buttons');
    }
}



/*
public $title;
    public $message;
    public $message2;
    public $canClose;
    

    public function __construct($title=null, $message=null, $message2=null, $canClose=true)
    {
        
        $canClose = ($canClose === false) ? false : true;

        $this->title      = $title;
        $this->message    = $message;
        $this->message2   = $message2;
        $this->canClose   = $canClose;
    }

   
    public function render()
    {
        return view('includes.components.flash-message');
    }
}


<x-flash-message 
    class="flash-danger mt-3"  
    title="Permission Denied!"
    message="You dont have Permissions view teachers" 
    :canClose="false"/>
*/


