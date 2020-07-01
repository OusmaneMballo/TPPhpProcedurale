<?php

function listTypeCmpt()
{
    $requete="SELECT * FROM `type_compte`";
    $Dbname="bp_groupe2";
    $host="localhost";
    $user="root";
    $password="";
    $dsn="mysql: host=".$host.";dbname=".$Dbname;
    $db=null;
    try{
        $db=new PDO($dsn,$user,$password);
        return $db->query($requete);
    }catch(PDOException $e){
        echo "erreur de connection";
    }
}

$listTypeCompte=listTypeCmpt();
if($listTypeCompte!=null)
{
    echo "<select name='typecp' id='typecp' class='selectcmpt' onchange='frais()'>";
    echo "<option value='0'>--Type Compte--</option>";
    while ($resultat=$listTypeCompte->fetch(PDO::FETCH_ASSOC))
    {
        $val=$resultat['id'];

        echo "<option value='$val'>".$val."-".$resultat['libelle']."</option>";
    }
    echo "</select>";
}
