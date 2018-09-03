<?php

    session_start();
    include_once './biblioteke/header.php';
    include_once './biblioteke/baza.php';
    $baza = new Baza();
    $error = "";
    
    if ($_SESSION['userType'] != "Administrator"){
        header ("Location: index.php");
    }
    
    $tipovi ="";
    $queryTipovi = "SELECT * FROM tip_korisnika";
    $resultTipovi = $baza->selectDB($queryTipovi);
    while ($rowTip = mysqli_fetch_assoc($resultTipovi)){
        $tipovi .= "<option value='" . $rowTip['tip_id'] . "'>" . $rowTip['naziv'] . "</option>";
    }
    
    if ($_SERVER['REQUEST_METHOD'] == "POST"){
        $tip = $_POST['tip'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $ime = $_POST['ime'];
        $prezime = $_POST['prezime'];
        $email = $_POST['email'];
        
        $imeslike = $_FILES['slika']['name'];
        $putanjaSlike = "korisnici/".$imeslike;
        
        if ($imeslike !=""){
            move_uploaded_file($_FILES['slika']['tmp_name'], $putanjaSlike);
        }
        
        $queryKorisnik = "INSERT INTO korisnik (tip_id, korisnicko_ime, lozinka, ime, prezime, email, slika) VALUES ('{$tip}', '{$username}', '{$password}', '{$ime}', '{$prezime}', '{$email}', '{$putanjaSlike}')";
        $resultKorisnik = $baza->updateDB($queryKorisnik);
        $error = "Uspješno ste unijeli novog korisnika";
        
    }
?>

<header>
    <h1>Kreiraj korisnika</h1>
</header>
<nav>
    <?php 
        $navigacija ="<ul>";
        if (!isset($_SESSION['userType'])){
            $navigacija .= "<li><a href='index.php'> Početna stranica </a> </li>";
            $navigacija .= "<li><a href='o_autoru.html'> Osobna stranica </a> </li>";
            $navigacija .= "<li><a href='login.php'> Prijava </a> </li>"; 
        }
        else if ($_SESSION['userType']=="User"){
            $navigacija .= "<li><a href='index.php'> Početna stranica </a> </li>"; 
            $navigacija .= "<li><a href='o_autoru.html'> Osobna stranica </a> </li>"; 
            $navigacija .= "<li><a href='browseZapisnik.php'> Pregled zapisnika </a> </li>"; 
            $navigacija .= "<li><a href='createZapisnik.php'> Kreiranje zapisnika </a> </li>"; 
            $navigacija .= "<li><a href='createZapis.php'> Kreiranje zapisa </a> </li>"; 
            $navigacija .= "<li><a href='biblioteke/logout.php'> Odjava </a> </li>";
        }
        else if ($_SESSION['userType']=="Moderator"){
            $navigacija .= "<li><a href='index.php'> Početna stranica </a> </li>"; 
            $navigacija .= "<li><a href='o_autoru.html'> Osobna stranica </a> </li>"; 
            $navigacija .= "<li><a href='browseZapisnik.php'> Pregled zapisnika </a> </li>"; 
            $navigacija .= "<li><a href='createZapisnik.php'> Kreiranje zapisnika </a> </li>"; 
            $navigacija .= "<li><a href='createZapis.php'> Kreiranje zapisa </a> </li>"; 
            $navigacija .= "<li><a href='browseBiljka.php'> Pregled biljaka </a> </li>"; 
            $navigacija .= "<li><a href='createBiljka.php'> Dodavanje biljaka </a> </li>"; 
            $navigacija .= "<li><a href='biblioteke/logout.php'> Odjava </a> </li>";
        }
        else {
            $navigacija .= "<li><a href='index.php'> Početna stranica </a> </li>"; 
            $navigacija .= "<li><a href='o_autoru.html'> Osobna stranica </a> </li>"; 
            $navigacija .= "<li><a href='browseZapisnik.php'> Pregled zapisnika </a> </li>"; 
            $navigacija .= "<li><a href='createZapisnik.php'> Kreiranje zapisnika </a> </li>"; 
            $navigacija .= "<li><a href='createZapis.php'> Kreiranje zapisa </a> </li>"; 
            $navigacija .= "<li><a href='browseBiljka.php'> Pregled biljaka </a> </li>"; 
            $navigacija .= "<li><a href='createBiljka.php'> Dodavanje biljaka </a> </li>";
            $navigacija .= "<li><a href='browseVrsta.php'> Pregled vrsta </a> </li>"; 
            $navigacija .= "<li><a href='createVrsta.php'> Kreiranje vrsta </a> </li>"; 
            $navigacija .= "<li><a href='browseKorisnik.php'> Pregled korisnika </a> </li>"; 
            $navigacija .= "<li><a href='createKorisnik.php'> Dodavanje korisnika </a> </li>";
            $navigacija .= "<li><a href='biblioteke/logout.php'> Odjava </a> </li>";
        }
        $navigacija .="</ul>";
        echo $navigacija;
    ?>
</nav>
<section id="sadrzaj">
    <div>
        <?php 
            echo $error;
        ?>
    </div>
    <form name="formKorisnik" method="post" action="createKorisnik.php" enctype="multipart/form-data">
        <label for="tip">Tip korisnika</label>
        <select id="tip" name="tip">
            <?php echo $tipovi; ?>
        </select></br>
        <label for="username">Korisničko ime</label>
        <input type="text" id="username" name="username"></br>
        <label for="password">Lozinka</label>
        <input type="text" id="password" name="password"></br>
        <label for="ime">Ime</label>
        <input type="text" id="ime" name="ime"></br>
        <label for="prezime">Prezime</label>
        <input type="text" id="prezime" name="prezime"></br>
        <label for="email">Email</label>
        <input type="email" id="email" name="email"></br>
        <label for="slika">Slika</label>
        <input type="file" id="slika" name="slika"></br>
        <input type="submit" name="submit" value="Kreiraj korisnika"></br>
        <input type="reset" name="reset" value="Inicijaliziraj"></br>
    </form>
</section>
<?php 
    include_once './biblioteke/footer.php';
?>