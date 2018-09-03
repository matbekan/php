<?php

    session_start();
    include_once './biblioteke/header.php';
    include_once './biblioteke/baza.php';
    $baza = new Baza();
    $error = "";
    
    if (isset($_SESSION['userType'])){
        header ("Location: index.php");
    }
    
    if ($_SERVER['REQUEST_METHOD'] == "POST"){
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        if ($username == null || $password == null){
            $error = "Niste unijeli sve podatke";
        }
        
        if (!$error){
            $queryLogin = "SELECT * FROM korisnik WHERE korisnicko_ime='{$username}' AND lozinka='{$password}'";
            $resultLogin = $baza->selectDB($queryLogin);
            
            if ($resultLogin->num_rows == 1){
                $rowLogin = mysqli_fetch_assoc($resultLogin);
                if ($rowLogin['tip_id'] == 0) $_SESSION['userType'] = "Administrator";
                else if ($rowLogin['tip_id'] == 1) $_SESSION['userType'] = "Moderator";
                else $_SESSION['userType'] = "User";
                
                $_SESSION['userID'] = $rowLogin['korisnik_id'];
                header ("Location: browseZapisnik.php");
            }
            else {
                $error = "Unijeli ste neispravne podatke";
            }
        }
    }
    
    



?>

<header>
    <h1>Prijava</h1>
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
    <form name="formLogin" method="post" action="login.php">
        <label for="username">Korisničko ime</label>
        <input type="text" id="username" name="username" autofocus=""></br>
        <label for="password">Lozinka</label>
        <input type="password" id="password" name="password"></br>
        <input type="submit" name="submit" value="Prijavi me"></br>
        <input type="reset" name="reset" value="Inicijaliziraj"></br>
    </form>
</section>
<?php 
    include_once './biblioteke/footer.php';
?>