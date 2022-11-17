<?php
/*
Créer un fichier inscription.php qui va permettre d'ajouter un user
1- Faire un formulaire d'inscription

2- Créer un fichier autoload.php qui se charge de faire vos require automatiquement

2- Faire dans le même fichier tout le traitement qui fera l'ajout d'un user
*/

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


if ($_POST) {
    $user = new User([
        'nom' => $_POST['nom'],
        'prenom' => $_POST['prenom'],
        'tel' => $_POST['tel'],
        'email' => $_POST['email']
    ]);
    
    if($user->isUserValid()){
        $userManager = new UserManager($pdo);
        $userManager->insertUser($user);
        $message = 'L\'utilisateur a bien été ajouté';
    }else{
        $erreurs = $user->getErreurs();
    }
}

?>

<h1>Inscription</h1>

<div class="row">
    <?php if(isset($message)) echo $message; ?>
<form action="inscription.php" method="POST">

    <div class="form-group">
        <label for="nom">Nom</label>
        <input type="text" class="form-control" id="nom" name="nom" placeholder="Nom">
        <?php if(isset($erreurs) && in_array(User::NOM_INVALIDE, $erreurs)) echo '<div class="alert alert-danger">Le nom est invalide</div>'; ?>
    </div>

    <div class="form-group">
        <label for="prenom">Prénom</label>
        <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Prénom">
        <?php if(isset($erreurs) && in_array(User::PRENOM_INVALIDE, $erreurs)) echo '<div class="alert alert-danger">Le prénom est invalide</div>'; ?>
    </div>

    <div class="form-group">
        <label for="tel">Téléphone</label>
        <input type="text" class="form-control" id="tel" name="tel" placeholder="Téléphone">
        <?php if(isset($erreurs) && in_array(User::TEL_INVALIDE, $erreurs)) echo '<div class="alert alert-danger">Le téléphone est invalide</div>'; ?>
    </div>

    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="Email">
        <?php if(isset($erreurs) && in_array(User::EMAIL_INVALIDE, $erreurs)) echo '<div class="alert alert-danger">L\'email est invalide</div>'; ?>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>

</form>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


</body>
</html>

