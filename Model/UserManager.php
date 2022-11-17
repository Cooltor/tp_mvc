<?php

/*Créer un fichier UserManager.php qui va gérer la classe User
1- Creér une classe UserManager avec un attribut private dataBase;puis un constructeur qui fera la connexion à la bdd

2- une méthode insertUser() qui va se charger j'ajouter un user dans la bdd

2- getAllUser() qui récupère tous les users de la bdd

3- getUserById(un id en param) qui récupère un user grace à son id

4- updateUser() qui va mettre à jour un user

5- deleteUser() Qui supprime un user
*/

class UserManager {
    private $dataBase;

    public function __construct($dataBase) {
        $this->dataBase = $dataBase;
    }

    public function insertUser(User $user) {
        $query = $this->dataBase->prepare('INSERT INTO membre(nom, prenom, tel, email) VALUES(:nom, :prenom, :tel, :email)');
        $query->bindValue(':nom', $user->getNom(), PDO::PARAM_STR); 
        $query->bindValue(':prenom', $user->getPrenom(), PDO::PARAM_STR);
        $query->bindValue(':tel', $user->getTel(), PDO::PARAM_STR);
        $query->bindValue(':email', $user->getEmail(), PDO::PARAM_STR);
        $query->execute();
    }

    public function getAllUser() {
        $users = [];
        $query = $this->dataBase->query('SELECT * FROM membre');
        while ($data = $query->fetch(PDO::FETCH_ASSOC)) {
            $users[] = new User($data);
        }
        return $users;
        $query->closeCursor();
    }

    public function getUserById($id) {
        $query = $this->dataBase->prepare('SELECT * FROM membre WHERE id = :id');
        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $user = new User($data);
        return $user;
        $query->closeCursor();
    }

    public function updateUser(User $user) {
        $query = $this->dataBase->prepare('UPDATE membre SET nom = :nom, prenom = :prenom, tel = :tel, email = :email WHERE id = :id');
        $query->bindValue(':nom', $user->getNom(), PDO::PARAM_STR);
        $query->bindValue(':prenom', $user->getPrenom(), PDO::PARAM_STR);
        $query->bindValue(':tel', $user->getTel(), PDO::PARAM_STR);
        $query->bindValue(':email', $user->getEmail(), PDO::PARAM_STR);
        $query->bindValue(':id', $user->getId(), PDO::PARAM_INT);
        $query->execute();
    }

    public function deleteUser($id) {
        $query = $this->dataBase->prepare('DELETE FROM membre WHERE id = : id');
        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->execute();
    }
}

