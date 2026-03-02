<?php

namespace App\Views\Counties;

use App\Views\Layout\LayoutView;

class EditView
{
    public function __construct(private array $county) {}

    public function render(): string
    {
        $county = $this->county['entity'];
        $id = $county["id"];
        $name = htmlspecialchars($county["name"]);

        $content = <<<HTML
        <h1>Megye módosítása</h1>

        <form method="post" action="/counties/edit/{$id}" class="form">

            <label for="name">Megye neve</label>
            <input type="text" id="name" name="name" value="{$name}" required>

            <br><br>

            <button type="submit" class="btn btn-primary">Mentés</button>
            <a href="/counties" class="btn btn-secondary">Mégse</a>

        </form>
        HTML;

        return (new LayoutView($content, "Megye módosítása"))->render();
    }
}