<?php
require_once "../elements/doctype.php";
require "../functions.php";
loadClasses();
$us = new user;
$users = $us->getAllUsers();
$columns = $us->db->getColumnArray($users);
?>
<html>

<head>
    <title>Gestion des utilisateurs - <?php echo App_Name; ?></title>
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
                                <h3 style="border-bottom: solid 1px #e5e5e5;">Utilisateurs :</h3>
                            </div>
                            <div class="col-12">
                                <?php
                                require "../elements/users_table.php";
                                ?>
                            </div>
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
    <script>
        $(document).ready(function() {
            $(".delete-user").click(function() {
                if (confirm("Voulez vous vraiment supprimer ce utilisateur ?")) {
                    uid = $(this).attr("data-uid");
                    $.ajax({
                        url: "supprimer_user.php",
                        type: 'POST',
                        data: {
                            uid: uid
                        },
					success: function(msg) {
						if (msg == 'true') {					
                            window.location.reload();
						} else {
							alert("error de serveur! merci de resseryer!!!");
						}
					}
                    });
                }
            });

        });
    </script>
</body>

</html>