<!-- This will be the code for the menu that appears on all pages in the website: -->
 
<!-- Adding a logo, search icon and menu: -->
<a href="index.php"><image class="logo" src="images/logo.jpg" alt="Lights Out"></a>

<!-- Creating a menu for mobile view: -->
<input type="checkbox" id="menu-bar">
<label for="menu-bar">Menu</label>

<!--Creating a clickable menu that navigates to the home, products, blog, contact_us and account pages:-->
<nav class="navbar">
    <ul>
        <li><a href="index.php"><span class="menu-item">Home</span></a></li>
        <li><a href="products.php">Products</a></li>
        <li><a href="blog.php">Blog</a></li>
        <li><a href="contact_us.php">Contact Us</a></li>
        <li><a href="account.php">Account</a>
            <ul>
                <!-- Enclosing the submenu in a php if statement -->
                <!-- The submenu will only show once the user has been logged in: -->
                <?php
                    if(isset($_SESSION['email'])): ?>
                        <li><a href="manage_account.php">Manage Account</a></li>
                        <li><a href="logout.php" onclick="return confirm('Are you sure that you want to logout?')">Logout</a></li>
                <?php endif; ?>  
            </ul>
        </li>
        <li> <!-- Only display the cart if the person logged in is a user: -->
            <?php if(isset($_SESSION['users']) && $_SESSION['users']==true): ?>
                <a href="user_cart.php"><image class="cart" src="images/cart.png" alt="My Cart"></a>
            <?php endif; ?>
        </li>
    </ul>
</nav>