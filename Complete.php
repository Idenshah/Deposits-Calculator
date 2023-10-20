<link rel="stylesheet" href="style.css">
<?php 
    session_start(); 	// retrieve PHP session!
    if (!isset($_SESSION["principalAmount"]))
    {
            header("Location: DepositCalculator.php");
            exit();
    }
    if (!isset($_SESSION["yearsToDeposit"]))
    {
            header("Location: DepositCalculator.php");
            exit();
    }
    include("./common/header.php"); 
?>
<div class="container">	
    <h1>Thank you, <span class="text-primary"><?php echo $_SESSION["inputName"]; ?></span>, for using our deposit calculation tool.</h1>

    <?php
    if ($_SESSION["preferredContactMethod"] === "email") {
        echo "<p class='commentFinal'>An email about the detail of our GIC has been sent to " . $_SESSION["inputEmail"] . ".</p>";
    } else {
        // Display selected time slots as a comma-separated list
        $selectedTimeSlots = implode(", ", $_SESSION["selectedTimeSlots"]);
        echo "<p class='commentFinal'>Our customer service department will call you tomorrow " . $selectedTimeSlots . " at " . $_SESSION["inputPhone"] . ".</p>";
    }
    ?>

    <?php session_destroy(); ?>
</div>
<?php include('./common/footer.php'); ?>
