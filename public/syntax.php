<?php
// Function to generate a random color
function randomColor() {
    $colors = ['red', 'blue', 'green', 'purple', 'orange'];
    return $colors[array_rand($colors)];
}

// Associative array of programming languages and their creation years
$languages = [
    'PHP' => 1995,
    'Python' => 1991,
    'JavaScript' => 1995,
    'Ruby' => 1995
];

// String manipulation example
$name = isset($_POST['name']) ? $_POST['name'] : 'Guest';
$greeting = "Hello, " . $name . "!"; // Concatenation
$greeting2 = "Hello, $name!";        // Variable interpolation

// Simple calculation
$num1 = 10;
$num2 = 5;
$operations = [
    'add' => $num1 + $num2,
    'subtract' => $num1 - $num2,
    'multiply' => $num1 * $num2,
    'divide' => $num1 / $num2
];

// Example of using conditions
$time = date('H');
$timeOfDay = ($time < 12) ? 'morning' : (($time < 18) ? 'afternoon' : 'evening');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Syntax Explorer</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 20px auto; padding: 0 20px; }
        .box { padding: 15px; margin: 10px 0; border-radius: 5px; }
        .code { background: #f4f4f4; padding: 10px; border-radius: 5px; }
    </style>
</head>
<body>
    <h1>PHP Syntax Explorer</h1>

    <!-- Form handling example -->
    <form method="POST">
        <label for="name">Enter your name:</label>
        <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($name); ?>">
        <button type="submit">Submit</button>
    </form>

    <!-- String manipulation -->
    <div class="box" style="background-color: lightblue;">
        <h3>String Manipulation</h3>
        <p>Concatenation: <?php echo $greeting; ?></p>
        <p>Interpolation: <?php echo $greeting2; ?></p>
        <p>Time of day: Good <?php echo $timeOfDay; ?>!</p>
    </div>

    <!-- Loop example -->
    <div class="box" style="background-color: lightgreen;">
        <h3>Programming Languages (foreach loop)</h3>
        <ul>
        <?php foreach($languages as $lang => $year): ?>
            <li><?php echo "$lang was created in $year"; ?></li>
        <?php endforeach; ?>
        </ul>
    </div>

    <!-- Array operations -->
    <div class="box" style="background-color: lightyellow;">
        <h3>Math Operations (using arrays)</h3>
        <?php foreach($operations as $operation => $result): ?>
            <p><?php echo ucfirst($operation) . ': ' . $result; ?></p>
        <?php endforeach; ?>
    </div>

    <!-- Random color boxes using function -->
    <div class="box" style="background-color: lightpink;">
        <h3>Random Colors (function call in loop)</h3>
        <?php for($i = 0; $i < 5; $i++): ?>
            <div style="background-color: <?php echo randomColor(); ?>; 
                        padding: 10px; margin: 5px; display: inline-block;">
                Color Box <?php echo $i + 1; ?>
            </div>
        <?php endfor; ?>
    </div>

    <!-- PHP Info section -->
    <div class="code">
        <h3>Syntax Examples:</h3>
        <pre>
// Variables
$name = "value";

// Arrays
$array = ['item1', 'item2'];
$assoc_array = ['key' => 'value'];

// Loops
foreach($array as $item) {
    echo $item;
}

for($i = 0; $i < 5; $i++) {
    echo $i;
}

// Functions
function myFunction($param) {
    return $param * 2;
}

// Conditions
if($condition) {
    // do something
} elseif($other_condition) {
    // do something else
} else {
    // default action
}

// Ternary operator
$result = $condition ? 'yes' : 'no';
        </pre>
    </div>
</body>
</html>