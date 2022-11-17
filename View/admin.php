<?php


require_once '../Model/User.php';
require_once '../Model/UserManager.php';
require_once 'index.php';

require_once '../Controller/autoload.php';

try{

    $pdo = new PDO('mysql:host=localhost;dbname=tp_poo', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

}catch(PDOException $e){
    echo 'Erreur : ' . $e->getMessage() . '<br />';
    echo 'N° : ' . $e->getCode() . '<br />';
    die('Connexion au serveur impossible.');
}



$userManager = new UserManager($pdo);
$users = $userManager->getAllUser();


if(isset($_GET['action']) && $_GET['action'] == 'delete'){
    $userManager->deleteUser($_GET['id']);
    header('location: admin.php');
}

if(isset($_GET['action']) && $_GET['action'] == 'edit'){
    $user = $userManager->getUserById($_GET['id']);
}




?>

<h1>Liste des membres</h1>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Téléphone</th>
            <th>Email</th>
            <th>Modifier</th>
            <th>Supprimer</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($users as $user): ?>
        <tr>
            <td><?= $user->getNom(); ?></td>
            <td><?= $user->getPrenom(); ?></td>
            <td><?= $user->getTel(); ?></td>
            <td><?= $user->getEmail(); ?></td>
            <td><a href="?action=edit&id=<?= $user->getId(); ?>" class="btn btn-primary">Modifier</a></td>
            <td><a href="?action=delete&id=<?= $user->getId(); ?>" class="btn btn-danger">Supprimer</a></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

