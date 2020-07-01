<?php

/**
 * function de connexion a la BD.
 */
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

function addCM($cnx)
{
    //requete d'insertion a la base de donnee
    $requete="INSERT INTO `client_moral`(`id`, `raison_social`,
                                `nom`, `adresse`, `numidentf`, `telephone`, 
                                `email`, `login`, `password`)
                    VALUES (null ,? ,? ,? ,? ,? ,? ,? ,?)";

    /**
     * execution de la requete
     */
    $prepareStetement=$cnx->prepare($requete);
    $prepareStetement->execute(array($_POST['raisonSocialCM'],$_POST['nomCM'],
                                        $_POST['adresseCM'],$_POST['identifiantCM'],$_POST['telephoneCM'],
                                        $_POST['emailCM'], $_POST['loginCM'], $_POST['passwdCM']));

    return $cnx->lastInsertId();
}

function addCP($cnxdb)
{
    //requete d'insertion a la base de donnee
    $requete="INSERT INTO `client_physique`(`id`, `nom`, `prenom`,
                    `telephone`, `salaire`, `adresse`, `profession`,
                     `login`, `password`, `email`, `nci`, `typeclt_id`,
                      `cltmoral_id`) 
                      VALUES (null,?,?,?,?,?,?,?,?,?,?,?,?)";
    //Cas d'un salarier
    if($_POST['statutcp']==1)
    {
        //Cas d'un salarier dont sont employeur est un client de la banque
        if($_POST['employeur']!=3)
        {
            /**
             * execution de la requete
             */
            $prepareStetement=$cnxdb->prepare($requete);
            $prepareStetement->execute(array($_POST['nomcp'],$_POST['prenomcp'],
                                                        $_POST['telephonecp'],$_POST['salairecp'],$_POST['adressecp'],
                                                        $_POST['professioncp'],$_POST['logincp'],$_POST['passwdcp'],
                                                        $_POST['emailcp'],$_POST['cnicp'],$_POST['statutcp'],
                                                        $_POST['employeur']));
            return $cnxdb->lastInsertId();
        }
        else{
            //Cas d'un employeur inexistant pour un nouveau salarier

            //Ajout de l'employeur puis on recupere son id $idEmp
            $idEmp=addCM($cnxdb);
            /**
             * execution de la requete
             */
            $prepareStetement=$cnxdb->prepare($requete);
            $prepareStetement->execute(array($_POST['nomcp'],$_POST['prenomcp'],
                                                $_POST['telephonecp'],$_POST['salairecp'],$_POST['adressecp'],
                                                $_POST['professioncp'],$_POST['logincp'],$_POST['passwdcp'],
                                                $_POST['emailcp'],$_POST['cnicp'],$_POST['statutcp'],
                                                $idEmp));
            return $cnxdb->lastInsertId();
        }
    }
    else{
        //cas d'un non salarier
        /**
         * execution de la requete
         */
        try{
            $prepareStetement=$cnxdb->prepare($requete);
            $prepareStetement->execute(array($_POST['nomcp'],$_POST['prenomcp'], $_POST['telephonecp'],
                null,$_POST['adressecp'],
                $_POST['professioncp'],$_POST['logincp'],$_POST['passwdcp'],
                $_POST['emailcp'],$_POST['cnicp'],$_POST['statutcp'],
                null));
            echo 'test';
            return $cnxdb->lastInsertId();
        }catch (Exception $ex){

            echo $ex->getMessage();
        }

        return $cnxdb->lastInsertId();
    }

}

/*
* Ajout d'un client
 * */
if(isset($_POST) && !empty($_POST))
{
    /*
     *
     * On test pour savoir si c'est un client
     * moral ou un client physique
     *
     * */
    $cnxdb=getConnexion();

    if($_POST['typeclient']==2)
    {
        //Cas d'un client moral

        $result=addCM($cnxdb);
        if($result)
        {
            echo 'Client moral ajoute!...'.$result;

        }
        else{
            echo 'Client moral non ajoute!...';
        }

    }
    else{
        //Cas d'un client physique

        $result=addCP($cnxdb);
        if($result)
        {
            echo 'Client physique ajoute!...'.$result;

        }
        else{
            echo 'Client physique non ajoute!...'.$result;
        }

    }

}
