<?php

namespace App\Views\Authors;

use App\Views\Layout\LayoutView;

class AuthorFormView
{
    private array $author;

    public function __construct(array $author = [])
    {
        // Ha az API-tól érkező válaszban benne van a 'code' kulcs, távolítsuk el
        unset($author['code']);
        $this->author = $author;
    }

    public function render(): string
    {
        // Biztonságos adatkinyerés (ha nincs adat, üres stringet használunk)
        $id = $this->author['id'] ?? null;
        $nameValue = $this->author['name'] ?? '';
        $bioValue = $this->author['bio'] ?? '';

        // Dinamikus cím és útvonal
        $title = $id ? "Szerző szerkesztése: " . $nameValue : "Új szerző felvétele";
        $action = $id ? "/authors/edit/{$id}" : "/authors/create";

        // Törlés gomb: Csak akkor jelenik meg, ha már létező szerzőről van szó
        $deleteButton = "";
        if ($id) {
            $deleteButton = "<a href=\"/authors/delete/{$id}\" class=\"btn btn-delete\" onclick=\"return confirm('Biztosan törölni szeretné?')\">Törlés</a>";
        }

        $content = <<<HTML
        <style>
        .author-form-container {
            max-width: 900px;
            margin: 40px auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.15);
            padding: 30px;
            display: flex;
            gap: 40px;
        }

        .form-section {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .form-section h1 {
            margin-top: 0;
            color: #333;
        }

        .form-section label {
            font-weight: bold;
            margin-top: 15px;
            display: block;
        }

        .form-section input,
        .form-section textarea {
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
            margin-top: 5px;
            width: 100%;
            box-sizing: border-box;
            font-family: inherit;
        }

        .form-buttons {
            margin-top: 25px;
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 10px 18px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
            text-align: center;
        }

        .btn-save {
            background: #28a745;
            color: white;
        }

        .btn-delete {
            background: #dc3545;
            color: white;
        }

        .btn-back {
            background: #6c757d;
            color: white;
        }
        </style>

        <div class="author-form-container">
            <form method="post" action="{$action}" class="form-section">
                <h1>{$title}</h1>

                <label>Szerző neve</label>
                <input type="text" name="name" value="{$nameValue}" required placeholder="Példa: J.K. Rowling">

                <label>Bio (Életrajz)</label>
                <textarea name="bio" rows="8" placeholder="Írjon egy rövid bemutatkozást a szerzőről...">{$bioValue}</textarea>

                <div class="form-buttons">
                    <button type="submit" class="btn btn-save">Mentés</button>
                    <a href="/authors" class="btn btn-back">Vissza</a>
                    {$deleteButton}
                </div>
            </form>
        </div>
        HTML;

        return (new LayoutView($content, $title))->render();
    }
}