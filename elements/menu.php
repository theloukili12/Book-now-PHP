<nav id="nav">
    <ul>
        <li><a href="/index.php">Accueil</a></li>
        <li><a href="/contact.php">Contactez-nous</a></li>
        <li><a href="/a_propos_de_nous.php">À propos de nous</a></li>
        <?php if (isset($_SESSION['user_id']) && isset($_SESSION['user_role']) ) {
            echo '<li><a href="#" class="icon solid fa-bars">Options</a>';
            echo '<ul><li><a class="icon solid fa-user" href="/profil.php"> Profil</a></li>';
            echo '<li><a class="icon solid fa-user-edit" href="/modifier_profil.php"> Modifier</a></li>';
            echo '<li><a class="icon solid fa-history" href="/historique.php"> Mon historique</a></li>';
            if($_SESSION['user_role'] == 2){
                echo '<hr style="margin:0;">';
                echo '<li><a class="icon solid fa-plus" href="/ajouter_hotel.php"> Ajouter un Hôtel</a></li>';
                echo '<li><a class="icon solid fa-list" href="/meshotels.php"> Mes hôtels</a></li>';
                echo '<li><a class="icon solid fa-clipboard-list" href="/hotels_reservations.php"> Reservations</a></li>'; 
            }
            else if($_SESSION['user_role'] == 3){
                echo '<hr style="margin:0;">';
                echo '<li><a class="icon solid fa-list" href="/admin/demandes.php"> Demandes</a></li>';
                echo '<li><a class="icon solid fa-users" href="/admin/gestion_utilisateurs.php"> Utilisateurs</a></li>';
            }
            
            echo '</ul></li>';
        } ?>

        <?php
        if (!isset($_SESSION['user_id'])){
            echo '<li><a class="icon solid fa-sign-in-alt" href="/connexion.php" class="button">Connexion</a></li>';
            echo '<li><a class="icon solid fa-user-plus button" href="/inscription.php" class="button">Inscription</a></li>';
        }
        else
            echo '<li><a class="icon solid fa-sign-out-alt"  href="/deconnexion.php" class="button">Déconnecter</a></li>';
        ?>
    </ul>
</nav>


<!-- 
<li>
                    <a href="/pfe#">Submenu</a>
                    <ul>
                        <li><a href="/pfe#">Option One</a></li>
                        <li><a href="/pfe#">Option Two</a></li>
                        <li><a href="/pfe#">Option Three</a></li>
                        <li><a href="/pfe#">Option Four</a></li>
                    </ul>
                </li> -->