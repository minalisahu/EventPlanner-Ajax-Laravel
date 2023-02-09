<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Session;

class Alert extends Component
{
    public $type;
    public $message;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        if(Session::has('success_message')){
            $this->type = 'success';
            $this->message = session('success_message');
        }
        if(Session::has('error_message')){
            $this->type = 'danger';
            $this->message = session('error_message');
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        if ($this->message)
        return view('components.alert');
    }
}
