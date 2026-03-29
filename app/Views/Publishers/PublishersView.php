<?php

namespace App\Views\Publishers;

use App\Views\Layout\LayoutView;

class PublishersView
{
    private array $publishers;

    public function __construct(array $publishers)
    {
        $this->publishers = $publishers;
    }

    public function render(): string
    {
        $cards = "";
        unset($this->publishers['code']);
        
        foreach ($this->publishers as $publisher) {
            $cards .= <<<HTML
            <a href="/publishers/edit/{$publisher['id']}" class="grid-card">
                <div class="card-info">
                    <h3>{$publisher['name']}</h3>
                </div>
            </a>
            HTML;
        }

        $content = <<<HTML
        <style>
            .grid-container{ display:grid; grid-template-columns:repeat(auto-fill,minmax(200px,1fr)); gap:20px; margin-top:20px; }
            .grid-card{ display: flex; flex-direction: column; justify-content: center; align-items: center; text-decoration:none; color:black; border-radius:10px; background:white; box-shadow:0 4px 10px rgba(0,0,0,0.15); transition:transform .2s, box-shadow .2s; min-height: 100px; }
            .grid-card:hover{ transform:translateY(-5px); box-shadow:0 8px 20px rgba(0,0,0,0.25); }
            .card-info { padding: 10px; text-align: center; }
        </style>
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <h1>Kiadók</h1>
            <a href="/publishers/create" style="text-decoration:none; background:#007bff; color:white; padding:8px 15px; border-radius:5px;">+ Új kiadó</a>
        </div>
        <div class="grid-container">
            $cards
        </div>
        HTML;

        return (new LayoutView($content, "Kiadók"))->render();
    }
}