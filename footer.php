


<footer class="footer">
    <div id="car-icon">🚗</div>

    <div class="footer-container">
        <!-- Company Info -->
        <div class="footer-section">
            <h3>E-Commerce</h3>
            <p>សូមអរគុណសម្រាប់ការគាំទ្ររបស់អ្នក!</p>
            <p>យើងប្តេជ្ញាផ្ដល់សេវាកម្មដែលមានគុណភាពខ្ពស់ជានិច្ច។</p>
        </div>

        <!-- Quick Links -->
        <div class="footer-section">
            <h4>Quick Links</h4>
            <ul>
                <li><a href="index.php">🏠 Home</a></li>
                <li><a href="prducts.php">🛍️ Products</a></li>
                <li><a href="contact.php">📞 Contact</a></li>
                <li><a href="order.php">📝 Order</a></li>
            </ul>
        </div>

        <!-- Contact Info -->
        <div class="footer-section">
            <h4>Contact Us</h4>
            <p>📍 Phnom Penh, Cambodia</p>
            <p>📞 012 345 678</p>
            <p>✉️ info@ecommerce.com</p>
        </div>

        <!-- Social Media -->
        <div class="footer-section">
            <h4>Follow Us</h4>
            <div class="social-icons">
                <a href="#" title="Facebook">🌐</a>
                <a href="#" title="Twitter">🐦</a>
                <a href="#" title="Instagram">📸</a>
            </div>
        </div>
    </div>
​​​​​​​     
    <!-- <div class="footer-bottom">
        &copy; <?php echo date("Y"); ?> E-Commerce. All rights reserved.
    </div> -->
</footer>

<style>
    .footer {
    background: linear-gradient(90deg, #00c6ff 10%, #223aa5 100%);
    color: #fff;
    padding: 32px 0 12px 0;
    margin-top: 40px;
    font-family: 'Segoe UI', Arial, sans-serif;
} 
/* .footer {
    background-color: #0d47a1;
    color: white;
    font-family: 'Khmer OS Battambang', sans-serif;
    padding: 40px 20px 20px;
} */

.footer-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    max-width: 1200px;
    margin: auto;
}

.footer-section {
    flex: 1 1 220px;
    margin: 20px;
}

.footer-section h3, .footer-section h4 {
    margin-bottom: 10px;
    color: #ffeb3b;
}

.footer-section p, .footer-section li {
    margin: 6px 0;
    font-size: 15px;
}

.footer-section ul {
    list-style: none;
    padding: 0;
}

.footer-section a {
    color: #fff;
    text-decoration: none;
}

.footer-section a:hover {
    text-decoration: underline;
    color: #ffeb3b;
}

.social-icons a {
    margin-right: 10px;
    font-size: 20px;
}

.footer-bottom {
    text-align: center;
    padding-top: 20px;
    font-size: 14px;
    border-top: 1px solid rgba(255, 255, 255, 0.2);
    margin-top: 30px;
    color: #ccc;
}

@media (max-width: 768px) {
    .footer-container {
        flex-direction: column;
        align-items: center;
    }

    .footer-section {
        text-align: center;
        margin-bottom: 30px;
    }
}
#car-icon::after {
    content: "";
    position: absolute;
    font-size: 50px;
    top: 30px;       
    right: 40px;       
    width: 8px;
    height: 8px;
    background: yellow;
    border-radius: 45%;
    box-shadow: 0 0 8px 2px yellow;
    animation: blinkLight 1.5s infinite;
} 

/* blinking animation */
@keyframes blinkLight {
    0%, 50%, 100% {
        opacity: 1;
        box-shadow: 0 0 8px 2px yellow;
    }
    25%, 75% {
        opacity: 0.3;
        box-shadow: none;
    }
}

@keyframes drive {
    0% {
        left: 0;
        /* no transform */
    }
    100% {
        left: calc(100% - 50px);
        /* no transform */
    }
}

#car-icon {
    position: fixed;
    bottom: 20px;
    left: 0;
    font-size: 32px;
    z-index: 9999;
    animation: drive 12s ease-in-out infinite alternate;
    position: fixed;
}


</style>


