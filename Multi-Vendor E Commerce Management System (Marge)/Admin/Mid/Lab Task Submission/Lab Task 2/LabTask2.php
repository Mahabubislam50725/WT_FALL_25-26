<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        body{
            background-color:#e8efff;
        }
        table {
            font-size: 20px;
            width: 90%;
            border: none;
        }
        input {
            width: 100%;
            font-size: 16px;
            padding: 8px;
            border: 1px solid #ccc;
        }
        .outer{
            border: 1px solid #ddd;
            width: 45%;
            padding: 20px;
            background-color:white;
            margin: auto;
            
        }
        h1,h2{
            text-align: center;
            font-size: 30px;
        }
        .btn{
            background-color:#1e66dd;
            color:white;
            padding:10px;
            margin-top:10px;
        }
    </style>
</head>

<body>
    <form>
        <div class="outer">
            <h1>Participant Registration</h1>

            <table>
                <tr>
                    <td>Full Name:</td>
                </tr>
                <tr>
                    <td><input type="text" id="name"></td>
                </tr>

                <tr>
                    <td>Email:</td>
                </tr>
                <tr>
                    <td><input type="text" id="email"></td>
                </tr>

                <tr>
                    <td>Phone Number:</td>
                </tr>
                <tr>
                    <td><input type="text" id="phnNum"></td>
                </tr>

                <tr>
                    <td>Password:</td>
                </tr>
                <tr>
                    <td><input type="password" id="password"></td>
                </tr>

                <tr>
                    <td>Confirm Password:</td>
                </tr>
                <tr>
                    <td><input type="password" id="cpassword"></td>
                </tr>

                <tr>
                    <td><button type="button" class="btn" onclick="User()">Register</button></td>
                </tr>
            </table>

           
            <div id="result" style="margin-top:15px; color:red;"></div>
            <div id="output"></div>

        </div>
    </form>

    <div class="outer">
        <h2>Activity Selection</h2>
        <table>
            <tr>
                <td>Activity Name:</td>
            </tr>
            <tr>
                <td><input type="text" id="activityInput"></td>
            </tr>

            <tr>
                <td><button class="btn" type="button">Add Activity</button></td>
            </tr>
        </table>
    </div>

<script>
    function User() {

        var name = document.getElementById("name").value.trim();
        var email = document.getElementById("email").value.trim();
        var phnNum = document.getElementById("phnNum").value.trim();
        var password = document.getElementById("password").value.trim();
        var cpassword = document.getElementById("cpassword").value.trim();

        var errorDiv = document.getElementById("result");
        errorDiv.innerHTML = "";
        var outputDiv = document.getElementById("output");
        outputDiv.innerHTML = "";

        
        if (name === "" || email === "" || phnNum === "" || password === "" || cpassword === "") {
            errorDiv.innerHTML = "Please fill all fields";
            return false;
        }

        if (!email.includes("@")) {
            errorDiv.innerHTML = "Email must contain '@'";
            return false;
        }

        if (isNaN(phnNum)) {
            errorDiv.innerHTML = "Phone must be number.";
            return false;
        }

        if (password !== cpassword) {
            errorDiv.innerHTML = "Passwords do not match.";
            return false;
        }

        
        outputDiv.innerHTML = `
            <strong>Registration Successful!</strong><br><br>
            Name: ${name}<br>
            Email: ${email}<br>
            Phone: ${phnNum}
        `;

        return false;
    }
</script>

</body>
</html>
