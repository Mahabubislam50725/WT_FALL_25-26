<html>
<head>
    <title>PHP Code</title>

    <style>

     h1{
            text-align:center;
    }

    .box {
        width: 420px;
        margin: auto;
        padding: 20px;
        background-color: #f9f9f9;
    }

    fieldset {
        border: 2px solid #555;
        padding: 15px;
    }

    legend {
        font-weight: bold;
        padding: 0 10px;
    }

    .center-output {
        width: 420px;
        margin: 20px auto;
        padding: 15px;
        border: 2px solid;
        text-align: center;
        background-color: #eef3eeff;
        border-radius: 8px;
    }

</style>

</head>
 
<body>
<h1>Lab Task 1</h1>
 
<?php
$name = "";
$email = "";
$dd = $mm = $yy = "";
$gender = "";
$degree = [];
$blood = "";

$nameErr = "";
$emailErr = "";
$dateErr = "";
$genderErr = "";
$degreeErr = "";
$bloodErr = "";
 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
    if (empty($_POST["name"])) {
        $nameErr = "Name cannot be empty";
    } else {
        $name = trim($_POST["name"]);
        if (str_word_count($name) < 2) {
            $nameErr = "Name must contain at least two words";
        } elseif (!preg_match("/^[a-zA-Z][a-zA-Z .-]*$/", $name)) {
            $nameErr = "Invalid name format";
        }
    }
 
 
    if (empty($_POST["email"])) {
    $emailErr = "Email cannot be empty";
} else {
    $email = trim($_POST["email"]);
    if (strpos($email, '@') === false || strpos($email, '.com') === false) {
        $emailErr = "Email must contain @ and .com";
    }
}

    if (empty($_POST["dd"]) || empty($_POST["mm"]) || empty($_POST["yy"])) {
        $dateErr = "Date of birth required";
    } else {
        $dd = $_POST["dd"];
        $mm = $_POST["mm"];
        $yy = $_POST["yy"];

        if ($dd < 1 || $dd > 31 || $mm < 1 || $mm > 12 || $yy < 1953 || $yy > 1998) {
            $dateErr = "Invalid date range";
        }
    }

    if (empty($_POST["gender"])) {
        $genderErr = "Select gender";
    } else {
        $gender = $_POST["gender"];
    }


    if (empty($_POST["degree"]) || count($_POST["degree"]) < 2) {
        $degreeErr = "Select at least two degrees";
    } else {
        $degree = $_POST["degree"];
    }

     if (empty($_POST["blood"])) {
        $bloodErr = "Select blood group";
    } else {
        $blood = $_POST["blood"];
    }

}
 
function text_input($data)
{
    return trim($data);
}
?>
 
<form method="post" action="">
    <div class="box">
        <fieldset>
            <legend>Registration Form</legend>
     Name:
    <input type="text" name="name" value="<?php echo $name; ?>">
    <?php echo $nameErr; ?>
    <br><br>

 
     Email:
    <input type="text" name="email" value="<?php echo $email; ?>">
    <?php echo $emailErr; ?>
    <br><br>

    Date of Birth:
    <input type="text" name="dd" size="2" placeholder="DD"> /
    <input type="text" name="mm" size="2" placeholder="MM"> /
    <input type="text" name="yy" size="4" placeholder="YYYY">
    <?php echo $dateErr; ?>
    <br><br>

    Gender:
    <input type="radio" name="gender" value="Male">Male
    <input type="radio" name="gender" value="Female">Female
    <input type="radio" name="gender" value="Other">Other
    <?php echo $genderErr; ?>
    <br><br>

    Degree:
    <input type="checkbox" name="degree[]" value="SSC">SSC
    <input type="checkbox" name="degree[]" value="HSC">HSC
    <input type="checkbox" name="degree[]" value="BSc">BSc
    <input type="checkbox" name="degree[]" value="MSc">MSc
    <?php echo $degreeErr; ?>
    <br><br>

    Blood Group:
    <select name="blood">
        <option value="">Select</option>
        <option value="A+">A+</option>
        <option value="A-">A-</option>
        <option value="B+">B+</option>
        <option value="B-">B-</option>
        <option value="O+">O+</option>
        <option value="O-">O-</option>
    </select>
    <?php echo $bloodErr; ?>
    <br><br>

 
    <input type="submit" value="Submit">
       </fieldset>
    </div>
</form>
 
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" &&
    empty($nameErr) && empty($emailErr) && empty($dateErr) &&
    empty($genderErr) && empty($degreeErr) && empty($bloodErr)) {
    
    echo "<div class='center-output'>";
    echo "<h3>Submitted Data</h3>";
    echo "Name: $name <br>";
    echo "Email: $email <br>";
    echo "DOB: $dd/$mm/$yy <br>";
    echo "Gender: $gender <br>";
    echo "Degree: " . implode(", ", $degree) . "<br>";
    echo "Blood Group: $blood <br>";
    echo "</div>";
}
?>
 
</body>
</html>