<?php
include '../db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    // Get image path
    $query = "SELECT image FROM products WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $product = mysqli_fetch_assoc($result);

    if ($product) {
        $imagePath = $product['image'];
        if (file_exists($imagePath)) {
            unlink($imagePath); // Delete image
        }

        // Delete from DB
        $deleteQuery = "DELETE FROM products WHERE id = $id";
        if (mysqli_query($conn, $deleteQuery)) {
            echo "<script>alert('Product deleted successfully'); window.location.href='products.php';</script>";
        } else {
            echo "<script>alert('Error deleting product'); window.location.href='products.php';</script>";
        }
    } else {
        echo "<script>alert('Product not found'); window.location.href='products.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request'); window.location.href='products.php';</script>";
}
?>
