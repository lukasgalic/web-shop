<?php
   session_start();
   
   if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        // Redirect to login page
        header('Location: login.php');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Webshop</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        header {
            background: #2c3e50;
            color: white;
            padding: 1rem;
            position: sticky;
            top: 0;
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
        }

        .cart-preview {
            background: #34495e;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            cursor: pointer;
        }

        main {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .products {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 2rem;
        }

        .product {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 1rem;
            text-align: center;
        }

        .product img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 4px;
        }

        .product h3 {
            margin: 1rem 0;
            color: #2c3e50;
        }

        .price {
            color: #16a085;
            font-weight: bold;
            margin: 0.5rem 0;
        }

        button {
            background: #3498db;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button:hover {
            background: #2980b9;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <h1>Welcome <?php echo $_SESSION['username']?></h1>
            <h2>SimpleShop</h1>
            <div class="cart-preview">
                🛒 Cart (3 items)
            </div>
        </nav>
    </header>

    <main>
        <div class="products">
            <div class="product">
                <img src="/api/placeholder/250/200" alt="Product 1">
                <h3>Wireless Headphones</h3>
                <p class="price">$99.99</p>
                <button>Add to Cart</button>
            </div>
            <div class="product">
                <img src="/api/placeholder/250/200" alt="Product 2">
                <h3>Smart Watch</h3>
                <p class="price">$199.99</p>
                <button>Add to Cart</button>
            </div>
            <div class="product">
                <img src="/api/placeholder/250/200" alt="Product 3">
                <h3>Bluetooth Speaker</h3>
                <p class="price">$79.99</p>
                <button>Add to Cart</button>
            </div>
            <div class="product">
                <img src="/api/placeholder/250/200" alt="Product 4">
                <h3>Power Bank</h3>
                <p class="price">$49.99</p>
                <button>Add to Cart</button>
            </div>
        </div>
    </main>
</body>
</html>