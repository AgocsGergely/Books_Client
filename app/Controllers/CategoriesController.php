<?php
namespace App\Controllers;

use App\Http\ApiRequest;
use App\Views\Categories\CategoriesView;
use App\Views\Categories\CategoryFormView;

class CategoriesController
{
    private ApiRequest $api;

    public function __construct()
    {
        $this->api = new ApiRequest();
    }

    public function index(): string
    {
        $categories = $this->api->get("/categories");
        return (new CategoriesView($categories))->render();
    }

    public function create(): string
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $this->api->post("/categories", [
                "name" => $_POST["name"]
            ]);

            header("Location: /categories");
            exit;
        }

        return (new CategoryFormView())->render();
    }

    public function edit(?int $id): string
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $this->api->put("/categories/$id", [
                "name" => $_POST["name"]
            ]);

            header("Location: /categories");
            exit;
        }

        $category = $this->api->get("/categories/$id");
        return (new CategoryFormView($category))->render();
    }

    public function delete(?int $id): void
    {
        $this->api->delete("/categories/$id");
        header("Location: /categories");
        exit;
    }
}