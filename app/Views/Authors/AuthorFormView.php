<?php

namespace App\Views\Authors;

use App\Views\Layout\LayoutView;

class AuthorFormView
{
    private array $author;

    public function __construct(array $author)
    {
        $this->author = $author;
    }

    public function render(): string
    {
        $content = <<<HTML

        <style>

        .author-form-container{
            max-width:900px;
            margin:40px auto;
            background:white;
            border-radius:12px;
            box-shadow:0 6px 20px rgba(0,0,0,0.15);
            padding:30px;
            display:flex;
            gap:40px;
        }

        .author-cover{
            width:250px;
            border-radius:10px;
            box-shadow:0 4px 15px rgba(0,0,0,0.3);
        }

        .form-section{
            flex:1;
            display:flex;
            flex-direction:column;
        }

        .form-section label{
            font-weight:bold;
            margin-top:10px;
        }

        .form-section input,
        .form-section textarea{
            padding:8px;
            border-radius:6px;
            border:1px solid #ccc;
            margin-top:5px;
        }

        .form-buttons{
            margin-top:20px;
            display:flex;
            gap:10px;
        }

        .btn{
            padding:8px 14px;
            border:none;
            border-radius:6px;
            cursor:pointer;
            text-decoration:none;
            font-size:14px;
        }

        .btn-save{
            background:#28a745;
            color:white;
        }

        .btn-delete{
            background:#dc3545;
            color:white;
        }

        .btn-back{
            background:#6c757d;
            color:white;
        }

        </style>
        <div class="author-form-container">


            <form method="post" action="/authors/edit/{$this->author['id']}" class="form-section">

                <label>Szerző neve</label>
                <input type="text" name="name" value="{$this->author['name']}" required>

                <label>Bio</label>
                <textarea name="bio" rows="6">{$this->author['bio']}</textarea>

                <div class="form-buttons">
                    <button type="submit" class="btn btn-save">Mentés</button>
                    <a href="/authors" class="btn btn-back">Vissza</a>
                    <a href="/authors/delete/{$this->author['id']}" class="btn btn-delete">Törlés</a>
                </div>

            </form>

        </div>

        HTML;

        return (new LayoutView($content, $this->author['name']))->render();
    }
    
}

