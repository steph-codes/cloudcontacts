<?php
    function displayCar($cars){
        if(is_array($cars)){
            foreach ($cars as $c) {
                echo $c."<br>";
            }
        }else{
            echo"array required as argument";
        }
        
    }
    //type-hinting helps to know the exact datatype
    //return type :str mean you have to return a string value
    function displayCar2(array $cars):string{
        foreach($cars as $c){
            echo $c. "<br>";
        }
        return $c;
    }

    //call function
    $car = "BMW";
    displayCar($car);

?>