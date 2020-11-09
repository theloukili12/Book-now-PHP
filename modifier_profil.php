<?php
session_start();
$message = "";
$messageP = "";
if (!isset($_SESSION['user_id'])) {
    header("Location:index.php");
}

require "functions.php";
loadClasses();
$profil = new user;
$profil->getUserinfos($_SESSION['user_id']);
$roles = $profil->getroles();

$email = $profil->email;
$password = $profil->password;
$f_name = $profil->f_name;
$l_name = $profil->l_name;
$date_birth = $profil->date_birth;
$gender = $profil->gender;
$phone = $profil->phone;
$address =  $profil->address;
$country = $profil->country;
$picture = $profil->picture;
$date_register = $profil->date_register;
$picture = ($profil->picture == "" ? "images/user.png" :  $profil->picture);
$pwd = '';
$cpwd = '';
if (isset($_POST['edit-pwd'])) {

    if (isset($_POST['select-role']) && $_POST['select-role'] != 1) {

        $profil->editRole($_SESSION['user_id'], $_POST['select-role']);
        phpAlert("Votre de demande a été envoyer a l'administration/nMerci de patienter!");
    }
    $pwd = $_POST['pwd'];
    $cpwd = $_POST['cpwd'];
    if ($pwd != "" && $cpwd != "") {
        if ($pwd != $cpwd) {
            $messageP = '<h4 style="color:red;">le mot de passe de confirmation n\'est pas identique</h4>';
        } else {
            $profil->password = $pwd;
            $profil->edituserPassword();
            header("Location:profil.php");
        }
    }
}
if (isset($_POST['edit'])) {
    $img = 'file';
    if ((($_FILES[$img]["type"] == "image/jpeg")
            || ($_FILES[$img]["type"] == "image/pjpeg")
            || ($_FILES[$img]["type"] == "image/jpg")
            || ($_FILES[$img]["type"] == "image/png"))
        && ($_FILES[$img]["size"] < 5000000)
        && (strlen($_FILES[$img]["name"]) < 51)
    ) {
        $file_name = $_FILES['file']['name'];
        $file_type = pathinfo($file_name, PATHINFO_EXTENSION);
        $file_size = $_FILES['file']['size'];

        $newfile_path = "images/Users/" . md5(rand()) . "." . $file_type;

        $profil->picture = $newfile_path;
        move_uploaded_file($_FILES['file']['tmp_name'], $newfile_path);
    } else {
        $message = '<h4 style="color:red;">La taille du fichier ne doit pas dépasser <strong>5Mb</strong>.<br> ou le type de fichier est incompatible
        </h4>';
    }
    $profil->l_name = $_POST['l_name'];
    $profil->f_name = $_POST['f_name'];
    $profil->date_birth = $_POST['date_birth'];
    if ($_POST['country'] != "")
        $profil->country = $_POST['country'];
    $profil->gender = $_POST['sexe'];
    $profil->address = $_POST['address'];
    $profil->phone = $_POST['phone'];

    $profil->user_id = $_SESSION['user_id'];
    $profil->edituser();
    Redirect("profil.php");
}
?>
<?php require "elements/doctype.php"; ?>
<html>

<head>
    <title>Modifier mon profil - <?php echo App_Name; ?></title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="assets/css/main.css" />
    <link rel="stylesheet" href="assets/css/profilStyle.css" />
    <script>

    </script>
</head>

<body class="is-preload">
    <div id="page-wrapper">

        <!-- Header -->
        <?php include_once 'elements/top-bar-normal.php'; ?>

        <!-- Main -->
        <section id="main" class="container">
            <!-- <header>
                <h2>Page name</h2>
                <p>Description of the page role for example</p>
            </header> -->
            <div class="row">
                <div class="col-12">

                    <!-- Text -->
                    <section class="box">
                        <!-- <div class="container emp-profile"> -->
                        <form method="post" enctype="multipart/form-data">
                            <div class="row gtr-uniform gtr-50">
                                <div class="col-6 col-12-mobilep">
                                    <div class="profile-img">
                                        <img src="<?php echo $picture;  ?>" alt="" />
                                    </div>
                                </div>
                                <div class="col-6 col-12-mobilep center-mobile">
                                    <div class="profile-head">
                                        <h3>
                                            <?php echo $profil->l_name . " " . $profil->f_name; ?>
                                        </h3>
                                        <h4>
                                            Web Developer and Designer
                                        </h4>
                                    </div>
                                    <div>
                                        <input type="file" name="file">
                                    </div>
                                </div>
                            </div>
                            <div class="row gtr-uniform gtr-50">
                                <div class="col-12 col-12-mobilep">
                                    <h3 style="border-bottom: solid 1px #e5e5e5;">Informations personnelles</h3>
                                </div>
                                <div class="col-6 col-12-mobilep">
                                    <label for="f_name">Nom : </label>
                                    <input type="text" id="f_name" name="f_name" value="<?php echo $f_name; ?>">
                                </div>
                                <div class="col-6 col-12-mobilep">
                                    <label for="l_name">Prénom : </label>
                                    <input type="text" name="l_name" class="form-control" value="<?php echo $l_name; ?>">
                                </div>
                                <div class="col-6 col-12-mobilep">
                                    <label for="date-birth">Date de naissance : </label>
                                    <input type="date" name="date_birth" class="form-control" value="<?php echo $date_birth; ?>">
                                </div>
                                <div class="col-6 col-12-mobilep">
                                    <label for="radio-M">Sexe : </label>
                                    <input type="radio" id="radio-M" value="M" class="form-control" name="sexe" <?php echo ($gender == "M" ? "checked" : "unchecked")  ?>><label for="radio-M">Masculin</label>
                                    <input type="radio" id="radio-F" value="F" class="form-control" name="sexe" <?php echo ($gender == "F" ? "checked" : "unchecked")  ?>><label for="radio-F">Feminin</label>
                                </div>
                                <div class="col-6 col-12-mobilep">
                                    <label for="phone">Télephone : </label>
                                    <input type="text" pattern="(\+212|0)([ \-_/]*)(\d[ \-_/]*){9}" name="phone" class="form-control" value="<?php echo $phone; ?>">
                                </div>
                                <div class="col-6 col-12-mobilep">
                                    <label for="country">Pays : </label>
                                    <?php
                                    require "elements/select-pays.php";

                                    ?>
                                </div>
                                <div class="col-12 col-12-mobilep">
                                    <label for="address">Adresse : </label>
                                    <textarea class="form-control" name="address"><?php echo $address; ?></textarea>
                                </div>

                                <?php echo $message; ?>
                                <div class="col-12 align-right">
                                    <input type="submit" name="edit" value="Enregistrer">
                                </div>
                            </div>
                        </form>
                        <form method="post">
                            <div class="row gtr-uniform gtr-50">
                                <div class="col-12 col-12-mobilep">
                                    <h3 style="border-bottom: solid 1px #e5e5e5;">Informations du compte</h3>
                                </div>
                                <div class="col-6 col-12-mobilep">
                                    <p id="f-name"><span class="profil-label">Email : </span><?php echo $email; ?></p>
                                </div>
                                <div class="col-6 col-12-mobilep">
                                    <p id="f-name"><span class="profil-label">Date d'inscription : </span><?php echo ($date_register == "" ? "vide" : $date_register); ?></p>
                                </div>
                                <div class="col-6 col-12-mobilep">
                                    <label for="pwd" class="profil-label">Mot de passe : </label>
                                    <input type="password" name="pwd" class="form-control" minlength="6" datami value="<?php echo $pwd; ?>">
                                </div>

                                <div class="col-6 col-12-mobilep">
                                    <label for="cpwd" class="profil-label">Confirmer Mot de passe : </label>
                                    <input type="password" name="cpwd" class="form-control" minlength="6" value="<?php echo $cpwd; ?>">
                                </div>
                                <div class="col-6 col-12-mobilep">
                                    <label for="select-role" class="profil-label">Mot de passe : </label>
                                    <select name="select-role">
                                        <?php
                                        while ($row = mysqli_fetch_assoc($roles)) {
                                            echo '<option value="' . $row["role_id"] . '" ' . ($profil->role == $row['role_id'] ? "selected" : "") . '>' . $row["role_name"] . '</option>';
                                        }
                                        ?>qz

                                    </select>
                                </div>

                                <div class="col-6">
                                    <label for="select-role" class="profil-label">Voulez vous supprimer votre compte ? </label>
                                    <div class=" align-right">
                                        <a class="align-right button alt supprimer-compte" date-yid="<?php echo $_SESSION['user_id'] ?>">Supprimer mon compte</a>
                                    </div>
                                </div>
                                <?php echo $messageP; ?>
                                <div class="col-12  align-right">
                                    <ul class="actions fit">
                                        <li><input type="submit" id="edit-pwd" name="edit-pwd" value="Enregistrer"></li>
                                        <li><a href="profil.php" class="button alt">Annuler</a></li>
                                    </ul>
                                </div>
                            </div>
                        </form>
                        <!-- </div> -->

                    </section>

                </div>
            </div>
        </section>

        <!-- Footer -->
        <?php include_once 'elements/footer.php'; ?>

    </div>

    <!-- Scripts -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/jquery.dropotron.min.js"></script>
    <script src="assets/js/jquery.scrollex.min.js"></script>
    <script src="assets/js/browser.min.js"></script>
    <script src="assets/js/breakpoints.min.js"></script>
    <script src="assets/js/util.js"></script>
    <script src="assets/js/main.js"></script>

    <!-- <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css"> -->
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".supprimer-compte").click(function() {
                if (confirm("Voulez vous vraiment supprimer votre compte ?")) {
                    uid = <?php echo $_SESSION['user_id'] ?>;
                    $.ajax({
                        url: "admin/supprimer_user.php",
                        type: 'POST',
                        data: {
                            uid: uid
                        },
                        success: function(msg) {
                            if (msg == 'true') {
                                window.location.href = "deconnexion.php";
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