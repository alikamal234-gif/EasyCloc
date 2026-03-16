<?php

abstract class Document {
    private $titre, $auteur;

    public function __construct($titre,$auteur){
        $this->auteur = $auteur;
        $this->titre = $titre;
    }
    abstract public function afficherInfos();
}

class Livre extends Document {
    
    public function afficherInfos(){
        return "livre";
    }
}
class Magazine extends Document{
    
    public function afficherInfos(){
        return "magazine";
    }
}

$array = [new Livre("livre 1","auteur 1"), new Livre("livre 2","auteur 2"),new Magazine("livre 3","auteur 3"), new Livre("livre 4","auteur 4"),new Magazine("livre 5","auteur 5")];
