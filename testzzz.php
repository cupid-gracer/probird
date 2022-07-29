<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Pro-Bird | </title>
</head>

<body>

aaaaaaaaa
<?php
echo 1;
// on se connecte à MySQL
$db = mysql_connect('localhost', 'sol', '6eu21pt7');
echo  $db;
echo 2;
// on sélectionne la base
mysql_select_db('capespigne_probird',$db);
echo 3;
// on crée la requête SQL
$sql = 'SELECT @myID := ID from mediasz;';
echo 4;
// on envoie la requête
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
echo 5;
// on fait une boucle qui va faire un tour pour chaque enregistrement
while($data = mysql_fetch_assoc($req))
    {
    // on affiche les informations de l'enregistrement en cours
    echo '<b>data'.$data.'</b>';
    }
echo 6;
// on ferme la connexion à mysql
mysql_close();
?>
echo 7;
bbbbbbbbb
</body>
</html>
