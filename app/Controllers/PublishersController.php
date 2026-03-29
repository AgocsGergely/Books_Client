<?php

namespace App\Controllers;

use App\Http\ApiRequest;
use App\Views\Publishers\PublishersView;
use App\Views\Publishers\PublisherFormView;

class PublishersController
{
    private ApiRequest $api;

    public function __construct()
    {
        $this->api = new ApiRequest();
    }

    public function index(): string
    {
        $publishers = $this->api->get("/publishers");
        return (new PublishersView($publishers))->render();
    }

    public function create(): string
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $this->api->post("/publishers", [
                "name" => $_POST["name"],
                "address" => $_POST["address"] ?? null
            ]);

            header("Location: /publishers");
            exit;
        }

        return (new PublisherFormView())->render();
    }

    public function edit(?int $id): string
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $this->api->put("/publishers/$id", [
                "name" => $_POST["name"],
                "address" => $_POST["address"] ?? null
            ]);

            header("Location: /publishers");
            exit;
        }

        $publisher = $this->api->get("/publishers/$id");
        return (new PublisherFormView($publisher))->render();
    }

    public function delete(?int $id): void
    {
        $this->api->delete("/publishers/$id");
        header("Location: /publishers");
        exit;
    }
}