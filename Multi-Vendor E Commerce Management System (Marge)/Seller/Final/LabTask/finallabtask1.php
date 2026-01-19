<head>
    <title>PHP Code</title>
 
   
 
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
 
 
   
}
 
function text_input($data)
{
    return trim($data);
}
?>
 
<form method="post" action="">
   
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
 
 
    <input type="submit" value="Submit">
     
</form>
 
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" &&
    empty($nameErr) && empty($emailErr) && empty($dateErr) &&
    empty($genderErr)) {
   
    echo "<div class='center-output'>";
    echo "<h3>Submitted Data</h3>";
    echo "Name: $name <br>";
    echo "Email: $email <br>";
    echo "DOB: $dd/$mm/$yy <br>";
    echo "Gender: $gender <br>";
   
   
}
?>
 
</body>
</html>