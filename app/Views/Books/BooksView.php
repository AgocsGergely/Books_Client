<?php

namespace App\Views\Books;

use App\Views\Layout\LayoutView;

class BooksView
{
    private array $books;

    public function __construct(array $books)
    {
        $this->books = $books;
    }

    public function render(): string
    {
        $cards = "";

        unset($this->books['code']);
        
        foreach ($this->books as $book) {

            $cards .= <<<HTML
            <a href="/books/edit/{$book['id']}" class="book-card">
                <img src="{$book['photo']}" alt="{$book['name']}">
                <div class="book-info">
                    <h3>{$book['name']}</h3>
                    <p>Megjelenés: {$book['release_year']}</p>
                </div>
            </a>
            HTML;
        }

        $content = <<<HTML
        <style>

        .books-grid{
            display:grid;
            grid-template-columns:repeat(auto-fill,minmax(200px,1fr));
            gap:20px;
            margin-top:20px;
        }

        .book-card{
            display:block;
            text-decoration:none;
            color:black;
            border-radius:10px;
            overflow:hidden;
            background:white;
            box-shadow:0 4px 10px rgba(0,0,0,0.15);
            transition:transform .2s, box-shadow .2s;
        }

        .book-card:hover{
            transform:translateY(-5px);
            box-shadow:0 8px 20px rgba(0,0,0,0.25);
        }

        .book-card img{
            width:100%;
            height:280px;
            object-fit:cover;
        }

        .book-info{
            padding:10px;
        }

        .book-info h3{
            font-size:16px;
            margin:0 0 5px 0;
        }

        </style>

        <h1>Könyvek</h1>

        <div class="books-grid">
            $cards
        </div>
        HTML;

        return (new LayoutView($content, "Könyvek"))->render();
    }
}