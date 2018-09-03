<?php 
    
    session_start();
    include_once './biblioteke/header.php';
    include_once './biblioteke/baza.php';
    $baza = new Baza();
    
    $tableVrsta = "<table><thead><th>Naziv</th><th></th></thead><tbody>";
    $queryVrsta = "SELECT * FROM vrsta";
    $resultVrsta = $baza->selectDB($queryVrsta);
    
    while ($rowVrsta = mysqli_fetch_assoc($resultVrsta)){
        $tableVrsta .= "<tr>";
        $tableVrsta .= "<td>". $rowVrsta['naziv'] ."</td>";
        $tableVrsta .= "<td><a href='index.php?vrsta=". $rowVrsta['vrsta_id'] ."'>Prikaži biljke</a></td>";
        $tableVrsta .= "</tr>";
    }
    $tableVrsta .= "</tbody></table>";
    
    
    if (isset($_GET['vrsta'])){
        $vrsta = (int)$_GET['vrsta'];
    }
    else {
        $vrsta = 0;
    }
    
    if ($vrsta != 0){
        $tableBiljke = "<table><thead><th>Naziv</th></thead><tbody>";
        $queryBiljke = "SELECT * FROM biljka WHERE vrsta_id = $vrsta";
        $resultBiljke = $baza->selectDB($queryBiljke);
        
        while ($rowBiljke = mysqli_fetch_assoc($resultBiljke)){
            $tableBiljke .= "<tr>";
            $tableBiljke .= "<td>". $rowBiljke['naziv'] ."</td>";
            $tableBiljke .= "</tr>";
        }
        $tableBiljke .= "</tbody></table>";
    }
    
?>

<header>
    <h1>Biljke</h1>
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
    <?php 
        echo $tableVrsta;
        if ($vrsta != 0){
            echo $tableBiljke;
        }
    ?>
</section>
<?php 
    include_once './biblioteke/footer.php';
?>