<?php

namespace Server;

class APIEndpointController
{
    public function parseRequest(): void
    {
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'POST':
                $this->parsePostRequest();
                break;
            case 'GET':
                $this->parseGetRequest();
                break;
            default:
                break;
        }
    }

    private function parsePostRequest(): void
    {
        $data = $_POST;
        if (count($data) == 0) {
            $data = (array)json_decode(file_get_contents('php://input'));
        }
        if (!array_key_exists('action-name', $data)) {
            return;
        }
        $action = $data['action-name'];
        $controller = new ShortLinksController();
        switch ($action) {
            case 'add-url':
                $this->respond($controller->addNewLink($data));
                break;
            case 'update-url':
                $controller->updateLink($data);
                break;
            case 'delete-url':
                $controller->deleteLink($data);
                break;
        }
    }

    private function parseGetRequest(): void
    {
        $data = $_GET;
        if (!array_key_exists('action-name', $data)) {
            return;
        }
        $action = $data['action-name'];
        $controller = new ShortLinksController();
        switch ($action) {
            case 'get-links':
                $this->respond($controller->getAllLinks());
                break;
            case 'get-long-link':
                $this->respond($controller->getLongLink($data));
                break;
            case 'get-short-link':
                $this->respond($controller->getShortLink($data));
                break;
        }
    }

    private function respond($data): void
    {
        echo json_encode($data);
    }
}
