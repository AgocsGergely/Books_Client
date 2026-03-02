<?php

namespace App\Views\Counties;

use App\Views\Layout\LayoutView;

class IndexView
{
    public function __construct(private array $counties) {}

    public function render(): string
    {
        $rows = array_map(fn($c) => $this->renderRow($c), $this->counties['entities']);
        $rowsHtml = implode("", $rows);

        $content = <<<HTML
        <h1>Megyék</h1>

        {$this->renderSearchBar()}

        <a href="/counties/create" class="btn btn-primary">Új megye</a>
        <br><br>

        <table class="table">
            {$this->renderTableHead()}
            <tbody>
                {$rowsHtml}
            </tbody>
        </table>
        HTML;

        return (new LayoutView($content, "Megyék"))->render();
    }

    private function renderTableHead(): string
    {
        return <<<HTML
        <thead>
            <tr>
                <th>#</th>
                <th>Megnevezés</th>
                <th class="text-right">Műveletek</th>
            </tr>
        </thead>
        HTML;
    }

    private function renderRow(array $c): string
    {
        $id = $c["id"];
        $name = htmlspecialchars($c["name"]);

        return <<<HTML
        <tr>
            <td>{$id}</td>
            <td>{$name}</td>
            <td class="text-right">
                <a href="/counties/edit/{$id}" class="btn btn-sm btn-warning">Szerkesztés</a>
                <a href="/counties/delete/{$id}" class="btn btn-sm btn-danger" onclick="return confirm('Biztos törlöd?')">Törlés</a>
            </td>
        </tr>
        HTML;
    }

    private function renderSearchBar(): string
    {
        return <<<HTML
        <form method="get" action="/counties" class="search-bar">
            <input type="search" name="needle" placeholder="Keresés..." class="search-input">
            <button type="submit" class="btn btn-secondary">Keres</button>
        </form>
        <br>
        HTML;
    }
}