<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        table {
            font-size: 20px;
            width: 90%;
            border: none;
        
        }

        input, select {
            width: 100%;
            font-size: 18px;
        }

        h1 {
            text-align: center;
            color: blue;
            font-size: 40px;
        }

        .outer {
            border: 2px solid blue;
            width: 45%;
            padding: 15px;
            background-color:#fff2beff;
        }
    </style>
</head>
<body>
    <h1>Clinic Patient Registration</h1>
    <center>
    <div class="outer">
        <table>
            <tr>
                <td>Full Name:</td>
            </tr>
            <tr>
                <td><input type="text"></td>
            </tr>
            <tr>
                <td>Age:</td>
            </tr>
            <tr>
                <td><input type="text"></td>
            </tr>
            <tr>
                <td>Phone Number:</td>
            </tr>
            <tr>
                <td><input type="text"></td>
            </tr>
            <tr>
                <td>Email Address:</td>
            </tr>
            <tr>
                <td><input type="text"></td>
            </tr>
            <tr>
                <td>Insurance Provider:</td>
            </tr>
            <tr>
                <td>
                    <select>
                        <option value="Select Provider">Select Provider</option>
                        <option value="Provider 1">Provider 1</option>
                        <option value="Provider 2">Provider 2</option>
                        <option value="Provider 3">Provider 3</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Insurance Policy Number:</td>
            </tr>
            <tr>
                <td><input type="text"></td>
            </tr>
        </table>

        <h1>Additional Information</h1>
        <table>
            <tr>
                <td>Username:</td>
            </tr>
            <tr>
                <td><input type="text"></td>
            </tr>
            <tr>
                <td>Password:</td>
            </tr>
            <tr>
                <td><input type="password"></td>
            </tr>
            <tr>
                <td>Confirm Password:</td>
            </tr>
            <tr>
                <td><input type="password"></td>
            </tr>
            <tr>
                <td>
                    <p>
                        <input type="button" value="Register" style="background-color:blue;color:white;padding:10px 20px;border:none;border-radius:5px;">
                    </p>
                </td>
            </tr>
        </table>
    </div>
    </center>
</body>
</html>
