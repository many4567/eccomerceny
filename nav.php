<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        nav {
            display: flex;
            background-color:rgb(34, 58, 165);
            color: white;
            padding: 20px;
            position: sticky;
           top: 0; /* Add this line */
           z-index: 1000; /* Optional: keep it above other content */
        }
        nav ul {
            display: flex;
              align-items: center;
            list-style-type: none;
            margin: 0;
            padding: 0;
        }
         nav {
            background: linear-gradient(90deg, #223aa5 60%, #00c6ff 100%);
            padding: 16px 0;
            text-align: center;
            margin-bottom: 0;
        }
        nav a {
            color: #fff;
            margin: 0 18px;
            text-decoration: none;
            font-weight: 500;
            font-size: 1.1em;
            letter-spacing: 0.5px;
            transition: color 0.2s;
        }
        nav a:hover {
            color: #ffe082;
        }
        nav ul li {
            display: inline;
            margin-right: 20px;
        }
        nav ul li a {
            color: white;
            text-decoration: none;
        }
        nav ul li a:hover {
            text-decoration: underline;
        }
        .admin {
            margin-left: auto;
            display: flex;
            align-items: center;
            text-align: right;
            padding: 10px;
        }
        .admin a {
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        li img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 10px;
        }
         nav ul li:first-child {
            display: flex;
             flex-direction: column;
             align-items: center;
             margin-right: 30px;
             text-align: center;
        }

          nav ul li:first-child span {
          margin-left: 10px;
          margin-top: 5px;
          display: block;
        }
       nav ul li:first-child span {
         font-weight: 900;
         font-size: 22px;
         color: rgb(0, 204, 255);
         text-shadow:
        -1px -1px 0 #ffffff,
         1px -1px 0 #ffffff,
        -1px  1px 0 #000,
         1px  1px 0 #000;
          font-family: 'Impact', 'Arial Black', sans-serif;
        letter-spacing: 1.5px;
         transform: scale(1.05);
       }
      /* Add this at the bottom of your existing style */

.menu-toggle {
    display: none;
    background-color: transparent;
    color: white;
    border: none;
    font-size: 26px;
    cursor: pointer;
    margin-left: auto;
    padding: 8px 16px;
}

/* Hide nav items on small screens */
@media (max-width: 768px) {
    nav {
        
        flex-direction: column;
        align-items: flex-start;
    }

    .menu-toggle {
        
        display: block;
    }

    nav ul {
        display: none;
        flex-direction: column;
        width: 100%;
    
    }

    nav ul.show {
        display: flex;
    }

    nav ul li {
        display: block;
        margin: 5px 10px;
    }
    .admin {
    margin-bottom:10px;
     margin-left: 0;
     width: 100%;
    }
}

</style>
<body>
    <nav>
        <button class="menu-toggle" onclick="toggleMenu()">☰</button>

        <ul>
            <li>
            <img src="./img/photo_2025-07-08_10-40-40.jpg" alt="">
            <span style="color:rgb(80, 199, 255);">Power water</span>
           </li>
            <li><a href="index.php">Home</a></li>
            <li><a href="prducts.php">Products</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="contact.php">Contact</a></li>
         </ul>
        <div class="admin">
            <?php if (empty($_SESSION['is_admin'])): ?>
                <a href="admin_contacts.php">Admin Login</a>
            <?php else: ?>
                <a href="?logout=1">Logout</a>
            <?php endif; ?>
    </nav>
    
</body>
<script>
function toggleMenu() {
    const navList = document.querySelector("nav ul");
    navList.classList.toggle("show");
}
</script>

</html>