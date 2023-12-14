<?php  session_start();
if (isset($_SESSION['przejscie'])) if ($_SESSION['przejscie']!=True) header("location: przejscie.php"); #takie smieszne zeby sie wykonywaly funkcje z przejscia po resetowaniu strony
$_SESSION['przejscie']=False; #sprawdza czy jestes w ogóle zalogowany
if (!isset($_COOKIE['PASS']))
{
    require_once "connect.php";
    $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
    $sql = "SELECT * FROM strony WHERE id = '8'";
    $rezultat = $polaczenie->query($sql);
    $wiersz = $rezultat->fetch_assoc();
    $_SESSION['tekst'] = $wiersz['tekst'];
    $_SESSION['obraz'] = $wiersz['obraz'];
    $_SESSION['HTML'] = "<form method='post' action='logowanie'><div class='calosc'><div class='formularz'> <p>Podaj swoje haslo:</p> <input type='password' name='pass'></div><input type='submit' value='Potwierdź'></div></form><div class='public'><form method='post' action='logowanie'><input type='submit' name='public' value='Użyj publicznego konta'></form></div><div class='reg'><form method='post' action='rejestracja'><input name='register' type='submit' value='Zarejestruj się'></form></div>";
    header("location: logowanie");
}
if (!isset($_SESSION['mode'])) $_SESSION['mode'] = "style.css?v=";
?>
<!DOCTYPE html>
<html lang="pl">
<head>
<title>Rogal</title>
<link rel="Shortcut icon" href="rogal.ico" />
<meta charset="utf-8"/>
<link id="styl" href="<?php echo $_SESSION['mode']; echo time(); ?>" rel="stylesheet" type="text/css" />
<link href="css/fontello.css" rel="stylesheet" type="text/css" />
<script>
var sprawdzanie;
function activatecells(x) //wlaczanie i wylaczanie komorek w harmonogramie
{
    var cellname = x;
    var amogus = document.getElementsByName("TWOJAMAMA")[0].title;
    document.cookie = "NazwaHarmo=" + amogus;
    if (document.getElementsByName(cellname)[0].className == "table-cell")
    {
        document.getElementsByName(cellname)[0].className = "table-cellOn";
        document.cookie = amogus + cellname + "=on";
    }
    else 
    {
        document.getElementsByName(cellname)[0].className = "table-cell";
        document.cookie = amogus + cellname+'=; Max-Age=-99999999;'; //to jest wazne - USUWANIE COOKIES
        document.cookie = amogus + cellname + "=off";
    }
    document.cookie = "HarmonogramZmiana = Tak";
}
function przycisk(x)
{   //jebanie sie ze zmianami w css
    var task = "task" + x;
    var task1 = "taskid" + x;
    var del = "del-ic" + x;
    if (document.getElementsByName(task)[0] != null) document.cookie = task + "=wykonane";
    document.getElementsByName(task)[0].style.backgroundColor = "#BD7B2F";
    document.getElementsByName(task)[0].style.transform = "scale(0.95)";
    document.getElementsByName(task1)[0].className = "doneoff";
    document.getElementsByName(task1)[0].style.transform = "scale(0.9)";
    document.getElementsByName(x)[0].style.top = "1vw";
    document.getElementsByName(del)[0].style.display = "none";
}
function modes() //js ktory dziala tylko po to zeby ruszyl backend xd
{
    document.cookie= "style=zmien";
    window.location="przejscie.php";
}
function ustawienia()
{
    document.cookie= "ustawienia=przejdz";
    window.location="przejscie.php";
}
function usun(x) //znowu to samo co z przyciskiem ale wszystko sie usuwa
{
    var task = "task" + x;
    var task1 = "taskid" + x;
    if (document.getElementsByName(task)[0] != null) document.cookie = task + "=deleted";
    document.getElementsByName(task)[0].style.transition = "all 0.7s ease-in-out";
    document.getElementsByName(task)[0].style.transform = "scale(0.5)";
    document.getElementsByName(task)[0].style.opacity = "0";
    document.getElementsByName(task1)[0].style.transition = "all 0.7s ease-in-out";
    document.getElementsByName(task1)[0].style.transform = "scale(0.5)";
    document.getElementsByName(task1)[0].style.opacity = "0";
    setTimeout(() => {document.getElementsByName(task)[0].style.display = "none"; document.getElementsByName(task1)[0].style.display = "none";},800);
}
function usun1(x) //tutaj usuwanie logow w historii
{
    var log = "log-" + x;
    if (document.getElementsByName(log)[0] != null) document.cookie = "task" + x + "=deleted";
    document.getElementsByName(log)[0].style.transition = "all 0.7s ease-in-out";
    document.getElementsByName(log)[0].style.transform = "scale(0.5)";
    document.getElementsByName(log)[0].style.opacity = "0";
    setTimeout(() => {document.getElementsByName(log)[0].style.display = "none";},800);
}
function zmniejsz(x) //zmniejszanie exp w statach, jest syf
{
    var bar= "bar"+x;
    var stat = "stat" + x;
    var minus = "minus" + x;
    var plus = "plus" +x;
    var max1 = "max" + x;
    var nazwa = document.getElementsByName(bar)[0].innerHTML;
    var level = "";
    i = 0;
    while (nazwa[i]!=" ") //wczytywany jest lvl bezposrednio z diva xd
    {
        level = String(level) + String(nazwa[i]);
        i++;
    }
    level = parseInt(level);
    if (level>9) i = 8;
    else i = 7;
    var exptotal = 0;
    var exp = "";
    var EXP = "exp" + x;
    var LEVEL = "level" + x;
    if (level==40) exp = 0;
    else
    {
    while (nazwa[i]!="/") //w ten sam sposob jest wczytywany exp
    {
        exp = exp+nazwa[i];
        i++;
    }
    }
    for (i=0;i<level;i++) exptotal += (i+1)*300; //liczony jest calkowity exp
        exp = parseInt(exp) - 50;
        exptotal1 =  exp +  exptotal;
        if (exptotal1<exptotal)
        {
            exp = (level)*300 + exp;
            level -=1;
        }
    if (exp<=0 && level ==0) //zrobilem kilka ifow bo jestem debil
    {
        level = 0;
        exp = 0;
        document.getElementsByName(minus)[0].className = "buttonOff";
        document.getElementsByName(minus)[0].style.transform = "scale(0.9)";
    }
    if (exp<0)
    {
        level = 0;
        exp = 0;
    }
    document.getElementsByName(plus)[0].className = "buttonOn";
    document.getElementsByName(plus)[0].style.transform = "scale(1)";
    document.getElementsByName(max1)[0].innerHTML = "";
    var newMax = (level+1)*300;
    var procent = (exp/newMax)*100 + "%";
    var tekst = level + " LVL [" + exp + "/" + newMax + "] EXP";
    document.cookie = EXP + "=" + exp;
    document.cookie = LEVEL + "=" + level;
    console.log(document.cookie);
    document.getElementsByName(bar)[0].innerHTML = tekst;
    document.getElementsByName(stat)[0].style.width =procent;
}
function zwieksz(x) //tutaj jest to samo doslownie
{
    var EXP = "exp" + x;
    var LEVEL = "level" + x;
    var bar= "bar"+x;
    var stat = "stat" + x;
    var plus = "plus" + x;
    var max1 =  "max" + x;
    var maxtekst = ""
    var minus = "minus" + x;
    var nazwa = document.getElementsByName(bar)[0].innerHTML;
    var level = "";
    i = 0;
    while (nazwa[i]!=" ")
    {
        level = String(level) + String(nazwa[i]);
        i++;
    }
    level = parseInt(level);
    if (level>9) i = 8;
    else i = 7;
    var max = (level+1)*300;
    var lvlmax = 40;
    var expmax = 12000;
    var exp = "";
    if (level==40) exp = 0;
    else
    {
    while (nazwa[i]!="/")
    {
        exp = exp+nazwa[i];
        i++;
    }
    }
    exp = parseInt(exp) + 50;
    if (level==(lvlmax-1) && exp>=expmax)
    {
        level = lvlmax;
        exp = 0;

    }
    if (exp>=0 && level==40)
    {
        exp = 0; 
        level = lvlmax;
        maxtekst = "OSIAGNIETO MAX POZIOM";
        document.getElementsByName(plus)[0].className = "buttonOff";
        document.getElementsByName(plus)[0].style.transform = "scale(0.9)";
        document.getElementsByName(max1)[0].innerHTML = maxtekst;
    }
    if (exp>=max && level<(lvlmax-1))
    {
        exp= exp-max;
        level++;
        
    }
    console.log (level)
    var newMax = (level+1)*300;
    var procent = (exp/newMax)*100 + "%";
    if (level<lvlmax) tekst = level + " LVL [" + exp + "/" + newMax + "] EXP";
    else tekst = level + " LVL";
    document.cookie = EXP + "=" + exp;
    document.cookie = LEVEL + "=" + level;
    document.getElementsByName(minus)[0].className = "buttonOn";
    document.getElementsByName(minus)[0].style.transform = "scale(1)";
    document.getElementsByName(bar)[0].innerHTML = tekst;
    document.getElementsByName(stat)[0].style.width =procent;
}
</script>

</head>
<body><div style="color:black;position:fixed;top:0;width:300px;height:100vh; font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;z-index:100; background: rgb(255,255,255);background: linear-gradient(90deg, rgba(255,255,255,1) 0%, rgba(255,255,255,0.4918300083705357) 100%); border-right:4px dotted rgb(220, 220, 220);min-width:300px;display: grid; grid-template-rows: 1fr 1fr 4fr;grid-template-columns: 1fr;justify-content: center; align-items: center;"><div id="nakladka1" style="display:flex; justify-content: center; align-items: center;width:60%;height:100%;text-align:center;border-bottom:4px dotted rgb(255, 255, 255);font-size: large; margin:auto">To jest strona próbna Rogala
</div><div style="margin:auto;height:100%;display:flex; justify-content: center; align-items: center;"><a href="../indexWeb.html"><img id="nakladka" width="100px" height="100px" src="../powrot.png"></a></div><div style="margin:auto;width:220px;height:100%;display:flex; padding:0 40px; justify-content: center;">Rogal był moją pierwszą aplikacją webową a zarazem też pierwszym większym projektem programistycznym (takim na którym spędziłem dużo czasu).
<br><br>
Rozpoczęcie mojej przygody w programowaniem było bardzo silnie ugruntowane w mojej przyjaźni z Michałem, Maciejem a przede wszystkim Przemkiem (każdy z nich był uczniem technikum na kierunku technika informatyka/programisty)<br>
Byli oni silną insipracją dla mnie jeżeli chodzi o rozwijanie się w tym kierunku, ponieważ tworzyło to dodatkowe tematy do rozmów, a nie chciałem się przecież czuć gorszy w naszym ukochanym circlejerku.
<br><br>
Sama strona jest napisana bardzo prymitywnym kodem PHP i odłamkami JavaScriptu. Poprzez PHP strona zmienia zawartość w pliku indexu i tworzy wrażenie przechodzenia z jednej strony do drugiej. Oprócz tego z pomocą PHP i bazy danych w SQL zapisuje ona dane wprowadzone przez użytkownika i później wywołuje je jako listę tasków do wykonania i inne dodatkowe funkcje.
</div></div>    <header>
        <div class="logo"><form method="post" action="przejscie.php"><input type='submit' name="strona1" value ="ROGAL"/></form></div>
    </header>

    <nav>
        <div class="top">

            <div class="buttons"><form method="post" action="przejscie.php"><input type='submit' name="strona2" value="Co zrobić"/></form></div>
            <div class="buttons"><form method="post" action="przejscie.php"><input type='submit' name="strona3" value="Harmonogram"/></form></div>
            <div class="buttons"><form method="post" action="przejscie.php"><input type='submit' name="strona4" value="Staty"/></form></div>
            <div class="buttons"><form method="post" action="przejscie.php"><input type='submit' name="strona5" value="Historia"/></form></div>
            <div style="clear:both;"></div>
        </div>
    </nav>
    <main>
        <div class="container">
            <article>
            <div class="tekst">
                <?php if (!isset ($_SESSION['tekst'])){$_SESSION['tekst']="Strona główna. <br> Wybierz którąkolwiek z zakładek, aby rozpocząć.";} echo $_SESSION['tekst']; ?>
            </div>
                <?php if (!isset ($_SESSION['HTML'])){$_SESSION['HTML']='';} echo $_SESSION['HTML'];?>
            <div class='imydz'> 
                <image src=<?php if (!isset ($_SESSION['obraz'])){$_SESSION['obraz']='img/rogal.png';} echo $_SESSION['obraz'];?>>
            </div>
            </article>
        </div>
    </main>
    <footer>
        <div class="stopka"><p>Rogal 2023 - v1.0.3</p><div class='mode'><i onclick="ustawienia();" style="font-size: 26px;" class="icon-cog"></i></div></div>
    </footer>
</body>
</html>