<?php

namespace Orchestra\Workbench\View\Components;

use WpStarter\View\Component;
use WpStarter\View\View;

class AppLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return ws_view('layouts.app');
    }
}
