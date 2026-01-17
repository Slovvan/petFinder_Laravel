<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    /**
     * Obtener la vista / contenidos que representan al componente.
     */
    public function render(): View
    {
        // IMPORTANTE: Aquí le decimos que use layouts/app.blade.php
        return view('layouts.app');
    }
}