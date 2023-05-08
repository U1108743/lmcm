<?php include '../view/grower_login/login_header.php' ?>
<main class="wrapper">

    <section class="sign">
        <article id="loginWin">
            <form action="grower_login_controller.php" method="post">
                <input type="hidden" name='action' value='grower_authenticate'>

                <label for="grower_number">Grower Number</label>
                <input type="number" id="number" name="grower_number" required>
                <label for="password">Password</label>
                <div id="pwdWrap">
                    <input type="password" id="password" name="password" required>
                </div>
                <div>
                    <button type="submit" class="Btn">Login</button>
                </div>
            </form>

            <?php
            $session = filter_input(INPUT_GET, 'session');
            $auth = filter_input(INPUT_GET, 'authentication');
            if (isset($session) && $session == 'expired') {
                echo "<div class='login_message'>";
                echo "<p>Due to inactivity your session as expired and you have been logged out</p>";
                echo "</div>";
            }
            if (isset($auth) && $auth == 'failed') {
                echo "<div class='login_message'>";
                echo "<p>Your username or password is incorrect</p>";
                echo "</div>";
            }
            ?>

        </article>


    </section>
</main>

<?php include '../view/common/footer.php' ?>