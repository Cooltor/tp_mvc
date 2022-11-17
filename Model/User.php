<?php

/*
1- Créer une classe User avec les attributs private (id, nom, prenom, tel, email, erreurs = []) erreurs va se charger de gérer les erreurs

2- Créer 4 constantes NOM_INVALIDE = 1, PRENOM_INVALIDE = 2, EMAIL_INVALIDE = 3, TEL_INVALIDE = 4;

3- Créer un constructructeur qui prend en param un tableau qui va contenir les data que l'user a envoyé depuis le formulaire

4- Créer une méthode assignement() qui va prend un attribut(un array) en argument . Cette méthode gère l'assignement des valeurs à chaque user.utiliser la notion d'hydrataion(hydrater un objet c'est lui apporter ceux dont il a besoin pour fonctionner c-a-d lui donner les valeur qu'on souhaite pour qu'il l'assigne à l'objet).Pour faire simple vous devez faire une boucle qui va gérer vos setter qui devront être appelés dans le constructeur

5- Créer tous les setter et tous les getters.Pour les setters, vérifier si la valeur est vide et correspond au type attendu.Exemple : le nom ne peut pas être vide et doit être une chaîne de caractère. En cas d'erreur affecter la constante correspondante à la propriété dans l'attribut erreur. Pour le mail utiliser la fonction FILTER_VALIDATE_EMAIL

6- Créer une méthode isUserValid() qui retourne un boolean.Cette méthode va permettre de de vérifier la validité d'un user. Un user est valide s'il a un nom,prenom,email
*/


class User {
    private $id;
    private $nom;
    private $prenom;
    private $tel;
    private $email;
    private $erreurs = [];

    const NOM_INVALIDE = 1;
    const PRENOM_INVALIDE = 2;
    const EMAIL_INVALIDE = 3;
    const TEL_INVALIDE = 4;

    public function __construct($data) {
        $this->assignement($data);
    }

    public function assignement($data) { 
        foreach ($data as $key => $value) { 
            $method = 'set'.ucfirst($key); 
            if (method_exists($this, $method)) { 
                $this->$method($value); 
            }
        }
    }

    public function setId($id) {
        $this->id = (int) $id;
    }

    public function setNom($nom) {
        if (!is_string($nom) || empty($nom)) {
            $this->erreurs[] = self::NOM_INVALIDE;
        } else {
            $this->nom = $nom;
        }
    }

    public function setPrenom($prenom) {
        if (!is_string($prenom) || empty($prenom)) {
            $this->erreurs[] = self::PRENOM_INVALIDE;
        } else {
            $this->prenom = $prenom;
        }
    }

    public function setTel($tel) {
        if (!is_string($tel) || empty($tel)) {
            $this->erreurs[] = self::TEL_INVALIDE;
        } else {
            $this->tel = $tel;
        }
    }

    public function setEmail($email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->erreurs[] = self::EMAIL_INVALIDE;
        } else {
            $this->email = $email;
        }
    }

    public function getId() {
        return $this->id;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getPrenom() {
        return $this->prenom;
    }

    public function getTel() {
        return $this->tel;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getErreurs() {
        return $this->erreurs;
    }

    public function isUserValid() {
        return !(empty($this->nom) || empty($this->prenom) || empty($this->email));
    }
}


