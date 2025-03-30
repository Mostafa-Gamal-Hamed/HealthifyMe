<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class EditShow extends Component
{
    public $url;
    public $class;
    public $text;
    public $title;

    public function __construct($url, $class, $text, $title)
    {
        $this->class = $class;
        $this->url   = $url;
        $this->text  = $text;
        $this->title = $title;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.edit-show');
    }
}
