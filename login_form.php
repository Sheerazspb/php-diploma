<header class="header header_login">
    <div class="header-img-globe">
        <h1><?=Config::TITLE ?></h1>
         <img src="./img/globe.gif" alt="globe" class="globe-img">
        </div>
</header>
<div class="login-content">
    <div class="login-form-wrap">
        <h2 class="login-form-title">Sign in</h2>
        <form class="login-form" action="auth.php" method="POST">
            <input type="text" name="login" placeholder="Email" required>
            <br/>
            <input type="password" name="password" placeholder="Password" required>
            <br/>
            <input type="submit" value="Enter">
        </form>
    </div>
</div>