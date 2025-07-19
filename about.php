<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>About Water Usage</title>
    <style>
        /* body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #e3f2fd;
           
        } */
         /* .container img {
            max-width: 30000px;
            margin: auto;
           
        } */
          .container{
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }  

        h2 {
            color: #0277bd;
        }
@media (max-width: 600px) {
            .container {
                margin: 10px;
                padding: 15px;
            }
        } 
    </style>
</head>
<body>

<header>
    
</header>
<?php include 'nav.php'; ?>
<div class="about">
    <div class="container">
    <h2>Importance of Water</h2>
    <p>Water is essential for all living organisms. It supports life, health, agriculture, and industry. Without clean water, survival and development are impossible.</p>

    <h2>How We Use Water</h2>
    <ul>
        <li><strong>Drinking & Cooking:</strong> Essential for human survival.</li>
        <li><strong>Sanitation:</strong> Bathing, washing, and cleaning.</li>
        <li><strong>Agriculture:</strong> Irrigating crops and raising livestock.</li>
        <li><strong>Industry:</strong> Cooling, processing, and manufacturing.</li>
        <li><strong>Energy:</strong> Hydropower and thermal plant operations.</li>
    </ul>
    <img src="./img/7.jpg" alt="Water Usage Image">
    <img src="./img/9.jpg" alt="Water Usage Image">
    <h2>Tips to Save Water</h2>
    <ol>
        <li>Turn off the tap when not in use.</li>
        <li>Repair leaks immediately.</li>
        <li>Use water-efficient appliances.</li>
        <li>Collect and reuse rainwater.</li>
        <li>Educate others about water conservation.</li>
    </ol>

    <p>Together, we can protect our planet by using water wisely.</p>
    <p>&copy; <?php echo date("Y"); ?> Water Awareness Organization</p>
</div>
</div>
<?php include 'footer.php'; ?>
</body>
<script>
// Animate the main container on load
document.addEventListener("DOMContentLoaded", () => {
  const container = document.querySelector(".container");
  container.style.opacity = 0;
  container.style.transform = "translateY(30px)";
  container.style.transition = "all 1s ease";

  setTimeout(() => {
    container.style.opacity = 1;
    container.style.transform = "translateY(0)";
  }, 200);
  
  // Animate images on hover
  const images = container.querySelectorAll("img");
  images.forEach(img => {
    img.style.transition = "transform 0.4s ease";
    img.addEventListener("mouseenter", () => {
      img.style.transform = "scale(1.05)";
    });
    img.addEventListener("mouseleave", () => {
      img.style.transform = "scale(1)";
    });
  });
});
</script>

</html>
