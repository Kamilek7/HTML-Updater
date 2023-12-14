<?php
	session_start();
    require_once "connect.php";
    $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
    if (isset($_POST['wyjdz'])) #ktos zdecydowal ze jednak nie chce sie rejestrowac i wcisnal przycisk powrotu
    {
        
        unset($_COOKIE['PASS']);
        unset($_SESSION['tekst']);
        unset($_SESSION['imydz']);
        unset($_SESSION['HTML']);
        header("location: przejscie.php");
    }
    if (isset($_POST['Register']))
    {
        $login =$_POST['username'];
        $haslo = $_POST['password'];
        $discord = $_POST['discordurl'];
        $sql = "SELECT * FROM uzytkownicy WHERE login='$login'";
        $rezultat = $polaczenie->query($sql);
        $taski = $login . "taski";
        $harmonogram = $login . "harmonogram";
        $poziomy = $login . "poziomy";
        $ile = $rezultat->num_rows;
        if ($ile==0&&$login!=""&&$haslo!="") #nawet chyba nie musze niczego tlumaczyc - jak nie ma danego loginu w bazie to jest dodawany nowy
        {
            $sql = "INSERT INTO `uzytkownicy` (`login`, `haslo`, `discord`, `dni_wolne`) VALUES ('$login', '$haslo', '$discord', '')";
            $polaczenie->query($sql);
            $sql = "CREATE TABLE `kamilek777`.`$poziomy` ( `ID` INT NOT NULL AUTO_INCREMENT , `nazwa` TEXT NOT NULL , `typ` TEXT NOT NULL , `exp` INT NOT NULL , `poziom` INT NOT NULL , `do_nastepnego` INT NOT NULL , `poczatek` DATE NOT NULL , `klasa` TEXT NOT NULL , PRIMARY KEY (`ID`)) ENGINE = InnoDB;";
            $polaczenie->query($sql);
            $sql = "CREATE TABLE `kamilek777`.`$harmonogram` ( `ID` INT NOT NULL AUTO_INCREMENT , `aktywnosc` TEXT NOT NULL , `waga` INT NOT NULL , `jakiedni` TEXT NOT NULL , `godziny` TEXT NOT NULL , `typ` TEXT NOT NULL , PRIMARY KEY (`ID`)) ENGINE = InnoDB; ";
            $polaczenie->query($sql);
            $sql = "CREATE TABLE `kamilek777`.`$taski` ( `ID` INT NOT NULL AUTO_INCREMENT , `dynID` INT NOT NULL , `nazwa` TEXT NOT NULL , `status` TEXT NOT NULL , `waga` INT NOT NULL , `data` DATE NOT NULL , `typ` TEXT NOT NULL , PRIMARY KEY (`ID`)) ENGINE = InnoDB;";
            $polaczenie->query($sql);
            $_COOKIE['PASS'] = $login;
            unset($_SESSION['tekst']);
            unset($_SESSION['imydz']);
            unset($_SESSION['HTML']);
            setcookie("PASS",$login);
            header("location:glowna");
        }
        else
        {
            $_SESSION['RegErr'] = "Użytkownik o podanym loginie już istnieje. Podaj inny login.";
            unset($_POST['Register']);
            header("location:rejestracja");
        }
    }
    else
    {
        $_SESSION['komunikat']="";
        if (isset($_SESSION['RegErr'])) #nwm czemu tak
        {
            $_SESSION['komunikat'] = $_SESSION['RegErr'];
        }
        unset($_SESSION['RegErr']);
        $_SESSION['tekst']="Podaj odpowiednie dane do formularza rejestracji.";
        $_SESSION['obraz'] = "img/rogal.png";
        $_SESSION['HTML']="<form method='post' action='rejestracja'><div class='calosc'><div class='formularz1'> <p>Podaj login (pod ten login zostaną podpięte bazy danych zawierajace wszystkie personalne informacje w Rogalu):</p> <input type='text' name='username'></div><div class='formularz1'> <p>Podaj haslo:</p> <input type='password' name='password'></div><div class='formularz1'><p>Podaj ID swojej konwersacji z Rogalem na Discordzie (jezeli nie chcesz powiadomień albo nie wiesz o co chodzi to pozostaw to pole puste):</p> <input name='discordurl' type='text'></div><input type='submit' name='Register' value='Zarejestruj się'></div></form>";
    }
	
?>

<!DOCTYPE html>
<html lang="pl">
	<head>
                <link rel="Shortcut icon" href="rogal.ico" />
		<meta charset="utf-8"/>
                <title>Rejestracja</title>
		<link id="styl" href="style.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />
	</head>
	<body><div style="color:black;position:fixed;top:0;width:300px;height:100vh; font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;z-index:100; background: rgb(255,255,255);background: linear-gradient(90deg, rgba(255,255,255,1) 0%, rgba(255,255,255,0.4918300083705357) 100%); border-right:4px dotted rgb(220, 220, 220);min-width:300px;display: grid; grid-template-rows: 1fr 1fr 4fr;grid-template-columns: 1fr;justify-content: center; align-items: center;"><div id="nakladka1" style="display:flex; justify-content: center; align-items: center;width:60%;height:100%;text-align:center;border-bottom:4px dotted rgb(255, 255, 255);font-size: large; margin:auto">To jest strona próbna Rogala
</div><div style="margin:auto;height:100%;display:flex; justify-content: center; align-items: center;"><a href="../indexWeb.html"><img id="nakladka" width="100px" height="100px" src="../powrot.png"></a></div><div style="margin:auto;width:220px;height:100%;display:flex; padding:0 40px; justify-content: center;">Rogal był moją pierwszą aplikacją webową a zarazem też pierwszym większym projektem programistycznym (takim na którym spędziłem dużo czasu).
<br><br>
Rozpoczęcie mojej przygody w programowaniem było bardzo silnie ugruntowane w mojej przyjaźni z Michałem, Maciejem a przede wszystkim Przemkiem (każdy z nich był uczniem technikum na kierunku technika informatyka/programisty)<br>
Byli oni silną insipracją dla mnie jeżeli chodzi o rozwijanie się w tym kierunku, ponieważ tworzyło to dodatkowe tematy do rozmów, a nie chciałem się przecież czuć gorszy w naszym ukochanym circlejerku.
<br><br>
Sama strona jest napisana bardzo prymitywnym kodem PHP i odłamkami JavaScriptu. Poprzez PHP strona zmienia zawartość w pliku indexu i tworzy wrażenie przechodzenia z jednej strony do drugiej. Oprócz tego z pomocą PHP i bazy danych w SQL zapisuje ona dane wprowadzone przez użytkownika i później wywołuje je jako listę tasków do wykonania i inne dodatkowe funkcje.
</div></div>
	<header>
        <div class="logo"><input onclick="window.location.reload();" type=submit name="strona1" value ="ROGAL"/></div>
    </header>

    <nav>
        <div class="top">
                <div style="height:73.8px;"></div>
        </div>
    </nav>
    <main>

        <div class="container">
            <div class='funkcja'>

                <?php echo "<form style='width:100%;' method='post' action='rejestracja'><div class='calosc' style='width:40%; margin-bottom: 20px;'><input name='wyjdz' type='submit' value='Wróć'></div></form>"; ?>

            </div> 
            <article><div class="tekst"><?php if (!isset ($_SESSION['tekst'])){$_SESSION['tekst']="ął";} echo $_SESSION['tekst']; ?></div></article>
            
            
            <?php echo $_SESSION['komunikat']; ?>
            <div class='funkcja'>


            <?php if (!isset ($_SESSION['HTML'])){$_SESSION['HTML']='';} echo $_SESSION['HTML'];?>
        
            </div>

            <div class='imydz'> <image src=<?php if (!isset ($_SESSION['obraz'])){$_SESSION['obraz']='img/rogal.png';} echo $_SESSION['obraz'];?>>
            
            </div>

        </div>


    </main>

	</body>
</html>