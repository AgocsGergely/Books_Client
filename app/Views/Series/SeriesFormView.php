<?php

namespace App\Views\Series;

use App\Views\Layout\LayoutView;

class SeriesFormView
{
    private array $series;

    // Defaulting to an empty array so creating new records doesn't fail
    public function __construct(array $series = [])
    {
        $this->series = $series;
    }

    public function render(): string
    {
        // 1. Safely extract values using '??' to prevent "Undefined array key" warnings.
        // I check for both 'title' and 'name' just in case your DB uses 'name'.
        $id = $this->series['id'] ?? null;
        $titleValue = $this->series['name'] ?? $this->series['name'] ?? '';
        $descValue = $this->series['description'] ?? '';

        $pageTitle = $id ? "Sorozat szerkesztése" : "Új sorozat";
        $action = $id ? "/series/edit/{$id}" : "/series/create";

        // 2. Build the delete button conditionally OUTSIDE the HTML Heredoc
        $deleteButton = "";
        if ($id) {
            $deleteButton = "<a href=\"/series/delete/{$id}\" class=\"btn btn-delete\">Törlés</a>";
        }

        $content = <<<HTML
        <style>
            .form-container{ max-width:800px; margin:40px auto; background:white; border-radius:12px; padding:30px; box-shadow:0 6px 20px rgba(0,0,0,0.15); }
            .form-group{ display:flex; flex-direction:column; margin-bottom:15px; }
            .form-group label{ font-weight:bold; margin-bottom:5px; }
            .form-group input, .form-group textarea{ padding:10px; border-radius:6px; border:1px solid #ccc; }
            .btn-group{ display:flex; gap:10px; margin-top:20px; }
            
            .btn{ padding:8px 14px; border:none; border-radius:6px; cursor:pointer; text-decoration:none; font-size:14px; text-align:center; }
            .btn-save{ background:#28a745; color:white; }
            .btn-delete{ background:#dc3545; color:white; }
            .btn-back{ background:#6c757d; color:white; }
        </style>
        <div class="form-container">
            <form method="post" action="{$action}">
                <div class="form-group">
                    <label>Sorozat címe</label>
                    <input type="text" name="name" value="{$titleValue}" required>
                </div>
            
                <div class="btn-group">
                    <button type="submit" class="btn btn-save">Mentés</button>
                    <a href="/series" class="btn btn-back">Vissza</a>
                    {$deleteButton}
                </div>
            </form>
        </div>
        HTML;

        return (new LayoutView($content, $pageTitle))->render();
    }
}