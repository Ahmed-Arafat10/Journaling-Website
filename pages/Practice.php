<?php

// ----------------------------------------
# Section 4 Start
// ----------------------------------------

$arr = [1,2,"ahmed",4,true]; // numeric (index-based)


//echo $arr[0] . '<br>'; // concatenation (+)
//echo $arr[2];
//echo $arr[22222222]; // Warning: Undefined array key 22222222

// associative
$arr2 = [
    // Key => Value
    "ahmed" => "arafat",
    "BIS"  => "Helwan University"
];

//echo $arr2["BIS"];
//echo $arr2["Ahmed Arafat"]; // Warning: Undefined array key "Ahmed Arafat"



// Super Global Arrays

// $_SERVER
// $_SESSION
// $_POST
// $_GET


// Debugging
//var_dump($arr);
echo "<pre>";
var_dump($_SERVER);
var_dump($_SERVER['DOCUMENT_ROOT']);


// ----------------------------------------
# Section 4 End
// ----------------------------------------