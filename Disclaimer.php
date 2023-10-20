<link rel="stylesheet" href="style.css">
<?php
session_start();
$errorMessage = "";
$checkTerm = "";
if (isset($_POST["start"])) {
    if (empty($_POST["checkTerm"])) {
        $errorMessage = "You must agree to the terms and conditions!";
    } else {
        $_SESSION["checkTerm"] = $_POST["checkTerm"];
        header("Location: CustomerInfo.php");
        exit();
    }
} else {
    $checkTerm = isset($_SESSION["checkTerm"]) ? $_SESSION["checkTerm"] : "";
}
include("./common/header.php");
?>
<div class="container">
    <h1>Terms and Conditions </h1>
    <div class="box">
        <div class="box-item">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</div>
        <div class="box-item">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div>
        <div class="box-item">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</div>
    </div>
    <br/>
    <form action="Disclaimer.php" method="POST">

        <div class="errorTerm">
            <?php echo $errorMessage; ?>
        </div>

        <div class="row">
            <div class="checkTerm">
                <div class="col-md-6">
                    <input type="checkbox" name="checkTerm" value="agreed" <?php if ($checkTerm === 'agreed') echo 'checked'; ?>>
                    <label for="checkTerm">I have read and agreed with terms and conditions.</label>
                </div>
            </div>
        </div>
        <div class = "button">
            <button class = "submitButton" type="submit" name ="start" value = "start">Start</button>
        </div>
    </form>
</div>
<?php include('./common/footer.php'); ?>