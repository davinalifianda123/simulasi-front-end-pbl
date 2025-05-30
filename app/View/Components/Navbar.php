<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Navbar extends Component
{
    /**
     * Create a new component instance.
     */
    public string $namaUser;
    public string $namaRole;
    
    public function __construct() {
        $this->namaUser = request()->attributes->get('nama_user');
        $this->namaRole = request()->attributes->get('nama_role');
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.navbar.navbar');
    }
}
