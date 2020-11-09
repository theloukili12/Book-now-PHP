<?php
require_once "../elements/doctype.php";
require "../functions.php";
loadClasses();
$demande = new demandes;
if (isset($_GET['demande_type']) && isset($_GET['id']) && isset($_GET['decision']) && isset($_GET['demande_id'])) {
    if ($_GET['decision'] == 1)
        $demande->demandeAction($_GET['demande_type'], $_GET['id'], $_GET['decision']);
    $demande->finishDemande($_GET['demande_id']);
}
$Hotels_demandes = $demande->gethotels_Demandes();
$Users_demandes = $demande->getusers_demandes();
$Hotels_columns = $demande->db->getColumnArray($Hotels_demandes);
$Users_column = $demande->db->getColumnArray($Users_demandes);
?>
<html>

<head>
    <title>Demandes des utilisateurs - <?php echo App_Name; ?></title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="../assets/css/main.css" />
</head>

<body class="is-preload">
    <div id="page-wrapper">
        <!-- Header -->
        <?php include_once '../elements/top-bar-normal.php'; ?>
        <!-- Main -->
        <section id="main" class="container">
            <div class="row">
                <div class="col-12">
                    <section class="box">
                        <form method="post" name="hotels-form" id="hotels-form" action="#">
                            <div class="col-12 col-12-mobilep">
                                <h3 style="border-bottom: solid 1px #e5e5e5;">L'ajout des hôtels :</h3>
                            </div>
                            <?php
                            if ($Hotels_demandes->num_rows > 0)
                                showHotel_Demandes($Hotels_demandes, $Hotels_columns);
                            else
                                echo '<p>Pas de demande d\'ajout des nouveaux hôtels.</p>';
                            ?>
                            <div class="col-12 col-12-mobilep">
                                <h3 style="border-bottom: solid 1px #e5e5e5;">Changement du types de compte :</h3>
                            </div>
                            <?php
                            if ($Users_demandes->num_rows > 0)
                                showHotel_Demandes($Users_demandes, $Users_column);
                            else
                                echo '<p>Pas de demande des utilisateurs.</p>';
                            ?>
                        </form>
                    </section>
                </div>
        </section>
    </div>
    </div>
    </section>
    <?php include_once '../elements/footer.php'; ?>
    </div>
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/jquery.dropotron.min.js"></script>
    <script src="../assets/js/jquery.scrollex.min.js"></script>
    <script src="../assets/js/browser.min.js"></script>
    <script src="../assets/js/breakpoints.min.js"></script>
    <script src="../assets/js/util.js"></script>
    <script src="../assets/js/main.js"></script>
</body>

</html>