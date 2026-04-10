<?php

namespace App\Controllers;

use App\Http\ApiRequest;
use App\Views\Authors\AuthorsView;
use App\Views\Authors\BookFormView;
use App\Views\Authors\AuthorFormView;

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
                "name" => $_POST["name"],
                "bio" => $_POST["bio"]
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
                "bio" => $_POST["bio"],
            ]);

            header("Location: /authors");
            exit;
        }

        $author = $this->api->get("/authors/$id");
        return (new AuthorFormView($author))->render();
    }

    public function delete(?int $id): void
    {
        $this->api->delete("/authors/$id");

        header("Location: /authors");
        exit;
    }
}