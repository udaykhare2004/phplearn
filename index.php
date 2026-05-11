<?php
 echo "Hello";
 echo "<br>";
 echo "MKC";
 echo "<br>";

 $name = "ABCD";
 $age = 20;
 $isAdmin = true;
 $nothing = null;
 $fn = "John";
 $ln = "Doe";

 echo "Name: ".$name;
 echo "<br>";
 echo "Age: ".$age;
 echo "<br>";
 echo "Is Admin:".$isAdmin;
 echo "<br>";

 var_dump($name);
 echo "<br>";
 echo "first name: $fn, " . " last name: $ln";
 echo "<br>";
 echo 'first name: $fn '.' last name: $ln';
 echo "<br>";

 $str = "kal el";
 $newStr = str_replace("kal", "sup", $str);
 echo $str;
 echo "<br>";
 echo $newStr;
 echo "<br>";

 $fruits = ["apple", "banane"];
 array_push($fruits, "orange");

 $person = [
    "name" => "John",
    "age" => 30,
    "email" => "alice@example.com"
 ];

 foreach($person as $key => $value) {
    echo "$key: $value";
    echo "<br>";
 }

 echo "<br>";

 function greet($name = "Guest"):string {
    return "Hello, $name!";
 }

 function even($num): bool {
    return $num % 2 == 0;
 }

 $nums = [1,2,3,4,5,6,7,8];
 foreach($nums as $num) {
    if(even($num)) {
        echo "$num is even";
        echo "<br>";
    } else {
        echo "$num is odd";
        echo "<br>";
    }
 }

 echo "<br>";
 echo greet();
 echo "<br>";
 echo greet("Alice");
 echo "<br>";

 $person["city"] = "lucknow";
 print_r($person);
 
 
?>