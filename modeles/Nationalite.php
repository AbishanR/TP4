<?php
class Nationalite{
/**
 * numero du nationalité
 *
 * @var int
 */
private $num;
/**
 * Libelle du nationalité
 *
 * @var string
 */
private $libelle;
/**
 * num continent (clé étrangère) relié à num Continent
 *
 * @var int
 */
private $numContinent;
/**
 * renvoie l'objet continent associé
 *
 * @return Continent
 */
public function getNumContinent() : Continent
{
return Continent::findById($this->numContinent);
}

/**
 * écrit le num continent
 *
 * @param Continent $continent
 * @return self
 */
public function setNumContinent(Continent $continent): self
{
$this->numContinent = $continent->getNum();

return $this;
}


/**
 * Get the value of num
 */ 
public function getNum()
{
return $this->num;
}

/**
 * Lit le libelle
 *
 * @return string
 */
public function getLibelle() : string
{
return $this->libelle;
}

/**
 * écrit dans le libelle
 *
 * @param string $libelle
 * @return self
 */
public function setLibelle(string $libelle) : self
    {
    $this->libelle = $libelle;

    return $this;
    }

    /**
     * Retourne l'ensemble des nationalités
     *
     * @return Nationalite[] tableau d'objet nationalité
     */
    public static function findAll() :array
    {
        $req=MonPdo::getInstance()->prepare("select n.num, n.libelle as 'libNation', c.libelle as 'libContinent' from nationalite n, continent c where n.numContinent = c.num");
        $req->setFetchMode(PDO::FETCH_OBJ);
        $req->execute();
        $lesResultats=$req->fetchAll();
        return $lesResultats;
    }

    /**
     * Trouve une nationalite par son num
     *
     * @param integer $id numéro de la nationalité
     * @return Nationalite objet nationalité trouvé
     */
    public static function findById(int $id) : Nationalite
    {
        $req=MonPdo::getInstance()->prepare("Select * from nationalite where num= :id");
        $req->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'Nationalite');
        $req->bindParam(':id',$id);
        $req->execute();
        $lesResultats=$req->fetch();
        return $lesResultats;
    }

    /**
     * Permet d'ajouter une nationalité
     *
     * @param Nationalite $nationalite nationalité à ajouter
     * @return integer resultat (1 si l'op a réussi, 0 sinon)
     */
    public static function add(Nationalite $nationalite) :int
    {
        $req=MonPdo::getInstance()->prepare("insert into nationalite(libelle, numContinent) value(:libelle, :numContinent)");
        $req->bindParam(':libelle',$nationalite->getLibelle());
        $req->bindParam(':numContinent',$nationalite->numContinent());
        $nb=$req->execute();
        return $nb;
    }


    /**
     * Permet de modifier une nationalité
     *
     * @param Nationalite $nationalite nationalité à modifier
     * @return integer resultat (1 si l'op a réussi, 0 sinon)
     */
    public static function update(Nationalite $nationalite):int
    {
        $req=MonPdo::getInstance()->prepare("update nationalite set libelle= :libelle, numContinent= :numContinent where num= :id");
        $req->bindParam(':id',$nationalite->getNum());
        $req->bindParam(':libelle',$nationalite->getLibelle());
        $req->bindParam(':numContinent',$nationalite->numContinent());
        $nb=$req->execute();
        return $nb;
    }

    /**
     * Permet de suppr un une nationalité
     *
     * @param Nationalite $nationalite
     * @return integer
     */
    public static function delete(Nationalite $nationalite) :int
    {
        $req=MonPdo::getInstance()->prepare("delete from nationalite where num= :id");
        $req->bindParam(':id',$nationalite->getNum());
        $nb=$req->execute();
        return $nb;
    }


}

?>