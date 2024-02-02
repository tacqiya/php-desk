<?php
use App\Api\API;
require 'vendor/autoload.php';

$db = new Database();
$api = new API($db);
$method = $_SERVER['REQUEST_METHOD'];
$url = $_SERVER['REQUEST_URI'];
$path = parse_url($url, PHP_URL_PATH);
$parts = explode('/', $path);
switch ($method) {
    case 'GET':
        if (preg_match('/\/quote\/([a-z]+)$/', $url, $matches)) {
            $api->get_quote($matches[1]);
        } elseif (preg_match('/\/carteira\/([a-z0-9\-]+)$/', $url, $matches)) {
            $api->getCarteira($matches[1]);
        }
         elseif (preg_match('/\/money\/([a-z0-9\-]+)$/', $url, $matches)) { 
            $api->getMoney($matches[1]);
        }
        break;
    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        if (preg_match('/\/update\/([a-z]+)$/', $url, $matches)) {
            $api->get_quote($matches[1]);
        } elseif (preg_match('/\/carteira$/', $url)) { 
            $api->createCarteira($data);
        }
        elseif (preg_match('/\/money$/', $url)) { 
            $api->initializeMoney($data);
        }
        elseif (preg_match('/\/moneycompra\/([a-z0-9\-]+)$/', $url, $matches)) { 
            $api->updateMoney($matches[1], $data);
        }
        break;
    case 'PUT':
        $data = json_decode(file_get_contents('php://input'), true);
        if (preg_match('/\/carteira\/([a-z0-9\-]+)$/', $url, $matches)) {
            $api->updateCarteira($matches[1], $data);
        }
        break;
    case 'DELETE':
        if (preg_match('/\/carteira\/([a-z0-9\-]+)$/', $url, $matches)) {
            $api->deleteCarteira($matches[1]);
        }
        break;
    default:
        http_response_code(405);
        echo json_encode(["error" => "Método não permitido"]);
        break;
}