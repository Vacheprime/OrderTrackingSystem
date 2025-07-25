<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Notification extends Component
{
    private string $message = "";
    private string $type = "info"; // Default type

    /**
     * Create a new component instance.
     */
    public function __construct(string $message = "", string $type = "info")
    {
        $this->message = $message;
        $this->type = $type;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.notification')->with([
            'message' => $this->message,
            'type' => $this->type,
        ]);
    }
}
