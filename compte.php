<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="description" content="Gestion des activites bancaires"/>
    <meta name="author" content="mballoSoft"/>
    <title>Add | Compte</title>
    <link rel="stylesheet" href="./css/client.css"/>
    <link rel="stylesheet" href="./css/main.css"/>
    <link rel="stylesheet" href="./css/compte.css"/>
</head>
<body>
<header>
    <nav>
        <h1>Banque Du <span style="color: aliceblue;">Peuple</span></h1>
    </nav>
</header>

<!--=========Debut sideBarre============-->
<aside class="sidebarre">
    <div class="flex">
        <img src="./img/profil.jpg" class="profil" alt="Banque du Peuple" srcset=""/>
        <p class="mail">xywzt@gmail.com</p>
        <div class="contener" style="background-color: rgb(85, 163, 231); color: white;">
            Dashboard
        </div>
        <div class="contener">
            <a href="./compte.php">Compte</a>
        </div>
        <div class="contener">
            <a href="./client.php">Client</a>
        </div>
        <div class="contener">
            Logout
        </div>
    </div>
</aside>
<!--=========Fin sideBarre============-->

<!--=========Contenu du body==========-->
<article class="content">
    <fieldset>
        <legend>Creation Compte</legend>
        <form method="post" onsubmit="return post()" class="form" action="traittementcompte.php">
            <div class="row">
                <?php
                include './listTypeCompte.php';
                ?>
                <label for="solde">Solde</label>
                <input type="text" class="inputcl" id="solde" name="solde"/>
            </div>
            <div class="row">
                <label for="frai">Frais:<b id="frai"></b></label>
                <?php
                    echo "<select name='client' id='client' class='selectcmpt'>";
                    echo "<option value='0'>-------List des Clients--------</option>";
                    echo "<option disabled>--------Client Moral------------</option>";
                    include './traittementcompte.php';
                    echo "</select>";
                ?>

            </div>
            <div class="row">
                <button type="submit" class="valider">Ajouter</button>
                <button type="reset" class="annuler">Annuler</button>
            </div>
        </form>
    </fieldset>
</article>
<script src="./js/compte.js"></script>
<script src="./js/main.js"></script>
</body>
</html>
