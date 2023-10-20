<link rel="stylesheet" href="style.css">
<?php
session_start();

// Check if required session variables exist, redirect if not
$requiredSessionVariables = ["inputName", "inputPost", "inputPhone", "inputEmail", "preferredContactMethod", "checkTerm"];
foreach ($requiredSessionVariables as $variable) {
    if (!isset($_SESSION[$variable])) {
        header("Location: CustomerInfo.php");
        exit();
    }
}

$checkTerm = $_SESSION["checkTerm"];

$selectedTimeSlots = [];
$errorMessageTimeSlots = "";

// Initialize an array in the session to store the selected time slots
if (!isset($_SESSION["selectedTimeSlots"])) {
    $_SESSION["selectedTimeSlots"] = [];
}

if (isset($_POST["next"])) {
    if (isset($_POST["hour"]) && is_array($_POST["hour"])) {
        // Get the selected time slots
        $selectedTimeSlots = $_POST["hour"];

        // Add the selected time slots to the session array
        $_SESSION["selectedTimeSlots"] = $selectedTimeSlots;
    } else {
        $errorMessageTimeSlots = "At least one contact time must be selected!";
    }
}

// Check if all error messages are empty
if (isset($_POST["next"]) && empty($errorMessageTimeSlots)) {
    header("Location: DepositCalculator.php");
    exit();
}
if (isset($_POST["back"]) && empty($errorMessageTimeSlots)) {
    header("Location: CustomerInfo.php");
    exit();
}

include("./common/header.php");
?>
<div class="container">
    <h1>Select Contact Time</h1>

    <form method="post" action="ContactTime.php" class="postForm" id="myForm" >
        <p>When can we contact you? Check all applicable:</p>


        <div class="errorContactTime">
            <?php echo $errorMessageTimeSlots; ?>
        </div>
        <div class="partTime">
            <?php
            $timeSlots = [
                "9:00 am - 10:00 am",
                "10:00 am - 11:00 am",
                "11:00 am - 12:00 pm",
                "12:00 pm - 1:00 pm",
                "1:00 pm - 2:00 pm",
                "2:00 pm - 3:00 pm",
                "3:00 pm - 4:00 pm",
                "4:00 pm - 5:00 pm",
                "5:00 pm - 6:00 pm"
            ];

            foreach ($timeSlots as $timeSlot) {
                $isChecked = in_array($timeSlot, $_SESSION["selectedTimeSlots"]);
                ?>
                <div class="row">
                    <input type="checkbox" name="hour[]" value="<?= $timeSlot ?>" id="<?= $timeSlot ?>" <?= $isChecked ? 'checked' : '' ?>>
                    <label for="<?= $timeSlot ?>"><?= $timeSlot ?></label>
                </div>
                <?php
            }
            ?>

        </div>
        <div class="contactButton ">
            <div class="button">
                <button class="submitButton" type="submit" name="back" value="back">< back </button>
            </div>
            <div class="next">
            <div class="button">
                <button class="submitButton" type="submit" name="next" value="next">Next ></button>
            </div>
                </div>
        </div>

    </form>
</div>
<?php include('./common/footer.php'); ?>
