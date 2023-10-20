<link rel="stylesheet" href="style.css">
<?php
session_start();

if (!isset($_SESSION["inputName"])) {
    header("Location: CustomerInfo.php");
    exit();
}
if (!isset($_SESSION["inputPost"])) {
    header("Location: CustomerInfo.php");
    exit();
}
if (!isset($_SESSION["inputPhone"])) {
    header("Location: CustomerInfo.php");
    exit();
}
if (!isset($_SESSION["inputEmail"])) {
    header("Location: CustomerInfo.php");
    exit();
}
if (!isset($_SESSION["preferredContactMethod"])) {
    header("Location: CustomerInfo.php");
    exit();
}

$principalAmount = "";
$yearsToDeposit = "";

$errorMessageprincipalAmount = "";
$errorMessageyearsToDeposit = "";

$principalAmountRegex = "/^(?:0*[1-9]+\d*(\.\d+)?)$/";
$yearsToDepositRegex = "/^([1-9]|1\d|2[0-5])$/";

if (isset($_POST["Calculate"])) {
    $principalAmount = trim($_POST["principalAmount"]);
    if (empty($principalAmount)) {
        $errorMessageprincipalAmount = "principal amount is required.";
    } elseif (!preg_match($principalAmountRegex, $principalAmount)) {
        $errorMessageprincipalAmount = "Principal Amount must be a numeric value greater than zero.";
    } else {
        $_SESSION["principalAmount"] = $principalAmount;
    }
} else {
    if (isset($_SESSION["principalAmount"])) {
        $principalAmount = $_SESSION["principalAmount"];
    }
}

if (isset($_POST["Calculate"])) {
    $yearsToDeposit = trim($_POST["yearsToDeposit"]);
    if (empty($yearsToDeposit)) {
        $errorMessageyearsToDeposit = "Years to deposit is required.";
    } elseif (!preg_match($yearsToDepositRegex, $yearsToDeposit)) {
        $errorMessageyearsToDeposit = "Please select between 1 to 25 years.";
    } else {
        $_SESSION["yearsToDeposit"] = $yearsToDeposit;
    }
} else {
    if (isset($_SESSION["yearsToDeposit"])) {
        $yearsToDeposit = $_SESSION["yearsToDeposit"];
    }
}

if (isset($_POST["Complete"])) {
    if (empty($errorMessageprincipalAmount) && empty($errorMessageyearsToDeposit)) {
        header("Location: Complete.php");
        exit();
    }
}


if (isset($_POST["previous"])) {
    if ($_SESSION["preferredContactMethod"] === "phone") {
        header("Location: ContactTime.php");
        exit();
    } else {
        header("Location: CustomerInfo.php");
        exit();
    }
}

include("./common/header.php");
?>
<div class="container">
    <h1>Deposit Calculator</h1>

    <p class = "comment">Enter principal amount,interest rate and select number of years to deposit.</p>
    <form method="post" action="DepositCalculator.php" class="postForm" id="myForm" >
        <div class="part">
            <label class="amount">Principal Amount:</label>
            <input class="principalAmount" type="text" name="principalAmount" value="<?php echo $principalAmount; ?>" />
            <div class="error">
<?php echo $errorMessageprincipalAmount; ?>
            </div>
        </div>
        <div class="part">    
            <label class="deposit" for="yearsToDeposit">Years to deposit:</label>    
            <select name="yearsToDeposit" id="yearsToDeposit">
                <option value="0">Select one...</option>
                <?php
                for ($i = 1; $i <= 25; $i++) {
                    $selected = ($yearsToDeposit == $i) ? 'selected' : '';
                    echo '<option value="' . $i . '" ' . $selected . '>' . $i . ' Year' . ($i > 1 ? 's' : '') . '</option>';
                }
                ?>
            </select>
            <div class="error">
<?php echo $errorMessageyearsToDeposit; ?>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-offset-1 col-md-2"><input class="btn btn-primary" name="previous" type="submit" value="< previous" /></div>
            <div class="col-md-offset-1 col-md-2"><input class="btn btn-primary" name="Calculate" type="submit" value="Calculate" /></div>
            <div class="col-md-offset-1 col-md-2"><input class="btn btn-primary" name="Complete" type="submit" value="Complete >" /></div>
        </div>
    </form>


    <?php
    if (isset($_POST["Calculate"])) {
        if (empty($errorMessageprincipalAmount) && empty($errorMessageyearsToDeposit)) {
            echo "<p>The following is the calculation result at the current interest rate of 3%: </p>";
            echo "<table border='1' class=tableRate>
        <tr >
            <th  class=tableHeader>Year</th>
            <th  class=tableHeader>Principal at Year Start</th>
            <th  class=tableHeader>Interest for the Year</th>
        </tr>";

            $calculationResult = []; // Create an array to store the result

            for ($year = 1; $year <= $yearsToDeposit; $year++) {
                $interest = $principalAmount * 0.03;
                $principalAmountFormatted = number_format($principalAmount, 2);
                $interestFormatted = number_format($interest, 2);

                // Add the result for this year to the array
                $calculationResult[] = [
                    'year' => $year,
                    'principal' => $principalAmountFormatted,
                    'interest' => $interestFormatted,
                ];

                echo "<tr>
            <td>$year</td>
            <td>$$principalAmountFormatted</td>
            <td>$$interestFormatted</td>
            </tr>";

                $principalAmount += $interest;
            }
            echo "</table>";

            // Save the calculation result array in a session variable
            $_SESSION['calculationResult'] = $calculationResult;
        }
    }

// Check if the calculation result exists in the session
    elseif (isset($_SESSION['calculationResult'])) {
        if (empty($errorMessageprincipalAmount) && empty($errorMessageyearsToDeposit)) {
            echo "<p>The following is the saved calculation result:</p>";
            echo "<table border='1' class=tableRate>
        <tr class=tableHeader>
         <th  class=tableHeader>Year</th>
            <th  class=tableHeader>Principal at Year Start</th>
            <th  class=tableHeader>Interest for the Year</th>
        </tr>";

            foreach ($_SESSION['calculationResult'] as $result) {
                echo "<tr>
        <td>{$result['year']}</td>
        <td>{$result['principal']}</td>
        <td>{$result['interest']}</td>
        </tr>";
            }
            echo "</table>";
        }
    }
    ?>
</div>
<?php include('./common/footer.php'); ?>
