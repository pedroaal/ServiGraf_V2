<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Report extends Component
{
    public $title;
    public $items;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title, $items)
    {
        $this->title = $title;
        $this->items = $items;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.report');
    }
}
