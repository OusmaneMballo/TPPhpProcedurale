<?php
function getConnexion()
{
    $Dbname="bp_groupe2";
    $host="localhost";
    $user="root";
    $password="";
    $dsn="mysql: host=".$host.";dbname=".$Dbname;
    $db=null;
    try{
        $db=new PDO($dsn,$user,$password);
    }catch(PDOException $e){
        echo "erreur de connection";
    }
    return $db;
}

function listClientMoral()
{
    $requete1="SELECT * FROM `client_moral`";
    return getConnexion()->query($requete1);
}

function selectFrans($idfrais)
{
    $requete="SELECT fraisbanc FROM `frais_bancaire` WHERE id=$idfrais";
    return getConnexion()->query($requete);
}

function listClientPhysique()
{
    $requete2="SELECT * FROM `client_physique`";
    /*$db=$this->getConnexion();
    return $db->query($Requete);*/
    return getConnexion()->query($requete2);
}

function findClientByType($id,$type)
{
    $req1="SELECT * FROM `client_moral` WHERE id=$id";
    $req2="SELECT * FROM `client_physique` WHERE id=$id";

    if ($type=="cm")
    {
        return getConnexion()->query($req1);
    }
    else{
        return getConnexion()->query($req2);
    }
}

function addFraiBancaire($frais,$idType,$idClt)
{
    $requete="INSERT INTO `frais_bancaire`(`id`, `fraisbanc`, `datefrais`,
                `typefrais_id`, `compteclient_id`) VALUES (null ,?,?,?,?)";
    try{
        $cnx=getConnexion();
        $prepareStetement=$cnx->prepare($requete);
        $prepareStetement->execute(array($frais,date('d-m-y'), $idType,$idClt));

        return $cnx->lastInsertId();
    }
    catch(Exception $ex){
        echo $ex->getMessage();
        echo  'Erreur';
    }


}

function addCompte()
{
    $requete="INSERT INTO `compte_client`(`id`, `numeroCte`, `clerib`, 
                `agence_id`, `solde`, `etat`, `cltphy_id`, `cltmoral_id`, 
                `datecrea`, `dateferme`, `datefertempo`, `datereouv`, 
                `id_type`)
                 VALUES (null,?,?,?,?,?,?,?,?,?,?,?,?);";

    $tab=explode('-',$_POST['client']);
    //connexion a la base de donnee
    $cnx=getConnexion();

    if($tab[1]=="cm")
    {
        /**
         * Cas client moral
         */
        $cltMoral=findClientByType($tab[0],$tab[1])->fetch(PDO::FETCH_ASSOC);
        if($cltMoral!=null)
        {
            //Generation du numero de compte
            $numCmpte=$cltMoral['nom'][0].$cltMoral['nom'][1].date('d-m-y');
            $clerib=$numCmpte.'1';
            try{
                $prepareStetement=$cnx->prepare($requete);
                $prepareStetement->execute(array($numCmpte,$clerib,
                    1,$_POST['solde'],'Actif', null, $tab[0], date('d-m-y'),
                    null, null, null, $_POST['typecp']));

                $dcpmt=$cnx->lastInsertId();
                $frai=selectFrans($_POST['typecp'])->fetch(PDO::FETCH_ASSOC);
                addFraiBancaire($frai['fraisbanc'],$_POST['typecp'],$dcpmt);

                return $dcpmt;
            }
            catch (Exception $ex)
            {
                echo  $ex->getMessage();
                echo "Erreur d'ajout";
            }

        }
        else{
            echo "Ce client n'existe pas dans la base de donnee";
        }

    }
    else{
        /**
         * Cas client physique
         */
        $cltPhysique=findClientByType($tab[0],$tab[1])->fetch(PDO::FETCH_ASSOC);
        if($cltPhysique!=null)
        {
            //Generation du numero de compte et de la cle rib
            $numCmpte=$cltPhysique['prenom'][0].$cltPhysique['nom'][0].date('d-m-y');
            $clerib=$numCmpte.'1';

            $prepareStetement=$cnx->prepare($requete);
            $prepareStetement->execute(array($numCmpte,$clerib,
                1,$_POST['solde'],'Actif', $tab[0], null, date('d-m-y'),
                null, null, null, 1));
            $dcpmt=$cnx->lastInsertId();

            $frai=selectFrans($_POST['typecp'])->fetch(PDO::FETCH_ASSOC);
            addFraiBancaire($frai,$_POST['typecp'],$dcpmt);

            return $dcpmt;
        }
        else{
            echo "Ce client n'existe pas dans la base de donnee";
        }
    }

}

//================Fin de fonctions====================

//==================Traittement========================

$listClientMoral=listClientMoral();
$listClientPhysique=listClientPhysique();

if($listClientMoral!=null)
{
    while ($resultat=$listClientMoral->fetch(PDO::FETCH_ASSOC))
    {
        $val=$resultat['id']."-cm";
        echo "<option value='$val'>".$resultat['nom']."-".$resultat['raison_social']."</option>";
    }
}
echo "<option disabled>--------Client Physique------------</option>";
if($listClientPhysique!=null)
{
    while ($resultat=$listClientPhysique->fetch(PDO::FETCH_ASSOC))
    {
        $val=$resultat['id']."-cp";

        echo "<option value='$val'>".$resultat['nci']."-".$resultat['prenom']."-".$resultat['nom']."</option>";
    }
}

//----------------------------Add compte--------------------------
if(isset($_POST) && !empty($_POST))
{
    if(addCompte())
    {
        echo 'Compte ajoute!';
        header('Location: compte.php');
    }
}
