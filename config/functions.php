<?php

function es($target){
    return htmlspecialchars($target, ENT_QUOTES, 'UTF-8');
}

function es_for_post($target){
    foreach($target as $key => $value){
        $es_post[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
    return $es_post;
}

function getIncluded($price, $num){
    echo $price * $num;  
}
function getPrice($price, $num){
    return ($price * $num);  
}

function month_pull_down(){
    for($i=1; $i<=12; $i++){
        echo '<option value="'.$i.'">'.$i.'</option>';
    }
}

function days_pull_down(){
    for($i=1; $i<=31; $i++){
        echo  '<option value="'.$i.'">'.$i.'</option>';
    }
}

function num_change($selected){
    for($n=1; $n<=10; $n++){
        if($n === $selected){
            echo '<option class="form-control" selected value="'.$n.'">'.$n.'</option>';
        }else{
            echo '<option class="form-control" value="'.$n.'">'.$n.'</option>';
        }
    }
}

function generation(){
    for($i=1920; $i<=2020; $i+=10){
        echo '<option class="form-control" value="'.$i.'">'.$i.'年代</option>';
    }
}