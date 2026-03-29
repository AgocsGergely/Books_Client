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
            <a href="/authors/edit/{$author['id']}" class="author-card" style="">
                <!--<img src="" alt="{$author['name']}"> -->
                <div class="author-info">
                    <h3>{$author['name']}</h3>
                </div>
            </a>
            HTML;
        }

        $content = <<<HTML
        <style>

        .authors-grid{
            display:grid;
            grid-template-columns:repeat(auto-fill,minmax(200px,1fr));
            gap:20px;
            margin-top:20px;
        }

        .author-card{
            display: flex;               /* make it a flex container */
            flex-direction: column;      /* stack content vertically */
            justify-content: center;     /* center vertically */
            align-items: center;         /* center horizontally */
            text-decoration:none;
            color:black;
            border-radius:10px;
            overflow:hidden;
            background:white;
            box-shadow:0 4px 10px rgba(0,0,0,0.15);
            transition:transform .2s, box-shadow .2s;
        }


        .author-card:hover{
            transform:translateY(-5px);
            box-shadow:0 8px 20px rgba(0,0,0,0.25);
        }

        .author-card img{
            width:100%;
            height:280px;
            object-fit:cover;
        }

        .author-info {
            padding: 10px;
            display: flex;
            flex-direction: column;
            justify-content: center;   /* vertical centering */
            align-items: center;       /* horizontal centering */
            height: 100%;              /* fill the card */
        }


        .author-info h3 {
            font-size: 16px;
            margin: 0;
        }

        </style>

        <h1>Könyvek</h1>
        <div class="authors-grid">
            $cards
        </div>
        HTML;

        return (new LayoutView($content, "Könyvek"))->render();
    }
}