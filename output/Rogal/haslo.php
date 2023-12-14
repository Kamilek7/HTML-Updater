<?php
	session_start();
    require_once "connect.php";
    $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
    #komunikat ktory pojawia sie tylko wtedy kiedy jest rozny od poczatkowej wartosci
    $_SESSION['komunikat']="";
    if (isset($_POST['public']))
    {
        #sprawdza czy przypadkiem sie juz nie zalogowales
        setcookie("PASS", "public");
        unset($_SESSION['tekst']);
        unset($_SESSION['imydz']);
        unset($_SESSION['HTML']);
        header("location:glowna");
    }
	if (isset($_POST['pass'])){
        if ($_POST['pass'] == "")
        {
            $_SESSION['komunikat']="<span style='color: red'><p>Podaj poprawne hasło</p></span>";
        }
        $sql = "SELECT * FROM uzytkownicy";
        $rezultat = $polaczenie->query($sql);
        $ILE = $rezultat->num_rows;
        #tutaj ogolem jest problem z SQL ze po usunieciu danych uzytkownika mamy "lukę" w inkrementacji ID, i moze byc mniej uzytkownikow niz wynosi maksymalne ID
        $NICKI = array();
        $HASLA = array();
        $jest = "";
        $j = 0;
        $x = 1;
        while ($j<$ILE)
        {
            #najpierw zapisujemy dane do arraya
            $sql1 = "SELECT * FROM uzytkownicy WHERE ID='$x'";
            $rezultat = $polaczenie->query($sql1);
            if ($rezultat->num_rows!=0)
            {
                $wiersz = $rezultat->fetch_assoc();
                $NICKI[] = $wiersz['login'];
                $HASLA[] = $wiersz['haslo'];
                $j++;
            }
            $x++;
        }
        for ($i=0;$i<$ILE;$i++)
        {
            #potem przez wszystko przechodzimy bez problemu po arrayu
            if ($_POST['pass'] == $HASLA[$i])
            {
                #to jest wazne, cookie ktory trwa bardzo dlugo
                setcookie("PASS", $NICKI[$i], time() + 16070400);
                $jest = "ok";
                unset($_SESSION['tekst']);
                unset($_SESSION['imydz']);
                unset($_SESSION['HTML']);
                header("location:glowna");
            }
        }
        if ($jest!="ok")
        {
            $_SESSION['komunikat']="<span style='color: red'><p>Podaj poprawne hasło</p></span>";
        }

}
#tutaj konczy sie caly kod i zaczyna sie html
?>
<!-- tutaj wiekszosc wyglada tak jak w index, tylko z taka roznica ze nie ma przyciskow i jest z gory narzucona "funkcja" od hasla -->
<!DOCTYPE html>
<html lang="pl">
	<head>
        <link rel="Shortcut icon" href="rogal.ico" />
		<meta charset="utf-8"/>
        <title>Logowanie</title>
		<link id="styl" href="style.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />
	</head>
	<body><div style="color:black;position:fixed;top:0;width:300px;height:100vh; font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;z-index:100; background: rgb(255,255,255);background: linear-gradient(90deg, rgba(255,255,255,1) 0%, rgba(255,255,255,0.4918300083705357) 100%); border-right:4px dotted rgb(220, 220, 220);min-width:300px;display: grid; grid-template-rows: 1fr 1fr 4fr;grid-template-columns: 1fr;justify-content: center; align-items: center;"><div id="nakladka1" style="display:flex; justify-content: center; align-items: center;width:60%;height:100%;text-align:center;border-bottom:4px dotted rgb(255, 255, 255);font-size: large; margin:auto">To jest strona próbna Rogala
</div><div style="margin:auto;height:100%;display:flex; justify-content: center; align-items: center;"><a href="../indexWeb.html"><img id="nakladka" width="100px" height="100px" src="../powrot.png"></a></div><div style="margin:auto;width:220px;height:100%;display:flex; padding:0 40px; justify-content: center;">Rogal był moją pierwszą aplikacją webową a zarazem też pierwszym większym projektem programistycznym (takim na którym spędziłem dużo czasu).
<br><br>
Rozpoczęcie mojej przygody w programowaniem było bardzo silnie ugruntowane w mojej przyjaźni z Michałem, Maciejem a przede wszystkim Przemkiem (każdy z nich był uczniem technikum na kierunku technika informatyka/programisty)<br>
Byli oni silną insipracją dla mnie jeżeli chodzi o rozwijanie się w tym kierunku, ponieważ tworzyło to dodatkowe tematy do rozmów, a nie chciałem się przecież czuć gorszy w naszym ukochanym circlejerku.
<br><br>
Sama strona jest napisana bardzo prymitywnym kodem PHP i odłamkami JavaScriptu. Poprzez PHP strona zmienia zawartość w pliku indexu i tworzy wrażenie przechodzenia z jednej strony do drugiej. Oprócz tego z pomocą PHP i bazy danych w SQL zapisuje ona dane wprowadzone przez użytkownika i później wywołuje je jako listę tasków do wykonania i inne dodatkowe funkcje.
</div></div>        <header>
            <div class="logo"><input onclick="window.location.reload();" type=submit name="strona1" value ="ROGAL"/></div>
        </header>
        <nav>
            <div class="top">
                    <div style="height:73.8px;"></div>
            </div>
        </nav>
    <main>
        <div class="container">
            <article><div class="tekst"><?php echo $_SESSION['tekst']; ?></div></article>
            <?php echo $_SESSION['komunikat']; ?>
            <div class='funkcja'>
                <?php if (!isset ($_SESSION['HTML'])){$_SESSION['HTML']='';} echo $_SESSION['HTML'];?>
            </div>
            <div class='imydz'> <image src=<?php if (!isset ($_SESSION['obraz'])){$_SESSION['obraz']='img/rogal.png';} echo $_SESSION['obraz'];?>>
            </div>
        </div>
    </main>
	</body>
</html