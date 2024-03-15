<?php

namespace zswi\Views;

class AuthPageView implements IView
{

    public function printOutput(array $templateData, string $pageType): string
    {
        if (isset($_SESSION["user"])) {
            echo "<p>You are logged in.</p><br><a href='?page=auth&logout'>Logout</a>";
            return "";
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
                <label>Name:</label>
                <input type="text" name="name">
                <br>
                <input type="submit" name="register" value="register">
            </form>

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
<?php
        }




        return "";
    }
}