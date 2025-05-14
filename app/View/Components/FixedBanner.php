<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FixedBanner extends Component
{
    public $image;
    public $link;

    public function __construct($image, $link = '#')
    {
        $this->image = $image;
        $this->link = $link;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.fixed-banner');
    }
}