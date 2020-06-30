<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="description" content="Gestion des activites bancaires"/>
    <meta name="author" content="mballoSoft"/>
    <title>Add | Compte</title>
    <link rel="stylesheet" href="./css/main.css"/>
    <link rel="stylesheet" href="./css/compte.css"/>
    <link rel="stylesheet" href="./css/client.css"/>
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
        <form action="" class="form">
            <div class="row">
                <select name="typecp" class="selectcmpt" id="typecp" onchange="frais()">
                    <option value="0">--Type Compte--</option>
                    <option value="1">Xewel | Epargne</option>
                    <option value="2">Courant</option>
                    <option value="2">Bloquer</option>
                </select>
                <select name="client" id="client" class="slct">
                    <option value="0">--Clients--</option>
                    <option value="1">Client1</option>
                    <option value="2">Client2</option>
                </select>
            </div>
            <div class="row">
                <label for="frai">Frais:<b id="frai"></b></label>
            </div>
            <div class="row">
                <button type="button" class="valider" onclick="post()">Ajouter</button>
                <button type="reset" class="annuler">Annuler</button>
            </div>
        </form>
    </fieldset>
</article>
<script src="./js/compte.js"></script>
<script src="./js/main.js"></script>
</body>
</html>
