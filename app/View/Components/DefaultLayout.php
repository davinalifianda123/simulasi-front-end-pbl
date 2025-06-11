<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DefaultLayout extends Component
{
    /**
     * Create a new component instance.
     */

    public string $namaUser;
    public string $namaRole;
    public int $id;
    
    public function __construct() {
        $this->namaUser = request()->attributes->get('nama_user');
        $this->namaRole = request()->attributes->get('nama_role');
        $this->id = request()->attributes->get('id_user');
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.default-layout');
    }
}
