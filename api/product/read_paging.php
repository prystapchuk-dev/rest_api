<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/core.php';
include_once '../shared/utilites.php';
include_once '../config/database.phpp';
include_once '../objects/product.php';

$utiltites = new Utilites();

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);

$stmt = $product->readPaging($from_record_num, $records_per_page);
$num = $stmt->rowCount();

if ($num > 0) {

    $product_arr = array();
    $product_arr['records'] = array();
    $product_arr['paging'] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $product_item = array(
            "id" => $id,
            "name" => $name,
            "description" => html_entity_decode($desciption),
            "price" => $price,
            "category_id" => $category_id,
            "category_name" => $category_name
        );

        array_push($product_arr['records'], $product_item);

    }

    $total_rows = $product->count();
    $page_url = "{$home_url}product/read_paging.php";
    $paging = $utiltites->getPaging($page, $total_rows, $records_per_page, $page_url);
    $product_arr['paging'] = $paging;

    http_response_code(200);

    echo json_encode($product_arr);

} else {

    http_response_code(404);

    echo json_encode(array("message" => "Товары не найдены."), JSON_UNESCAPED_UNICODE);
}