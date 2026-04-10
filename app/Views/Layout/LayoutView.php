<?php

namespace App\Views\Layout;

class LayoutView
{
    public function __construct(
        private string $content,
        private string $title = "REST kliens"
    ) {}

    public function render(): string
    {
        return <<<HTML
        <!DOCTYPE html>
        <html lang="hu">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>{$this->title}</title>

            <link rel="stylesheet" href="/assets/style.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
        </head>

        <body>
            <style>
                body {
                    background-color: #f9f9f9;
                    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                    color: #333;
                    margin: 0;
                    padding: 0;
                }

                .container {
                    max-width: 1200px;
                    margin: 0 auto;
                    padding: 20px;
                }
                h1 {
                    color: #007bff;
                    margin-bottom: 20px;
                }

                
            </style>
            {$this->renderMenu()}

            <main class="container">
                {$this->content}
            </main>

        </body>
        </html>
        HTML;
    }

    private function renderMenu(): string
    {
        return <<<HTML
                <style>
            .navbar {
                display: flex;
                justify-content: center;
                align-items: center;
                background-color: #ffffff;
                padding: 15px 30px;
                margin-bottom: 30px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
                border-radius: 0 0 15px 15px; /* Csak az alja lekerekített */
                gap: 20px;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            }

            .navbar a {
                text-decoration: none;
                color: #555;
                font-weight: 600;
                font-size: 16px;
                padding: 10px 20px;
                border-radius: 8px;
                transition: all 0.3s ease;
                position: relative;
            }

            /* Hover hatás: háttérszín változás */
            .navbar a:hover {
                background-color: #f0f4f8;
                color: #007bff;
            }

            /* Az éppen aktív (vagy hangsúlyos) link stílusa */
            .navbar a::after {
                content: '';
                position: absolute;
                bottom: 5px;
                left: 50%;
                width: 0;
                height: 2px;
                background-color: #007bff;
                transition: width 0.3s ease, left 0.3s ease;
            }

            .navbar a:hover::after {
                width: 30px;
                left: calc(50% - 15px);
            }
            
            /* Mobilbarát megoldás: ha keskeny a kijelző, törje több sorba */
            @media (max-width: 600px) {
                .navbar {
                    flex-wrap: wrap;
                    gap: 10px;
                    padding: 10px;
                }
                .navbar a {
                    font-size: 14px;
                    padding: 8px 12px;
                }
            }
        </style>

        <nav class="navbar">
            <a href="/books">Könyvek</a>
            <a href="/authors">Írók</a>
            <a href="/categories">Kategóriák</a>
            <a href="/publishers">Kiadók</a>
            <a href="/series">Szériák</a>
        </nav>
        HTML;
    }
}