<?php

    session_start();
    include_once './biblioteke/header.php';
    include_once './biblioteke/baza.php';
    $baza = new Baza();
    $error = "";
    
    if ($_SESSION['userType'] != "Administrator"){
        header ("Location: index.php");
    }
    
    if ($_SERVER['REQUEST_METHOD'] == "POST"){
        $search = $_POST['search'];
    }
    else{
        $search = "";
    }
    $tableKorisnici = "<table></thead><th>Tip korisnika</th><th>Korisničko ime</th><th>Lozinka</th><th>Ime</th><th>Prezime</th><th>Email</th><th>Slika</th><th></th></thead><tbody>";
    if ($search == ""){
        $queryKorisnici = "SELECT * FROM korisnik";
        $resultKorisnici = $baza->selectDB($queryKorisnici);
    }
    else {
        $queryKorisnici = "SELECT * FROM korisnik WHERE tip_id LIKE '%$search%' OR prezime LIKE '%$search%'";
        $resultKorisnici = $baza->selectDB($queryKorisnici);
    }
    
    if ($resultKorisnici->num_rows == 0){
        $error = "Nema ni jedan zapis prema traženom parametru.";
    }
    else {
        while ($rowKorisnici = mysqli_fetch_assoc($resultKorisnici)){
            $tableKorisnici .= "<tr>";
            $tableKorisnici .= "<td>". $rowKorisnici['tip_id'] ."</td>";
            $tableKorisnici .= "<td>". $rowKorisnici['korisnicko_ime'] ."</td>";
            $tableKorisnici .= "<td>". $rowKorisnici['lozinka'] ."</td>";
            $tableKorisnici .= "<td>". $rowKorisnici['ime'] ."</td>";
            $tableKorisnici .= "<td>". $rowKorisnici['prezime'] ."</td>";
            $tableKorisnici .= "<td>". $rowKorisnici['email'] ."</td>";
            $tableKorisnici .= "<td><img src='". $rowKorisnici['slika'] ."' width='300' height='300'/></td>";
            $tableKorisnici .= "<td><a href='updateKorisnik.php?update=". $rowKorisnici['korisnik_id'] ."'>Ažuriraj korisnika</a></td>";
            $tableKorisnici .= "</tr>";
        }
    }
    $tableKorisnici .= "</tbody></table>";
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
        <?php echo $error; ?>
    </div>
    <form name="browseKorisnik" method="post" action="browseKorisnik.php">
        <label for="search">Unesite ključnu riječ</label>
        <input type="text" id="search" name="search"></br>
        <input type="submit" name="submit" value="Pretraži"></br>
    </form>
    <?php 
        if (!$error) echo $tableKorisnici;
    ?>
</section>
<?php 
    include_once './biblioteke/footer.php';
?>