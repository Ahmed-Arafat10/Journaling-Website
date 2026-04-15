<?php

/*
 Arrays
 - numeric array (index-based)
 - associative array
 */

//$ages = [1,true,"Ahmed Arafat",4.5,5];
//       0      sz-1

//echo $ages[5]; // Warning: Undefined array key 5


// key => value
//$arr = [
//    'taName' => 'Ahmed Arafat',
//    'age' => 26,
//    'isMale' => true,
//    'address' => [
//        'city' => 'Giza',
//        'street' => '123 St.'
//    ]
//];

//echo $arr['TaName']; // Warning: Undefined array key "TaName"

//echo $arr['address']['street']; // Warning: Array to string conversion

//$username = 'Ahmed Arafat';

//echo "Welcome Back, " . $username;

//echo '<pre>';
//var_dump($username);

/*
 *
 Super Global Arrays
    $_SERVER
    $_POST
    $_GET
    $_SESSION
 */

//echo '<pre>';
//var_dump($_SERVER);
// ternary operator
// condition ? true : false;
// post get
//echo session_start();// 123xyz
//echo "<br>";
//echo (session_id() == "" ? "No Session" : session_id());
//$_SESSION['userID'] = 2;
//echo "<br>";
//var_dump($_SESSION);
session_start();
echo session_id();

$headers = getallheaders();
echo '<pre>';
print_r($headers);
echo '</pre>';
