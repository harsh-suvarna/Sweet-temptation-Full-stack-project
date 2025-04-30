<?php
session_start();

$data = json_decode(file_get_contents("php://input"), true);

if ($data && is_array($data)) {
    foreach ($data as $item) {
        $index = (int)$item['index'];
        $quantity = max(1, (int)$item['quantity']);
        if (isset($_SESSION['cart'][$index])) {
            $_SESSION['cart'][$index]['quantity'] = $quantity;
        }
    }
    echo json_encode(["status" => "success"]);
}
?>
