<?php

namespace App\Livewire\Admin\Components;

use Livewire\Component;

class Breadcrumbs extends Component
{
    public array $items = [];

    public function mount()
    {
        $this->resolveBreadcrumbs();
    }

    public function hydrate()
    {
        $this->resolveBreadcrumbs();
    }

    /**
     * Livewire viene ricreato a ogni cambio pagina
     * quindi mount() viene richiamato automaticamente
     */
    protected function resolveBreadcrumbs(): void
    {
        $route = request()->route();


        if (! $route) {
            $this->items = [];
            return;
        }

        $routeName = $route->getAction('as') ?? $route->getName();
        $params = $route->parameters();
        $breadcrumb = config("breadcrumbs.$routeName");
        if (is_callable($breadcrumb)) {
            $this->items = $breadcrumb(...array_values($params));
        } else {
            $this->items = $breadcrumb ?? [];
        }
    }


    public function render()
    {
        return view('livewire.admin.components.breadcrumbs');
    }
}
