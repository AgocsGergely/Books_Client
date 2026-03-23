<?php

namespace App\Controllers;

use App\Http\ApiRequest;
use App\Views\Authors\AuthorsView;
use App\Views\Authors\BookFormView;

class AuthorsController
{
    private ApiRequest $api;

    public function __construct()
    {
        $this->api = new ApiRequest();
    }

    public function index(): string
    {
        $authors = $this->api->get("/authors");
        return (new AuthorsView($authors))->render();
    }

    public function create(): string
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $this->api->post("/authors", [
                "name" => $_POST["name"]
                
            ]);

            header("Location: /authors");
            exit;
        }

        return (new AuthorFormView())->render();
    }

    public function edit(?int $id): string
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $this->api->put("/authors/$id", [
                "name" => $_POST["name"],
                "release_year" => $_POST["release_year"],
                "description" => $_POST["description"]
            ]);

            header("Location: /authors");
            exit;
        }

        $book = $this->api->get("/authors/$id");
        return (new AuthorFormView($book))->render();
    }

    public function delete(?int $id): void
    {
        $this->api->delete("/authors/$id");

        header("Location: /authors");
        exit;
    }
}