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

function listClientPhysique()
{
    $requete2="SELECT * FROM `client_physique`";
    /*$db=$this->getConnexion();
    return $db->query($Requete);*/
    return getConnexion()->query($requete2);
}

$listClientMoral=listClientMoral();
$listClientPhysique=listClientPhysique();

if($listClientMoral!=null)
{
    while ($resultat=$listClientMoral->fetch(PDO::FETCH_ASSOC))
    {
        $id=$resultat['id'];
        echo "<option value='$id'>".$resultat['nom']."-".$resultat['raison_social']."</option>";
    }
}
echo "<option disabled>---------------------Client Physique---------------------</option>";
if($listClientPhysique!=null)
{
    while ($resultat=$listClientPhysique->fetch(PDO::FETCH_ASSOC))
    {
        $id=$resultat['id'];
        echo "<option value='$id'>".$resultat['nci']."-".$resultat['prenom']."-".$resultat['nom']."</option>";
    }
}
