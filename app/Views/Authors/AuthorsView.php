<?php

namespace App\Views\Authors;

use App\Views\Layout\LayoutView;

class AuthorsView
{
    private array $authors;
    private string $searchTerm;

    public function __construct(array $authors, string $searchTerm = '')
    {
        $this->authors = $authors;
        $this->searchTerm = $searchTerm;
    }

    public function render(): string
    {
        $cards = "";

        unset($this->authors['code']);
        
        foreach ($this->authors as $author) {
            $cards .= <<<HTML
            <a href="/authors/edit/{$author['id']}" class="author-card">
                <div class="author-info">
                    <h3>{$author['name']}</h3>
                </div>
            </a>
            HTML;
        }

        $content = <<<HTML
        <style>
        .authors-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .btn-create {
            background: #007bff;
            color: white;
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            transition: background 0.2s;
        }

        .btn-create:hover {
            background: #0056b3;
        }

        .authors-grid{
            display:grid;
            grid-template-columns:repeat(auto-fill,minmax(200px,1fr));
            gap:20px;
            margin-top:20px;
        }

        .author-card{
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-decoration:none;
            color:black;
            border-radius:10px;
            overflow:hidden;
            background:white;
            box-shadow:0 4px 10px rgba(0,0,0,0.15);
            transition:transform .2s, box-shadow .2s;
            min-height: 100px; /* Biztosítja, hogy legyen magassága a kártyának */
        }

        .author-card:hover{
            transform:translateY(-5px);
            box-shadow:0 8px 20px rgba(0,0,0,0.25);
        }

        .author-info {
            padding: 10px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100%;
        }

        .author-info h3 {
            font-size: 16px;
            margin: 0;
            text-align: center;
        }
        </style>

        <div class="authors-header">
            <h1>Szerzők</h1>
            <a href="/authors/create" class="btn-create">+ Új szerző</a>
        </div>

        <div class="authors-grid">
            $cards
        </div>
        HTML;

        return (new LayoutView($content, "Szerzők"))->render();
    }
}