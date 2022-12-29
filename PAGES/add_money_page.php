<?php
$data_from_file = file_get_contents(__DIR__.'/data.json');
$data = json_decode($data_from_file);


$id = (int) $_GET['id'];




foreach($data as $user ){
    if ($user -> id == $id) {
        break;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BANK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>

<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Bankas</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="../PAGES/saskaitu_sarasas.php">Sąskaitų sąrašas</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../PAGES/sukurti_saskaita.php">Sūkurti sąskaitą</a>
        </li>
      </ul>
    </div>
  </div>
</nav>


    <table class="table" style="margin:5%;">
  <thead>
  <th scope="col">ID</th>
      <th scope="col">Vardas</th>
      <th scope="col">Pavardė</th>
      <th scope="col">Lėšos</th>
      <th scope="col">Prideti lėšas</th>
      <th scope="col">Atimti lėšas</th>
    </tr>
  </thead>
  <tbody>
<?php 

foreach($data as $user){
    if($user -> id == $id){
        echo '<tr><th scope="row">'.$user -> id.'</th><td>'.$user -> name.'</td><td>'.$user -> surname.'</td><td>'.$user -> money.' &euro;</td><td><form action="./add_money.php?id='.$id.'" method="post" style="margin-right: -9000px; display: flex;">
        <input type="text" name="money">
        <button type="submit" class="btn btn-success" style="margin-left:10px;">Prideti</button>
    </form></td><td><form action="./minus_money.php?id='.$id.'" method="post"  style="display: flex;">
    <input type="text" name="money">
    <button type="submit" class="btn btn-danger" style="margin-left:10px;">Atimti</button>
</form></td></tr>';
 
   

        break;
    }

}

?>
<?php 
    if(isset($_GET['minusine'])){
        echo "<div class='p-3 text-warning-emphasis bg-warning-subtle border border-warning-subtle rounded-3'>Sąskaitoje likusi suma negali būti minusinė.</div>";
    }

?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>