<link rel="stylesheet" href="style.css">
<?php
session_start();

if (!isset($_SESSION["checkTerm"])) {
    header("Location: Disclaimer.php");
    exit();
}
$checkTerm = $_SESSION["checkTerm"];

$errorMessageName = "";
$errorMessagePost = "";
$errorMessagePhone = "";
$errorMessageEmail = "";
$errorMessageContact = "";

$inputName = "";
$inputPost = "";
$inputPhone = "";
$inputEmail = "";
$preferredContactMethod = "";
$phone = "";
$email = "";

$postalCodeRegex = "/[a-z][0-9][a-z]\s*[0-9][a-z][0-9]/i";
$phoneRegex = "/^[2-9]\d{2}-[2-9]\d{2}-\d{4}$/";
$emailRegex = '/^[A-Za-z.0-9]+@[A-Za-z.0-9]+\.[A-Za-z]{2,4}$/';

if (isset($_POST["next"])) {
    $inputName = trim($_POST["inputName"]);
    if (empty($inputName)) {
        $errorMessageName = "Name is required.";
    } else {
        $_SESSION["inputName"] = $inputName;
    }
} else {
    if (isset($_SESSION["inputName"])) {
        $inputName = $_SESSION["inputName"];
    }
}

if (isset($_POST["next"])) {
    $inputPost = trim($_POST["inputPost"]);
    if (empty($inputPost)) {
        $errorMessagePost = "Postal code is required.";
    } elseif (!preg_match($postalCodeRegex, $inputPost)) {
        $errorMessagePost = "Invalid postal code format.";
    } else {
        $_SESSION["inputPost"] = $inputPost;
    }
} else {
    if (isset($_SESSION["inputPost"])) {
        $inputPost = $_SESSION["inputPost"];
    }
}

if (isset($_POST["next"])) {
    $inputPhone = trim($_POST["inputPhone"]);
    if (empty($inputPhone)) {
        $errorMessagePhone = "Phone number is required.";
    } elseif (!preg_match($phoneRegex, $inputPhone)) {
        $errorMessagePhone = "Invalid Phone number format.";
    } else {
        $_SESSION["inputPhone"] = $inputPhone;
    }
} else {
    if (isset($_SESSION["inputPhone"])) {
        $inputPhone = $_SESSION["inputPhone"];
    }
}


if (isset($_POST["next"])) {
    $inputEmail = trim($_POST["inputEmail"]);
    if (empty($inputEmail)) {
        $errorMessageEmail = "Email is required.";
    } elseif (!preg_match($emailRegex, $inputEmail)) {
        $errorMessageEmail = "Invalid email format.";
    } else {
        $_SESSION["inputEmail"] = $inputEmail;
    }
} else {
    if (isset($_SESSION["inputEmail"])) {
        $inputEmail = $_SESSION["inputEmail"];
    }
}



if (isset($_POST["next"])) {
    if (isset($_POST["preferredContactMethod"])) {
        $_SESSION["preferredContactMethod"] = $_POST["preferredContactMethod"];
    } else {
        $errorMessageContact = "Preferred contact message should be selected!";
    }
}

if (isset($_POST["next"])) {
// Check if all error messages are empty
    if (empty($errorMessageName) && empty($errorMessagePost) && empty($errorMessagePhone) && empty($errorMessageEmail) && empty($errorMessageContact)) {
        if ($_SESSION["preferredContactMethod"] === "email") {
            header("Location: DepositCalculator.php");
            exit();
        } elseif ($_SESSION["preferredContactMethod"] === "phone") {
            header("Location: ContactTime.php");
            exit();
        }
    }
}

include("./common/header.php");
?>
<div class="container">
    <h1>Customer Information</h1>

    <div class = "separator"></div>
    <form method="post" action="CustomerInfo.php" class="postForm" id="myForm" >



        <div class="part">
            <label class="name">Name:</label>
            <input class="inputName" type="text" name="inputName" value="<?php echo $inputName; ?>" />
            <div class="error">
                <?php echo $errorMessageName; ?>
            </div>
        </div>
        <div class="part">
            <label class="post">Postal code:</label>
            <input class="inputPost" type="text" name="inputPost" value="<?php echo $inputPost; ?>" />
            <div class="error">
                <?php echo $errorMessagePost; ?>
            </div>
        </div>
        <div class = "part">
            <label class = "phone">Phone number:</label>
            <input class = "inputPhone" type = "tel" name = "inputPhone" value="<?php echo $inputPhone; ?>"/>
            <div class="error">
                <?php echo $errorMessagePhone; ?>
            </div>
        </div>
        <div class = "part">
            <label class = "email">Email address:</label>
            <input class = "inputEmail" type = "text" name = "inputEmail" value="<?php echo $inputEmail; ?>"/>
            <div class="error">
                <?php echo $errorMessageEmail; ?>
            </div>
        </div>
        <div class = "separator"></div>
        <div class="part">
            <div class="contactMetod">
                <label class="contact">Preferred contact method:</label>
                <div class="method">
                    <input type="radio" name="preferredContactMethod" class="preferredContactMethod" value="phone" <?php echo (isset($_SESSION['preferredContactMethod']) && $_SESSION['preferredContactMethod'] === 'phone') ? 'checked' : ''; ?> />
                    <label for="phone" class="preferredContactMethod">Phone</label>

                    <input type="radio" name="preferredContactMethod" class="preferredContactMethod" value="email" <?php echo (isset($_SESSION['preferredContactMethod']) && $_SESSION['preferredContactMethod'] === 'email') ? 'checked' : ''; ?> />
                    <label for="email" class="preferredContactMethod">Email</label>
                </div>
                <div class="errorTerm">
                    <?php echo $errorMessageContact; ?>
                </div>
            </div>
        </div>
        <div class = "button">
            <button class = "submitButton" type="submit" name ="next" value = "next">Next ></button>
        </div>
    </form>
</div>
<?php include('./common/footer.php'); ?>
