<?php

namespace App;

class Date
{
    public static function storeTodaysDateIfNeeded()
    {
        DB::connect();
        //Initialize with NULL value
        $Day_ID = null;
        // Store Value Of Today's Date With This Format (2022-1-9) In This Variable
        $curDate = date("Y-m-d");
        //Check if today's date already exist in `Date` Table
        $selectQuery= "SELECT * FROM `date` WHERE `Date` = ? ";
        $stmt = DB::$Con->prepare($selectQuery);
        $stmt->bind_param('s',$curDate);
        $check = $stmt->execute();
        //If today's date does not exist in `Date` Table, THEN insert it in Table
        if (!$stmt->get_result()->num_rows) {
            $insertQuery = "INSERT INTO `Date` VALUES(NULL,?)";
            $insertStmt = DB::$Con->prepare($insertQuery);
            $insertStmt->bind_param('s',$curDate);
            $check = $insertStmt->execute();
        }
        // SELECT Today's Date row to be able to store it's ID in $Day_ID variable after fetching row
        $selectQuery = "SELECT * FROM `date` WHERE Date = ? ";
        $stmt = DB::$Con->prepare($selectQuery);
        $stmt->bind_param('s',$curDate);

        $stmt->execute();
        $Day_ID = $stmt->get_result()->fetch_assoc()['ID'];

        $_SESSION['Day_ID'] = $Day_ID; # VIP: To Make Today's Date ID Global among ALL Pages

        //echo "Today's ID is : " . $Day_ID;# Debug
    }
}