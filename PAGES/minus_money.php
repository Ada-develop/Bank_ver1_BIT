<?php 

$data_from_file = file_get_contents(__DIR__.'/data.json');
$data = json_decode($data_from_file);
    
$id = (int) $_GET['id'];

foreach($data as $user){
    if($user -> id == $id){

        if(($user -> money - (int)$_POST['money']) < 0 ){
            header("Location: http://localhost/Bank/PAGES/add_money_page.php?id=".$id."&minusine=1");    
            break;
        }else{
            echo "<h1>Atimam saskaita</h1>";
            (int)$user -> money -= (int)$_POST['money'];
            file_put_contents(__DIR__.'/data.json', json_encode($data));
            header("Location: http://localhost/Bank/PAGES/add_money_page.php?id=".$id);
            break;
    }
    }

}
