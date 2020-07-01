<?php
$userrole = [2, 3, 4];
include("./php-scripts/security.php");

// Opvragen van gegevens van de huidige inlogger
include("./php-scripts/connectDB.php");
include("./php-scripts/functions.php");
$id = $_SESSION["id"];
$userrole = $_SESSION["userrole"];

// Get all userinfo
$result = getSpecificInfo('pro4_users', 'userid', $id);
$userinfo = mysqli_fetch_assoc($result);

// Ophalen van alle persoonlijke info
$sql = "SELECT p.* from `pro4_personalinfo` p
        left join `pro4_users` u on u.userid = p.userid
        where u.userid = '$id'";
$result1 = mysqli_query($conn, $sql);
$pinfo = mysqli_fetch_assoc($result1);
$fullname = $pinfo["name"] . ' ' . $pinfo["infix"] . ' ' . $pinfo["lastname"];


?>

<!-- Navbar op de myaccount pagina -->
<div class="container-fluid">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <nav class="nav nav-pills nav-fill">
          <a class="nav-item nav-link" href="#gegevens">Gegevens</a>
          <a class="nav-item nav-link" href="#bestellingen">Bestellingen</a>
          <a class="nav-item nav-link" href="#assortiment">Assortiment</a>
          <a class="nav-item nav-link" href="#aanpassen">Aanpassen/wijzigen</a>
        </nav>
      </div>
    </div>
  </div>
</div>

<!-- Content van pagina -->
<div class="container-fluid">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <h2 id="home" class="text-center">Admin panel</h2>
        <hr>
      </div>
    </div>

    <!-- Persoonlijke gegevens -->
    <div class="row">
      <div class="col-12">
        <h2 class="text-center" id="gegevens">Mijn persoonlijke gegevens</h2>
      </div>
      <!-- Persoonlijke info -->
      <table class="table table-hover col-12 col-md-5">
        <thead>
          <tr>
            <th scope="col">Mijn gegevens</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Gebruikersnaam</td>
            <td><?php echo $userinfo["username"]; ?></td>
          </tr>
          <tr>
            <td>Naam</td>
            <td><?php echo $fullname; ?></td>
          </tr>
          <tr>
            <td>Geboortedatum</td>
            <td><?php echo $pinfo["birthday"]; ?></td>
          </tr>
          <tr>
            <td>Email</td>
            <td><?php echo $userinfo["email"]; ?></td>
          </tr>
        </tbody>
      </table>
      <!-- Mijn adres gegevens -->
      <table class="table table-hover col-12 offset-0 col-md-5 offset-md-2 myacc-card">
        <thead>
          <tr>
            <th scope="col">Mijn adres</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Straatnaam</td>
            <td><?php echo $pinfo["streetname"]; ?></td>
          </tr>
          <tr>
            <td>Huisnummer</td>
            <td><?php echo $pinfo["housenumber"]; ?></td>
          </tr>
          <tr>
            <td>Postcode</td>
            <td><?php echo $pinfo["postalcode"]; ?></td>
          </tr>
          <tr>
            <td>Stad</td>
            <td><?php echo $pinfo["city"]; ?></td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Bestellingen -->
    <div class="row">
      <div class="col-12">
        <h2 class="text-center" id="bestellingen">Bestellingen</h2>
      </div>
      <div class="col-12">
        <table class="table table-hover" width="100%">
          <thead>
            <tr>
              <th scope="col">Ordernummer</th>
              <th scope="col">Gebruiker</th>
              <th scope="col">Status</th>
              <th scope="col">Bekijken</th>
            </tr>
          </thead>
          <tbody>
            <?php
            // Alle orders ophalen van deze userid
            $result = getInfo('pro4_orders');
            
            while ($d = mysqli_fetch_assoc($result)) {
              adminDisplayOrder($d["orderid"], $d["orderstatusid"], $d["userid"]);
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Assortiment -->
    <div class="row">
      <div class="col-12">
        <h2 class="text-center" id="assortiment">Assortiment</h2>
      </div>
      <div class="col-12">
        <table class="table table-hover" width="100%">
          <thead>
            <tr>
              <th scope="col">ProductID</th>
              <th scope="col">Naam</th>
              <th scope="col">IMG</th>
              <th scope="col">Prijs</th>
              <th scope="col">BTW</th>
              <th scope="col">Omschrijving</th>
              <th scope="col">Wijzigen</th>
            </tr>
          </thead>
          <tbody>
            <?php
            // Alle orders ophalen van deze userid
            $result = getInfo('pro4_products');
            
            while ($d = mysqli_fetch_assoc($result)) {
              adminDisplayProduct($d["productid"], $d["pname"], $d["pimage"], $d["pprice"], $d["pbtw"], $d["pdesc"]);
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Aanpassen/wijzigen -->
    <div class="row">
      <div class="col-12">
        <h2 class="text-center" id="aanpassen">Aanpassen/wijzigen</h2>
        <hr>
      </div>
      <div class="col-12">
        <table class="table table-hover myacc-card tablelinks" width="100%">
          <thead>
            <tr>
              <th scope="col">Aanpassen/wijzigen</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><a href="index.php?content=editpersonalinfo">Mijn gegevens wijzigen</a></td>
            </tr>
            <tr>
              <td><a href="index.php?content=editaddress">Mijn adres wijzigen</a></td>
            </tr>
            <tr>
              <td><a href="index.php?content=editlogin">Mijn wachtwoord wijzigen</a></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>