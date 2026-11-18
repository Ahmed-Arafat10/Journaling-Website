<?php

// numeric array (index-based)
// associative array (key-value pair)
//$arr = [1, 2, 3, 4, 5];
//      0  1 2 3 4

//echo $arr[5];

//$arr1 = [
//    "sectionName" => "Internet Applications HU",
//    "TaName" => "Dr Ahmed",
//    "hasGraduated" => true,
//    "courses" => [
//        "courseName" => "Software Engineering",
//    ],
//    "age" => 27,
//];
//echo $arr1["age"];

//echo $arr1['courses'];

//echo "<pre>";
//var_dump($arr1);// debugging



// Super Global Arrays
// $_
/*

 */
//echo "<pre>";

//$age = 26;
//
//echo "My Age is $age";
//echo "<br>";
//echo 'My Age is $age';

session_start(); // 1 -> establish new session
// 2-> send SESSION_ID in HTTP header PHPSESSID

//$_SESSION['User_ID'] = 1;

// Ternary operator [ Condition ? True : False ]
//echo session_id() == false ? "No Session" : session_id();


//echo $_SESSION['User_ID'];

var_dump($_SESSION);