<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome my Ecomer</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      padding: 0;
      background: linear-gradient(to right,rgb(230, 230, 230),rgb(188, 191, 194));
    }

    .header {
      display: flex;
      
      align-items: center;
      padding: 30px 20px 20px;
      flex-wrap: wrap;
    }
    .header h1 {
      flex: 1;
      margin: 0;
    }
    .wee{
      flex: 1;
      text-align: center;
      margin-bottom: 20px;
    }
    .wee a {
      padding: 10px 20px;
      background: #8e44ad;
      color: white;
      border-radius: 5px;
      text-decoration: none;
      font-weight: 500;
      box-shadow: 0 2px 6px rgba(0,0,0,0.2);
      transition: background 0.3s ease;
      
    }

    .header a:hover {
      background: #6c3483;
    }
    
    .index img {
      margin-right: 100px;
       border-radius: 15px;
      /* width: 100%;
      height: 120px; */
      object-fit: cover;
       margin-right: 100px;
 
    }

    select, button {
      padding: 10px 15px;
      font-size: 1em;
      border-radius: 5px;
      border: 1px solid #ccc;
    }

    button {
      background-color: #8e44ad;
      color: white;
      cursor: pointer;
      border: none;
    }

    button:hover {
      background-color: #6c3483;
    }

    h2 {
      text-align: center;
      color: #333;
      margin: 20px 0;
      font-size: 1.8em;
    }

    .products {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 30px;
      padding: 40px 20px;
    }

    .product-card {
      background: white;
      border-radius: 12px;
      box-shadow: 0 4px 16px rgba(0,0,0,0.1);
      text-align: center;
      width: 180px;
      padding: 15px;
      transition: transform 0.2s;
    }

    .product-card:hover {
      transform: scale(1.05);
    }

    .product-card img {
      width: 100%;
      border-radius: 8px;
      height: 150px;
      object-fit: cover;
    }

    .product-card h3 {
      color: #e91e63;
      margin: 10px 0 5px;
      font-size: 1.1em;
    }

    .product-card p {
      font-weight: bold;
      color: #333;
    }

    @media (max-width: 768px) {
      .header {
        flex-direction: column;
        align-items: center;
        text-align: center;
      }

      .products {
        flex-direction: column;
        align-items: center;
        padding: 20px;
      }

      .product-card {
        width: 80%;
        max-width: 300px;
      }

      h2 {
        font-size: 1.5em;
        padding: 0 15px;
      }

      .index img {
        
        width: 100px;
        height: 100px;
      }
    }
  </style>
</head>
<body>

<?php include 'nav.php'; ?>

<div class="header">
  <div class="wee">
    <h1>Welcome to My E-commerce Site</h1>
    <h4>Your one-stop shop for all your needs</h4>
    <a href="">Show Order</a>
  </div>
  
  <hr>
  
  <div class="index">
    <img src="./img/download.png" alt="Profile">
  </div>
</div>

<h2>Featured Products</h2>

<div class="products">
  <div class="product-card">
    <img src="./img/1.jpg" alt="Mixed Bouquet">
    <h3>Kity can</h3>
    <p>$11.00</p>
  </div>
  <div class="product-card">
    <img src="./img/2.jpg" alt="Blue Hydrangea">
    <h3>Lipser can</h3>
    <p>$19.00</p>
  </div>
  <div class="product-card">
    <img src="./img/7.jpg" alt="White Orchid">
    <h3>White Anime</h3>
    <p>$17.00</p>
  </div>
  <div class="product-card">
    <img src="./img/4.jpg" alt="Romantic Lilies">
    <h3>Couple can</h3>
    <p>$25.00</p>
  </div>
  <div class="product-card">
    <img src="./img/5.jpg" alt="Sunflower Joy">
    <h3>SAN can</h3>
    <p>$18.00</p>
  </div>
  <div class="product-card">
    <img src="./img/6.jpg" alt="Pink Roses">
    <h3>Pink Can</h3>
    <p>$20.00</p>
  </div>
</div>

<?php include 'footer.php'; ?>

</body>
<script>
// Animate product cards when page loads
document.addEventListener("DOMContentLoaded", () => {
  const cards = document.querySelectorAll(".product-card");
  cards.forEach((card, index) => {
    card.style.opacity = 0;
    card.style.transform = "translateY(50px)";
    setTimeout(() => {
      card.style.transition = "all 0.6s ease-out";
      card.style.opacity = 1;
      card.style.transform = "translateY(0)";
    }, index * 150);
  });

  // Add bounce animation to profile image
  const profileImg = document.querySelector(".index img");
  if (profileImg) {
    profileImg.style.transition = "transform 0.6s ease";
    profileImg.addEventListener("mouseenter", () => {
      profileImg.style.transform = "scale(1.1)";
    });
    profileImg.addEventListener("mouseleave", () => {
      profileImg.style.transform = "scale(1)";
    });
  }
});
</script>

</html>
