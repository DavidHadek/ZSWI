<?php

namespace zswi\Views;

use zswi\Modules\MyLogger;

class AuthPageView implements IView
{
    private $logger;
    private $user;

    public function printOutput(array $templateData, string $pageType): string
    {
        $logger = new MyLogger();
        if ($logger->isUserLogged()) {
            $user = $logger->getLoggedUserData();
            echo "<p>You are logged in.</p><br><a href='?page=auth&logout'>Logout</a>";
            return "";
        }

        if (isset($templateData["alert-msg"])) {
            $msg = $templateData["alert-msg"];
            if ($msg == "SUCCESS") {
                echo "<div class='alert alert-success'>$msg</div>";
            } else {
                echo "<div class='alert alert-danger'>$msg</div>";
            }
        }

        if (isset($templateData["part"]) && $templateData["part"] == "register") {
            ?>

            <form action="?page=auth" method="post">
                <label>*Email:</label>
                <input type="email" name="email" required>
                <br>
                <label>*Username:</label>
                <input type="text" name="username" required>
                <br>
                <label>*Password:</label>
                <input type="password" name="password" required>
                <br>
                <label>*Repeat password:</label>
                <input type="password" name="password-check" required>
                <br>
                <label>Name:</label>
                <input type="text" name="name">
                <br>
                <input type="submit" name="register" value="register">
            </form>
            <br>
            <a href="?page=auth&part=login">I already have an account</a>

<?php
        } else {
            ?>
            <form action="?page=auth" method="post">
                <label>*Username:</label>
                <input type="text" name="username" required>
                <br>
                <label>*Password:</label>
                <input type="password" name="password" required>
                <br>
                <input type="submit" name="login" value="login">
            </form>
            <br>
            <a href="?page=auth&part=register">I don't have an account</a>
<?php
        }




        return "";
    }
}