<?php

namespace App\Views\Series;

use App\Views\Layout\LayoutView;

class SeriesView
{
    private array $seriesList;

    public function __construct(array $seriesList)
    {
        $this->seriesList = $seriesList;
    }

    public function render(): string
    {
        $cards = "";
        unset($this->seriesList['code']);
        
        foreach ($this->seriesList as $series) {
            $cards .= <<<HTML
            <a href="/series/edit/{$series['id']}" class="series-card">
                <div class="series-info">
                    <h3>{$series['name']}</h3>
                </div>
            </a>
            HTML;
        }

        $content = <<<HTML
        <style>
            .series-grid{ display:grid; grid-template-columns:repeat(auto-fill,minmax(250px,1fr)); gap:20px; margin-top:20px; }
            .series-card{ text-decoration:none; color:#333; background:white; padding:20px; border-radius:10px; box-shadow:0 4px 10px rgba(0,0,0,0.1); border-left: 5px solid #007bff; transition: 0.3s; }
            .series-card:hover{ transform: scale(1.02); box-shadow:0 6px 15px rgba(0,0,0,0.15); }
        </style>
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <h1>Sorozatok</h1>
            <a href="/series/create" style="background:#007bff; color:white; padding:10px 20px; border-radius:6px; text-decoration:none;">+ Új sorozat</a>
        </div>
        <div class="series-grid">
            $cards
        </div>
        HTML;

        return (new LayoutView($content, "Sorozatok"))->render();
    }
}