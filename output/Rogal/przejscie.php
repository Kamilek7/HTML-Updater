<?php
session_start();
$dzisiaj = date("Y-m-d");
require_once "connect.php";
$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
$_SESSION['przejscie'] = True;
function tekst_i_obraz($wiersz) #zrobilem te funkcje na szybko bo sie bardzo czesto powtarzaly, zyskalem na to ok 400 wolnych linijek tbh
{
    $_SESSION['tekst'] = $wiersz['tekst'];
    $_SESSION['obraz'] = $wiersz['obraz'];
    $_SESSION['funkcja'] = $wiersz['funkcja'];
}
function seql($sql, $co_wyslac)
{
    global $polaczenie;
    if(!strpos($sql, "<")){
    $rezultat = $polaczenie->query($sql);
    if ($co_wyslac=="fetch")
    {
        $wiersz = $rezultat->fetch_assoc();
        return $wiersz;
    }
    else if ($co_wyslac=="ile")
    {
        $ile = $rezultat->num_rows;
        return $ile;
    }}
}
function kolory($x) #do harmonogramu
{
    $HSV = array();
    $stopnie = 360/$x;
    for ($i; $i<$x; $i++)
    {
        $temp = "hsl(";
        $deg = $stopnie*$i;
        $temp.= strval($deg)." 75% 80%)";
        $HSV[] = $temp;
    }
    return $HSV;
}
$_SESSION['komunikat'] = "";
if (!isset($_COOKIE['PASS'])) #sprawdza czy jestes zalogowany
{
    $wiersz = seql("SELECT * FROM strony WHERE id='8'", "fetch");
    tekst_i_obraz($wiersz);
    $_SESSION['HTML'] = "<form method='post' action='logowanie'><div class='calosc'><div class='formularz'> <p>Podaj swoje haslo:</p> <input type='password' name='pass'></div><input type='submit' value='Potwierdź'></div></form><div class='public'><form method='post' action='logowanie'><input type='submit' name='public' value='Użyj publicznego konta'></form></div><div class='reg'><form method='post' action='rejestracja'><input name='register' type='submit' value='Zarejestruj się'></form></div>";
    header("location: logowanie");
}
$POZIOMY = $_COOKIE['PASS'] . "poziomy"; #ustawiane sa nazwy dla tabel wybranego uzytkownika
$TASKI = $_COOKIE['PASS'] . "taski";
$HARMONOGRAM = $_COOKIE['PASS'] . "harmonogram";
if (isset($_POST['Logout'])) #wylogowanie
{
    $_COOKIE['PASS'] = "";
    setcookie('PASS', null, -1, '/');  #usuwanie cookie
    header('location: przejscie.php');
}
if (isset($_POST['dniwolne'])) #to jest tylko do ustawien, zmiana dzialania harmonogramu
{
    $LOOOGIN = $_COOKIE['PASS'];
    $wiersz = seql("SELECT * FROM uzytkownicy WHERE login = '$LOOOGIN'", "fetch");
    if ($wiersz['dni_wolne']=="") seql("UPDATE uzytkownicy SET dni_wolne='X' WHERE login = '$LOOOGIN'", False);
    else seql("UPDATE uzytkownicy SET dni_wolne='' WHERE login = '$LOOOGIN'", False);
}
if (isset($_POST['Usun'])) #usuniecie konta
{
    if ($_COOKIE['PASS'] == 'public') #xd
    {
        $_SESSION['komunikat'] = "<span style='color:red;'>Nie masz uprawnień do usunięcia tego profilu.</span>";
        $_COOKIE['ustawienia'] = "Przejdz";
        setcookie('ustawienia', "Przejdz");
    }
    else #sa usuwane tabele itd
    {
        seql("DROP TABLE `kamilek777`.`".$POZIOMY."`", False);
        seql("DROP TABLE `kamilek777`.`".$HARMONOGRAM."`", False);
        seql("DROP TABLE `kamilek777`.`".$TASKI."`", False);
        seql("DELETE FROM uzytkownicy WHERE login='".$_COOKIE['PASS']."'", False);
        $_COOKIE['PASS'] = "";
        setcookie('PASS', null, -1, '/'); 
        header('location: przejscie.php');
    }
}
if (isset($_POST['settingssave'])) #jak na razie tylko do zmiany dc
{
    if ($_COOKIE['PASS'] = 'public')
    {
        $_SESSION['komunikat'] = "<span style='color:red;'>Nie masz uprawnień do dokonania żadnych zmian w tym profilu.</span>";
        $_COOKIE['ustawienia'] = "Przejdz";
        setcookie('ustawienia', "Przejdz");
    }
    else
    {
        $discorrrr = $_POST['discord'];
        if ($discorrrr != "")
        {
            if ($discorrrr = "X" || $discorrrr = "x") $discorrrr="";
            seql("UPDATE uzytkownicy SET discord='$discorrrr' WHERE login = '".$_SESSION['PASS']."'", False);
        }
    }
}
if (isset($_COOKIE['HarmonogramZmiana'])) #zmienil sie harmonogram? spoko
{
    if($_COOKIE['HarmonogramZmiana']=="Tak")
    {
        $nazwa = $_COOKIE['NazwaHarmo']; #skoro sie zmienil to musial byc jakis cookie
        $dnioff = array();
        $dnion = array();
        for ($j=1; $j<=9; $j++)
        {
            for ($i=1; $i<=14; $i++)
            {
                $kuki = $nazwa . strval($j) . strval($i); #sa sprawdzane doslownie wszystie kombinacje jakie mogly powstac xd
                if (isset($_COOKIE[$kuki]))
                {
                    if ($_COOKIE[$kuki]=="on") #włamczanie
                    {
                    $temp = $j . chr(intval($i+96));
                    $dnion[]=$temp; #np dla cookie nazwa311 powstaje temp 3k itd
                    setcookie($kuki, "");
                    $_COOKIE[$kuki]=="";
                    }
                    else if ($_COOKIE[$kuki]=="off") #wyłamczanie
                    {
                        $temp = $j . chr(intval($i+96));
                        $dnioff[]=$temp;
                        setcookie($kuki, "");
                        $_COOKIE[$kuki]=="";
                    }
                }
            }
        }
        setcookie("HarmonogramZmiana", "");
        if($dnion!="" || $dnioff!="") #jezeli cos w ogole sie zmienilo
        {   
            $temp = "";
            $wiersz = seql("SELECT * FROM $HARMONOGRAM WHERE aktywnosc='$nazwa'", "fetch");
            $calosc = array();
            $amogus = $wiersz['godziny'] . " ,";
            $jakiedni = $wiersz['jakiedni'];
            $j = 0;
            while ($j<strlen($jakiedni))
            {
            for ($i=0; $i<strlen($amogus);$i++)
            {
                if ($amogus[$i]!=","&&$amogus[$i]!=" ") #rozlozony zostaje zapis np 346 abc, def, ghi na 3a 3b 3c itd oddzielno w tablicach
                {
                    $ztr= " " . $jakiedni[$j] . $amogus[$i] . " "; #te spacje dalem chyba tylko dla czytelnosci ale je zostawiam
                    $calosc[]  = $ztr;
                }
                else
                {
                    $i++; #pojawil sie przecinek? dwa razy i++ i raz j++
                    $j++;
                }
            }
            }
            for ($i=0;$i<sizeof($dnioff);$i++) #teraz info z sql i z tego co wczesniej wyszlo w kodzie jest w tym samym formacie
            {
                for ($j=0;$j<sizeof($calosc);$j++)
                {
                    $temp1 = trim($calosc[$j], " "); #;-;
                    $temp = trim($dnioff[$i], " ");
                    if ($temp1 == $temp) unset($calosc[$j]); #jezeli obie wartosci sie zgadzaja to z calosci jest usuwane to gowno
                }
            }
            for ($i=0;$i<sizeof($dnion); $i++)
            {
                $calosc[] = $dnion[$i]; #do tabeli jest dolaczana calosc z dnion
            }
            $kod = array( 1 => "", 2=> "", 3=> "", 4=> "", 5=> "", 6=> "", 7=> ""); 
            for ($i=0; $i<(sizeof($calosc)+sizeof($dnioff)); $i++) #FUN FACT, JAK USUWA SIE DANE Z TABELI TO JEJ INDEKSY SIE NIE ODNAWIAJA :DDDD!!!
            {
                $temp = trim($calosc[$i]," ");
                $numer = $temp[0];
                if (str_contains($kod[$numer],$numer)) #łooo panie, a kto tu panu tak spierdolil
                {
                    if (!str_contains($kod[$numer],$temp[1])) $kod[$numer].= $temp[1];
                }
                else    #jezeli nie ma danego numeru w tablicy o tym samym numerze to dodawany jest ten numer a za nim dodawane sa litery alfabetu odpowiadajace za godziny
                {
                    $kod[$numer].= $numer;
                    if (!str_contains($kod[$numer],$temp[1])) $kod[$numer].= $temp[1];
                }
            }
            $jakiedni1 = "";
            $godziny1 = "";
            for ($i=0;$i<=sizeof($kod);$i++)
            {
                $temp = $kod[$i];
                $temp1 = array(); #wtf xddd
                if ($temp!="")
                {
                    $numer = $temp[0];
                    $jakiedni1 .= $numer; #mamy juz numerki, juhu
                    $ao = trim($temp,$numer);
                    for ($j=0;$j<strlen($ao);$j++)
                    {
                        $temp1[] = $ao[$j];
                    }
                    $ao="";
                    sort($temp1);
                    for ($j=0;$j<sizeof($temp1);$j++)
                    {
                        $ao.=$temp1[$j];
                    }
                    $godziny1 .= $ao . ", "; #dont open, dead inside
                }
            }
            seql("UPDATE $HARMONOGRAM SET jakiedni='$jakiedni1', godziny='$godziny1' WHERE aktywnosc='$nazwa'", False); #koniec tego gowna
    }
}
}
if (isset($_COOKIE['ustawienia']))
{
    $_SESSION['funkcja'] = 9;
    unset($_COOKIE['ustawienia']); 
    setcookie('ustawienia', null, -1, '/'); 
}
if (isset ($_POST['WYBOR']))
{
    $_SESSION['Harmoid']= $_POST['WYBOR'];
    $_SESSION['funkcja'] = 5;
}
if (!isset($_SESSION['dodajnowetask'])) $_SESSION['dodajnowetask']="";
if (!isset($_SESSION['dodajnoweharmo'])) $_SESSION['dodajnoweharmo']="";
if (!isset($_SESSION['dodajnowestaty'])) $_SESSION['dodajnowestaty']="";
if (isset($_COOKIE['style']))
{
    if ($_COOKIE['style']=="zmien")
        if ($_SESSION['mode']=="style.css?v=") $_SESSION['mode']="style1.css?v=";
        else if ($_SESSION['mode']=="style1.css?v=") $_SESSION['mode']="style.css?v=";
        else $_SESSION['mode']="style.css?v=";
        setcookie("style", "");
}
for ($i=1;$i<=11;$i++)
{
    $strona = "strona" . $i;
    if (isset($_POST[$strona]))
{
    $wiersz = seql("SELECT * FROM strony WHERE id = '$i'", "fetch");
    tekst_i_obraz($wiersz);
}
}
if ($_SESSION['dodajnowetask']=="Amogus")
{
    $nazwa = $_POST['nazwa'];
    $typ = $_POST['typ'];
    $data = $_POST['data'];
    $waga = $_POST['waga'];
    seql("INSERT INTO `$TASKI` (`dynID`, `nazwa`, `status`, `waga`, `data`, `typ`) VALUES ('0', '$nazwa', 'niedokonane', '$waga', '$data', '$typ')",False);
    $_SESSION['dodajnowetask']="";
}
if ($_SESSION['dodajnoweharmo']=="Amogus")
{
    $wybor = $_POST['nazwa1'];
    $typ = $_POST['typ1'];
    $waga = $_POST['waga1'];
    $wybortemp = "";
    for ($j=0;$j<strlen($wybor);$j++)
    {
        if($wybor[$j]==" ")
        {
            $wybortemp.="0";
        }
        else
        {
            $wybortemp.=$wybor[$j];
        }
    }
    seql("INSERT INTO `$HARMONOGRAM` (`aktywnosc`, `waga`, `jakiedni`, `godziny`, `typ`) VALUES ('$wybortemp', '$waga', '', '', '$typ')", False);
    $_SESSION['dodajnoweharmo']="";
}
if ($_SESSION['dodajnowestaty'] = "Amogus")
{
    $nazwa = $_POST['nazwa'];
    $typ = $_POST['typ'];
    $poziom = $_POST['level'];
    $klasa = $_POST['klasa'];
    $up = ($poziom+1)*300;
    seql("INSERT INTO `$POZIOMY` (`nazwa`, `typ`, `exp`, `poziom`, `do_nastepnego`, `poczatek`, `klasa`) VALUES ('$nazwa', '$typ', '0', '$poziom', '$up', '$dzisiaj', '$klasa')", False);
    $_SESSION['dodajnowestaty'] ="";
}
if (isset($_SESSION['funkcja']))
{
    $_SESSION['HTML'] = "";
    $ile = seql("SELECT * FROM $TASKI", "ile");
    $dokonane = array();
    $niedokonane = array();
    $poczatek = seql("SELECT MIN(ID) as poczatek FROM $TASKI", "fetch");
    $x = 0;
    $j = $poczatek['poczatek'];
    while ($x<$ile)
    {
        if (seql("SELECT * FROM $TASKI WHERE ID='$j'","ile")==1)
        {
            $taskCookie = "task".$j;
            if ($_COOKIE[$taskCookie]=="deleted")
            {
                seql("DELETE FROM ".$TASKI." WHERE ID='$j'", False);
                setcookie($taskCookie, "normal");
            }
            else
            {
                $wiersz = seql("SELECT * FROM $TASKI WHERE ID='$j'","fetch");
                $a = $wiersz['ID'];
                $log = "log-" . $wiersz['ID'];
                if ($wiersz['status'] =="niedokonane") $niedokonane[] = "<div class='log' name='$log'><ul style='position: relative;left: 1.2vw;'><li>".$j."</li><li>".$wiersz['nazwa']."</li><li>Niedokonane</li><li>".$wiersz['waga']."</li><li>".$wiersz['data']."</li><li>".$wiersz['typ']."</li></ul><div class='del-ic1'".$wiersz['ID']."' onclick='usun1(".$a.")'>x</div></div>";
                else $dokonane[] = "<div class='log' name='$log'><ul style='position: relative;left: 1.2vw;'><li>".$j."</li><li>".$wiersz['nazwa']."</li><li>Dokonane</li><li>".$wiersz['waga']."</li><li>".$wiersz['data']."</li><li>".$wiersz['typ']."</li></ul><div class='del-ic1'".$wiersz['ID']."' onclick='usun1(".$a.")'>x</div></div>";
            }
            $x++;
        }
        $j++;
    }
    $ile = seql("SELECT * FROM $TASKI WHERE status='niedokonane'","ile");
    $taski = array();
    $iletaskow = 0;
    $ilee = 0;
    $i = $poczatek['poczatek'];
    while ($iletaskow<$ile)
    {
        $taskCookie = "task".$i;
        if (seql("SELECT * FROM $TASKI WHERE status='niedokonane' AND ID='$i'", "ile")==1)
        {
            $iletaskow++;
            $wiersz = seql("SELECT * FROM $TASKI WHERE status='niedokonane' AND ID='$i'","fetch");
            if ($_COOKIE[$taskCookie]=="wykonane")
            {
                $typ = $wiersz['typ'];
                $data = $wiersz['data'];
                $waga = $wiersz['waga'];
                $wiersz = seql("SELECT * FROM $POZIOMY WHERE typ='$typ'", "fetch");
                $lvl = $wiersz['poziom'];
                $e = $wiersz['exp'];
                if ($data>=$dzisiaj) $e += $waga*50;
                else $e += $waga*20;
                if ($e >= (($lvl+1)*300))
                {
                    $e -= (($lvl+1)*300);
                    $lvl++;
                }
                if ($lvl >=40)
                {
                    $lvl = 40;
                    $e = 0;
                }
                $max11 = ($lvl+1)*300; 
                seql("UPDATE $TASKI SET status='dokonane' WHERE ID='$i'", False);
                seql("UPDATE $POZIOMY SET exp='$e', poziom='$lvl', do_nastepnego='$max11' WHERE typ='$typ'", False);
                setcookie($taskCookie, "normal");
            }
            else
            {
                $taski[] = array('ID' => $wiersz['ID'], 'typ' => $wiersz['typ'], 'nazwa' => $wiersz['nazwa'], 'data' => $wiersz['data'], 'waga' => $wiersz['waga']);
                $ilee++;
            }
        }
        $i++;
    }
    $name = "taski_sort";
    $suffix = array("ID","typ","nazwa","data","waga");
    for ($i=0;$i<5; $i++)
        {
            $temp = $name . $suffix[$i];
            if (isset ($_POST[$temp])) $_SESSION['xa'] = $i;
        }
    if (!isset($_SESSION['xa'])) $_SESSION['xa'] = 0;
    $sort = $suffix[$_SESSION['xa']];
    if($sort!="waga") array_multisort( array_column($taski, $sort ), $taski );
    else array_multisort( array_column($taski, $sort ), SORT_DESC, $taski );
    if ($_SESSION['funkcja'] == 2)
    {
        $_SESSION['HTML'].="<div class='dodaj'><form method='post' action='przejscie.php'><input type=submit name='strona6' value='Dodaj nowego taska'/></form></div><div class='bar2'><div class='sort'><form method='post' action='przejscie.php'><input type=submit name='taski_sortID' value='ID'/></form></div><div class='sort'><form method='post' action='przejscie.php'><input type=submit name='taski_sorttyp' value='Typ'/></form></div><div class='sort'><form method='post' action='przejscie.php'><input type=submit name='taski_sortnazwa' value='Nazwa'/></form></div><div class='sort'><form method='post' action='przejscie.php'><input type=submit name='taski_sortdata' value='Data'/></form></div><div class='sort'><form method='post' action='przejscie.php'><input type=submit name='taski_sortwaga' value='Waga'/></form></div></div>";
        for ($k=1;$k<=$ilee;$k++)
        {   
            $wiersz = $taski[$k-1];
            $a = $wiersz['ID'];
            if ($wiersz['data']>=$dzisiaj) $_SESSION['HTML'] .= "<div class='taskbar'style='border: 5px dashed rgba(255, 255, 255,".strval(intval($wiersz['waga'])/10).")'><div class='task' name=task".$wiersz['ID']."><div class='del-ic' name='del-ic".$wiersz['ID']."' onclick='usun(".$a.")'>x</div><div name='".$wiersz['ID']."' style='position: relative; top: -1.6vw;'>".$wiersz['nazwa']."<br><span style='color: darkgray; font-size: 1.1vw;'>(".$wiersz['data'].")</span></div></div><div class='done' name=taskid".$wiersz['ID']."><input type='submit'  onclick='przycisk"."(".$wiersz['ID'].")".";' value='Wykonane'/></div></div>";
            else $_SESSION['HTML'] .= "<div class='taskbar'style='border: 5px dashed rgba(255, 80, 80,".strval(intval($wiersz['waga'])/10).")'><div class='task' name=task".$wiersz['ID']."><div class='del-ic' name='del-ic".$wiersz['ID']."' onclick='usun(".$a.")'>x</div><div name='".$wiersz['ID']."' style='position: relative; top: -1.6vw;'>".$wiersz['nazwa']."<br><span style='color: darkgray; font-size: 1.1vw;'>(".$wiersz['data'].")</span></div></div><div class='done' name=taskid".$wiersz['ID']."><input type='submit'  onclick='przycisk"."(".$wiersz['ID'].")".";' value='Wykonane'/></div></div>";
        }
    }
    else if ($_SESSION['funkcja'] == 5)
    {
        if (!isset ($_SESSION['Harmoid'])) $_SESSION['Harmoid'] = 'X';
        $id = $_SESSION['Harmoid'];
        $ile = seql("SELECT * FROM $HARMONOGRAM", "ile");
        if ($id!="X")
        {
            $wiersz = seql("SELECT * FROM $HARMONOGRAM WHERE ID=$id","fetch");
            $aktywnosc = $wiersz['aktywnosc'];
            $jakiedni = $wiersz['jakiedni'];
            $godziny = $wiersz['godziny']." ,";
            $godziny1 = array();
            $temp = "";
            for ($a=0; $a<strlen($godziny);$a++)
            {
                if ($godziny[$a]!=" " && $godziny[$a]!=",")
                {
                    $temp .= $godziny[$a];
                }
                else
                {
                    $godziny1[] = $temp;
                    $a++;
                    $temp = "";
                }
            }
        }
        else
        {
            $aktywnoscX = array();
            $godzinyX = array();
            $jakiedniX = array();
            for ($i=1; $i<=$ile;$i++)
            {
                $godziny1 = array();
                $wiersz = seql("SELECT * FROM $HARMONOGRAM WHERE ID=$i", "fetch");
                $godzinyX[] = $wiersz['godziny']." ,";
                $aktywnoscX[] = $wiersz['aktywnosc'];
                $jakiedniX[] = $wiersz['jakiedni'];
                $typX[] = $wiersz['typ'];
            }
        }
        $_SESSION['HTML'].="<div class='dodaj'><form method='post' action='przejscie.php'><input type=submit name='strona9' value='Dodaj nowy wpis do harmonogramu'/></form></div>";
        $_SESSION['HTML'].="<div class='harmowybor'><form method='post' action='przejscie.php'><div><select onclick='sprawdz();' name='WYBOR'>";
        $aktywnosctemp = "";
        if ($_SESSION['Harmoid']=="X") $_SESSION['HTML'] .= "<option selected value='X'>Rozkład dnia</option>";
        else $_SESSION['HTML'] .= "<option value='X'>Rozkład dnia</option>";
        for ($j=0;$j<strlen($aktywnosc);$j++)
        {
            if($aktywnosc[$j]=="0") $aktywnosctemp.=" ";
            else $aktywnosctemp.=$aktywnosc[$j];
        }
        for ($i=1; $i<=($ile); $i++)
        {
            $wiersz = seql("SELECT * FROM $HARMONOGRAM WHERE ID=$i","fetch");
            $wybor = $wiersz['aktywnosc'];
            $wybortemp = "";
            for ($j=0;$j<strlen($wybor);$j++)
            {
                if ($wybor[$j]=="0") $wybortemp.=" ";
                else $wybortemp.=$wybor[$j];
            }
            if ($i==$_SESSION['Harmoid']) $_SESSION['HTML'] .= "<option selected value='$i'>$wybortemp</option>";
            else $_SESSION['HTML'] .= "<option value='$i'>$wybortemp</option>";
        }
        $_SESSION['HTML'].="</select></div><input type='submit' value='Wybierz aktywnosc'></form></div>";
        $dni = array("Poniedziałek","Wtorek","Środa","Czwartek","Piątek","Sobota","Niedziela");
        if ($id =="X")
        {
            $_SESSION['HTML'].="<div class='harmonogram' title='Rozkład dnia'><div class='pe'>Rozkład dnia</div><div class='table-naglowek'><div class='naglowek-cell1'></div><div class='naglowek-cell'>07:00</div><div class='naglowek-cell'>08:00</div><div class='naglowek-cell'>09:00</div><div class='naglowek-cell'>10:00</div><div class='naglowek-cell'>11:00</div><div class='naglowek-cell'>12:00</div><div class='naglowek-cell'>13:00</div><div class='naglowek-cell'>14:00</div><div class='naglowek-cell'>15:00</div><div class='naglowek-cell'>16:00</div><div class='naglowek-cell'>17:00</div><div class='naglowek-cell'>18:00</div><div class='naglowek-cell'>19:00</div><div class='naglowek-cell-last'>20:00</div></div>";
            $harmonogramA = array(
                0 => array(" ", " ", " ", " ", " ", " ", " ", " ", " "," "," "," "," "," "),
                1 => array(" ", " ", " ", " ", " ", " ", " ", " ", " "," "," "," "," "," "),
                2 => array(" ", " ", " ", " ", " ", " ", " ", " ", " "," "," "," "," "," "),
                3 => array(" ", " ", " ", " ", " ", " ", " ", " ", " "," "," "," "," "," "),
                4 => array(" ", " ", " ", " ", " ", " ", " ", " ", " "," "," "," "," "," "),
                5 => array(" ", " ", " ", " ", " ", " ", " ", " ", " "," "," "," "," "," "),
                6 => array(" ", " ", " ", " ", " ", " ", " ", " ", " "," "," "," "," "," "),
            );
            for ($g=0; $g<($ile); $g++)
            {
            for ($i=1;$i<=7;$i++)
            {
                for ($j=1;$j<=14;$j++)
                {
                            $jakiedni = $jakiedniX[$g];
                            $godziny = $godzinyX[$g];
                            $Litery = $typX[$g];
                            $litery = $aktywnoscX[$g];
                            $literynew = "";
                            for ($b=0;$b<strlen($litery);$b++)
                            {
                                if ($litery[$b]!="0") $literynew .= $litery[$b];
                                else $literynew .= " ";
                            }
                            $godziny1 = array();
                            $tekst = $Litery[0] .$Litery[1] .$Litery[2];
                            $temp = "";
                            for ($a=0; $a<strlen($godziny);$a++)
                            {   
                                if ($godziny[$a]!=" " && $godziny[$a]!=",") $temp .= $godziny[$a];
                                else
                                {
                                    $godziny1[] = $temp;
                                    $a++;
                                    $temp = "";
                                }
                            }
                            for ($k=0; $k<strlen($jakiedni); $k++)
                                {
                                    $temp1 = $jakiedni[$k];
                                    $len = $godziny1[$k];
                                    $kolory = kolory($ile);
                                    for ($l = 0; $l<strlen($len); $l++)
                                    {
                                        $temp =  ord($len[$l]) - 96;
                                        if ($temp == $j && $temp1 == $i )
                                        {
                                            if($harmonogramA[$i-1][$j-1] == " ") $harmonogramA[$i-1][$j-1] ='<div class="table-cell-alt" name="'.$tekst.'" title="'.$literynew.'" style="color:black; background-color: '.$kolory[($g)].'">'.$tekst.'</div>';
                                            else
                                            {
                                                $tempsz = $harmonogramA[$i-1][$j-1];
                                                $sraa = "";
                                                for ($o=34; $o<strlen($tempsz); $o++)
                                                {
                                                    if ($tempsz[$o]!='"') $sraa.=$tempsz[$o];
                                                    else break;
                                                }
                                                $iks = strlen($sraa);
                                                $iksde = "";
                                                for ($o=0; $o<$iks; $o++)
                                                {
                                                        $iksde.=$sraa[$o];
                                                }
                                                $harmonogramA[$i-1][$j-1] ='<div class="table-cell-alt" style="color:black; background-color: white">'.$tekst."/".$iksde.'</div>';
                                            }
                                        }
                                    }
                            }
                }
            }
        }
        for ($r=0;$r<7;$r++)
        {
            $dzienn = $dni[$r];
            $_SESSION['HTML'].='<div class="table-wiersz">';
            if ($r!=6) $_SESSION['HTML'].='<div class="table-cell1">'.$dzienn.'</div>';
            else $_SESSION['HTML'].='<div class="table-cell1-last">'.$dzienn.'</div>';
        for ($q=0;$q<14;$q++)
        {
            if($harmonogramA[$r][$q] != " ") $_SESSION['HTML'].=$harmonogramA[$r][$q];
            else $_SESSION['HTML'].='<div class="table-cell-alt"></div>';
        }
        $_SESSION['HTML'].='</div>';
        }
        $_SESSION['HTML'].='</div>';
        }
        else
        {
        $_SESSION['HTML'].="<div class='harmonogram' name='TWOJAMAMA' title='".$aktywnosc."'><div class='pe'>".$aktywnosctemp."</div><div class='table-naglowek'><div class='naglowek-cell1'></div><div class='naglowek-cell'>07:00</div><div class='naglowek-cell'>08:00</div><div class='naglowek-cell'>09:00</div><div class='naglowek-cell'>10:00</div><div class='naglowek-cell'>11:00</div><div class='naglowek-cell'>12:00</div><div class='naglowek-cell'>13:00</div><div class='naglowek-cell'>14:00</div><div class='naglowek-cell'>15:00</div><div class='naglowek-cell'>16:00</div><div class='naglowek-cell'>17:00</div><div class='naglowek-cell'>18:00</div><div class='naglowek-cell'>19:00</div><div class='naglowek-cell-last'>20:00</div></div>";
        for ($i=1;$i<=6;$i++)
        {
            $_SESSION['HTML'].='<div class="table-wiersz">';
            for ($j=0;$j<=14;$j++)
            {
                if ($j==0)
                {
                    $dzien = $dni[$i-1];
                    $_SESSION['HTML'].='<div class="table-cell1">'.$dzien.'</div>';
                }
                else {
                    for ($k=0; $k<strlen($jakiedni); $k++)
                    {
                        $temp1 = $jakiedni[$k];
                        $len = $godziny1[$k];
                        for ($l = 0; $l<strlen($len); $l++)
                        {
                            $temp =  ord($len[$l]) - 96;
                            if ($temp == $j && $temp1 == $i )
                            {
                                $_SESSION['HTML'].='<div class="table-cellOn" onclick="activatecells('.$i.$j.');" name="'.$i.$j.'"></div>';
                                if ($j<14) $j++;
                                else if ($j==14) $j=40;
                            }
                        }
                    }
                    if ($j!=40) $_SESSION['HTML'].='<div class="table-cell" onclick="activatecells('.$i.$j.');" name="'.$i.$j.'"></div>';
                }
            }
            $_SESSION['HTML'].='</div>';
        }
        $_SESSION['HTML'].='<div class="table-wiersz">';
        for ($j=0;$j<=14;$j++)
            {
                if ($j==0) $_SESSION['HTML'].='<div class="table-cell1-last">Niedziela</div>';
                else 
                {
                    for ($k=0; $k<strlen($jakiedni); $k++)
                    {
                        $temp1 = $jakiedni[$k];
                        $len = $godziny1[$k];
                        for ($l = 0; $l<strlen($len); $l++)
                        {
                            $temp =  ord($len[$l]) - 96;
                            if ($temp == $j && $temp1 == $i )
                            {
                                $_SESSION['HTML'].='<div class="table-cellOn" onclick="activatecells(7'.$j.');" name="7'.$j.'"></div>';
                                if ($j<14) $j++;
                                else if ($j==14) $j=40;
                            }
                        }
                    }
                    if ($j!=40) $_SESSION['HTML'].='<div class="table-cell" onclick="activatecells(7'.$j.');" name="7'.$j.'"></div>';
                }
            }
            $_SESSION['HTML'].='</div></div><form action="przejscie.php"><div class="zapisz"><input type="submit" value="Zapisz"></div></form><script>var amogus = document.getElementsByName("TWOJAMAMA")[0].title;document.cookie = "NazwaHarmo=" + amogus;</script>';
        }
    }
    else if ($_SESSION['funkcja'] == 1)
    {
        $_SESSION['HTML'].="<div class='dodaj'><form method='post' action='przejscie.php'><input type=submit name='strona7' value='Dodaj nowy stat'/></form></div>";
        $_SESSION['HTML'].="<div class='dodaj'><form method='post' action='przejscie.php'><input type=submit name='strona11' value='Zobacz układ swoich statów'/></form></div>";
        $ile = seql("SELECT * FROM $POZIOMY", "ile");
        for ($i=1;$i<=$ile;$i++)
        {
            $cookie = "level" . $i;
            $cookie1 = "exp" . $i;
            $wiersz = seql("SELECT * FROM $POZIOMY WHERE ID='$i'","fetch");
            if (isset($_COOKIE[$cookie]))
            {
                if ($_COOKIE[$cookie]!="none")
                {
                    $exp = $_COOKIE[$cookie1];
                    $poziom = $_COOKIE[$cookie];
                    seql("UPDATE $POZIOMY SET exp='$exp', poziom='$poziom' WHERE ID='$i'", False);
                    setcookie($cookie, "none");
                    setcookie($cookie1, "none");
                }
                else
                {
                $exp = $wiersz['exp'];
                $poziom = $wiersz['poziom'];
                }
            }
            else
            {
                $exp = $wiersz['exp'];
                $poziom = $wiersz['poziom'];
                setcookie($cookie, "none");
                setcookie($cookie1, "none");
            }
            $max = ($poziom+1)*300;
            $procent = (($exp/$max)*100)."%";
            if ($poziom != 40 && $poziom!=0)
            {
                $_SESSION['HTML'].="<div class='bar'>".$wiersz['nazwa']."<div name='max".$i."'></div><div name='bar".$i."'>".$poziom." LVL [".$exp."/".$max."] EXP</div><div class='bar1'><div class='buttonOn' name='minus".$i."'><input type=submit value='-' onclick='zmniejsz(".$i.");'></div><div class='statbar'><div class='progres' name='stat".$i."' style='width: ".$procent.";'></div></div><div class='buttonOn' name='plus".$i."'><input type=submit value='+' onclick='zwieksz(".$i.");'></div></div></div>";
            }
            else if ($poziom == 0)
            {
                if ($exp==0) $_SESSION['HTML'].="<div class='bar'>".$wiersz['nazwa']."<div name='max".$i."'></div><div name='bar".$i."'>".$poziom." LVL [".$exp."/".$max."] EXP</div><div class='bar1'><div class='buttonOff' name='minus".$i."'><input type=submit value='-' style='transform: scale(0.9);' onclick='zmniejsz(".$i.");'></div><div class='statbar'><div class='progres' name='stat".$i."' style='width: ".$procent.";'></div></div><div class='buttonOn' name='plus".$i."'><input type=submit value='+' onclick='zwieksz(".$i.");'></div></div></div>";
                else $_SESSION['HTML'].="<div class='bar'>".$wiersz['nazwa']."<div name='max".$i."'></div><div name='bar".$i."'>".$poziom." LVL [".$exp."/".$max."] EXP</div><div class='bar1'><div class='buttonOn' name='minus".$i."'><input type=submit value='-' onclick='zmniejsz(".$i.");'></div><div class='statbar'><div class='progres' name='stat".$i."' style='width: ".$procent.";'></div></div><div class='buttonOn' name='plus".$i."'><input type=submit value='+' onclick='zwieksz(".$i.");'></div></div></div>";
            }
            else $_SESSION['HTML'].="<div class='bar'>".$wiersz['nazwa']."<div name='max1'>OSIAGNIETO MAX POZIOM</div><div name='max".$i."'></div><div name='bar".$i."'>".$poziom." LVL</div><div class='bar1'><div class='buttonOn' name='minus".$i."'><input type=submit value='-' onclick='zmniejsz(".$i.");'></div><div class='statbar'><div class='progres' name='stat".$i."' style='width: ".$procent.";'></div></div><div class='buttonOff' style='transform: scale(0.9);' name='plus".$i."'><input type=submit value='+' onclick='zwieksz(".$i.");'></div></div></div>";
        }
    }
    else if ($_SESSION['funkcja'] == 4)
    {
        $_SESSION['HTML'] = "<div class='historia'><div class='log1'><ul><li>ID</li><li>Nazwa</li><li>Status</li><li>Waga</li><li>Data</li><li>Typ</li></ul></div>";
        for ($i=0;$i<sizeof($niedokonane);$i++) $_SESSION['HTML'] .= $niedokonane[$i];
        for ($i=0;$i<sizeof($dokonane);$i++) $_SESSION['HTML'] .= $dokonane[$i];
        $_SESSION['HTML'] .= "</div>";
    }
    else if ($_SESSION['funkcja'] == "3")
    {
        $_SESSION['HTML']="<form method='post' action='przejscie.php'><div class='calosc'><div class='formularz'> <p>Podaj nazwę taska:</p> <input type='text' name='nazwa'></div><div class='formularz'> <p>Podaj typ taska:</p> <select name='typ'><option value='brak'>Brak</option>";
        $ile = seql("SELECT * FROM $POZIOMY", "ile");
        for ($i=1; $i<=$ile; $i++)
        {
            $wiersz = seql("SELECT * FROM $POZIOMY WHERE ID='$i'","fetch");
            $_SESSION['HTML'].="<option value=".$wiersz['typ'].">".$wiersz['typ']."</option>";
        } 
        $_SESSION['HTML'].="</select></div><div class='formularz'> <p>Podaj deadline taska:</p> <input type='date' name='data'></div><div class='formularz'><p>Podaj wagę taska:</p> <input type='range' name='waga' min='1' max='10' step='1'></div><input type='submit' name='strona2' value='Dodaj taska'></div></form>";
        $_SESSION['dodajnowetask'] = "Amogus";
    }
    else if ($_SESSION['funkcja'] == "6")
    {
        $_SESSION['HTML']="<form method='post' action='przejscie.php'><div class='calosc'><div class='formularz'> <p>Podaj nazwę statu:</p> <input type='text' name='nazwa'></div><div class='formularz'> <p>Podaj typ statu:</p> <input type='text' name='typ'></div><div class='formularz'> <p>Podaj klase aktywnosci:</p> <select name='klasa'><option value='scisle'>Nauki ścisłe</option><option value='human'>Humanistyka</option><option value='zdrowie'>Zdrowie</option><option value='zar'>Zaradność</option><option value='sztuka'>Sztuka</option><option value='spol'>Umiejętności społeczne</option></select></div><div class='formularz'><p>Podaj obecny poziom:</p> <input type='range' name='level' min='0' max='9' step='1'></div><input type='submit' name='strona4' value='Dodaj nowy stat'></div></form>";
        $_SESSION['dodajnowestaty'] = "Amogus";
    }
    else if ($_SESSION['funkcja'] == "8")
    {
        $_SESSION['HTML']="<form method='post' action='przejscie.php'><div class='calosc'><div class='formularz'> <p>Podaj nazwę aktywnosci:</p> <input type='text' name='nazwa1'></div><div class='formularz'> <p>Podaj typ aktywnosci:</p> <select name='typ1'><option value='brak'>Brak</option>";
        $ile = seql("SELECT * FROM $POZIOMY", "ile");
        for ($i=1; $i<=$ile; $i++)
        {
            $wiersz = seql("SELECT * FROM $POZIOMY WHERE ID='$i'","fetch");
            $_SESSION['HTML'].="<option value=".$wiersz['typ'].">".$wiersz['typ']."</option>";
        } 
        $_SESSION['HTML'].="</select></div><div class='formularz'><p>Podaj wagę tasków z harmonogramu:</p> <input type='range' name='waga1' min='1' max='10' step='1'></div><input type='submit' name='strona3' value='Dodaj nowy wpis'></div></form>";
        $_SESSION['dodajnoweharmo'] = "Amogus";
    }
    else if ($_SESSION['funkcja'] == "9")
    {
        $wiersz = seql("SELECT * FROM strony WHERE id = '10'","fetch");
        tekst_i_obraz($wiersz);
        $wiersz = seql("SELECT * FROM uzytkownicy WHERE login = '".$_COOKIE['PASS']."'","fetch");
        if ($_SESSION['mode']=="style.css?v=") $fumo = "img/fumolight.png";
        else $fumo = "img/fumodark.png";
        $_SESSION['HTML'] = "<form method='post' action='przejscie.php'><div class='calosc'>".$_SESSION['komunikat']."<div class='formularz2'>Przełącz się na light/dark mode:<div class='mode'><image onclick='modes();' src='$fumo'></div></div><div class='formularz1'><p>ID twojej konwersacji z Rogalem (wpisz X w pole jeżeli nie chcesz dostawać powiadomień):</p><input type='text' name='discord' placeholder='".$wiersz['discord']."'></div>";
        if ($wiersz['dni_wolne']=="") $_SESSION['HTML'] .= "<div class='formularz2'><div style='width:fit-content;'><p style='margin-right:0; width:100%;'>Wyłącz aktywność harmonogramu w dni wolne:</p></div><input type='submit' style='width: 20%; margin-left:40px; height: 5vh;'='submit' name='dniwolne' value='Wyłącz'></div>";
        else $_SESSION['HTML'] .= "<div class='formularz2'><div style='width:fit-content;'><p style='margin-right:0; width:100%;'>Włącz aktywność harmonogramu w dni wolne:</p></div><input type='submit' style='width: 20%; margin-left:40px; height: 5vh;'='submit' name='dniwolne' value='Włącz'></div>";
        $_SESSION['HTML'] .= "<div class='formularz2'><div style='width:fit-content;'><p style='margin-right:0; width:100%;'>Usuń wszystkie pliki związane z twoim kontem:</p></div><input type='submit' style='width: 20%; margin-left:40px; height: 5vh;'='submit' name='Usun' value='Usuń'></div><div class='formularz2'><input type='submit' style='width: 30%; height: 5vh;' name='Logout' value='Wyloguj się'></div><div class='formularz2'><input type='submit' style='width: 40%' name='settingssave' value='Zapisz'></div></div></form>";
    }
    else if ($_SESSION['funkcja'] == "10") 
    {
        $stat = array("scisle" => 0, "human" => 0, "zdrowie" => 0, "zar" => 0, "sztuka" => 0, "spol" => 0);
        $ile = seql("SELECT * FROM $POZIOMY","ile");
        for ($i=1;$i<=$ile;$i++)
        {
            $wiersz = seql("SELECT * FROM $POZIOMY WHERE ID=$i", "fetch");
            $lvl = $wiersz['poziom'] + ($wiersz['exp']/(($lvl+1)*300));
            $klasa = $wiersz['klasa'];
            $stat[$klasa] += $lvl;
        }
        $scisle = $stat['scisle']/100;
        $human = $stat['human']/100;
        $zdrowie = $stat['zdrowie']/100;
        $zar = $stat['zar']/100;
        $sztuka = $stat['sztuka']/100;
        $spol = $stat['spol']/100;
        $_SESSION['HTML'] = "<canvas></canvas><script>var canvas = document.querySelector('canvas');var c = canvas.getContext('2d');canvas.width = 670;canvas.height = 590;a = 200;x = 300;y = 100;sin30 = 0.5;cos30 = 0.8660;c.beginPath();c.moveTo(x, y);c.lineWidth = '3';for (var i=0; i<11;i++){if (i==0) {x = x; y += 2*a;}else if (i==1) {x+=a*cos30;y-=a*sin30}else if (i==2) {x=300-(a*cos30);y=100+a*sin30}else if (i==3) {x=x;y+=a}else if (i==4) {x=300+(a*cos30);y=100+a*sin30}else if (i==5) {x=300;y=100}else if (i==6) {x-=(a*cos30);y+=a*sin30}else if (i==7) {x=x;y+=a}else if (i==8) {x=300;y=500}else if (i==9) {x+=a*cos30;y-=a*sin30}else if (i==10) {x=x;y-=a}c.lineTo(x, y);}c.strokeStyle = 'black';c.fillStyle = 'rgba(255,215,100,0.7)';c.fill();c.stroke();c.lineWidth = '2';for (var j=0;j<4;j++){c.beginPath();for (i=0;i<7;i++){if (i==0) {x = 300; y=300-a*(0.2*(4-j));}else if (i==1) {x=300-a*cos30*(0.2*(4-j));y=300-a*sin30*(0.2*(4-j))}else if (i==2) {x=300-(a*cos30)*(0.2*(4-j));y=300+a*sin30*(0.2*(4-j))}else if (i==3) {x=300;y=300+a*(0.2*(4-j))}else if (i==4) {x=300+(a*cos30)*(0.2*(4-j));y=300+a*sin30*(0.2*(4-j))}else if (i==5) {x=300+(a*cos30)*(0.2*(4-j));y=300-a*sin30*(0.2*(4-j))}else if (i==6) {x=300;y=300-a*(0.2*(4-j))}c.lineTo(x, y);}c.stroke();}stopnie=[$scisle,$human,$zdrowie,$zar,$sztuka,$spol];c.beginPath();c.arc(300,300, a, 0, 2*Math.PI, false);c.stroke();c.beginPath();c.moveTo(300, 300-a*stopnie[0]);c.lineWidth = '5';c.strokeStyle = 'red';i=0;console.log(stopnie[i]);for (i=1;i<=6;i++){console.log(stopnie[i]); if (i==1) {x = 300+(a*stopnie[i]*cos30); y = 300-(a*stopnie[i]*sin30);}else if (i==2) {x=300+(a*stopnie[i]*cos30); y = 300+(a*stopnie[i]*sin30)}else if (i==3) {x=300;y=300+a*stopnie[i]}else if (i==4) {x=300-(a*cos30*stopnie[i]); y=300+(a*stopnie[i]*sin30);}else if (i==5) {x=300-(a*cos30*stopnie[i]); y=300-(a*stopnie[i]*sin30);}else if (i==6) {x=300; y=300-a*stopnie[0];}c.lineTo(x, y);}c.stroke();c.fillStyle='rgba(255,100,100,0.7)';c.fill();for (i=0;i<6;i++){var x;if (stopnie[i]>=0&&stopnie[i]<0.2) x = 'E';else if (stopnie[i]>=0.2&&stopnie[i]<0.4) x = 'D';else if (stopnie[i]>=0.4&&stopnie[i]<0.6) x = 'C';else if (stopnie[i]>=0.6&&stopnie[i]<0.8) x = 'B';else x = 'A';if (i==0){c.font= '20px Monospace';c.fillStyle='white';c.fillText('Nauki ścisle',240,40);c.font= '50px Monospace';c.fillStyle='rgb(225,205,0)';c.fillText(x,288,80);}else if (i==1){c.font= '20px Monospace';c.fillStyle='white';c.fillText('Humanistyka',530,190);c.font= '50px Monospace';c.fillStyle='rgb(225,205,0)';c.fillText(x,488,200);}else if (i==2){c.font= '20px Monospace';c.fillStyle='white';c.fillText('Zdrowie',530,400);c.font= '50px Monospace';c.fillStyle='rgb(225,205,0)';c.fillText(x,488,410);}else if (i==3){c.font= '20px Monospace';c.fillStyle='white';c.fillText('Zaradność',250,570);c.font= '50px Monospace';c.fillStyle='rgb(225,205,0)';c.fillText(x,287,550);}else if (i==4){c.font= '20px Monospace';c.fillStyle='white';c.fillText('Sztuka',15,400);c.font= '50px Monospace';c.fillStyle='rgb(225,205,0)';c.fillText(x,90,410);}else if (i==5){c.font='20px Monospace';c.fillStyle='white';c.fillText('Społ.',20,190);c.font= '50px Monospace';c.fillStyle='rgb(225,205,0)';c.fillText(x,90,200);}}</script>";
    }
}
else $_SESSION['funkcja'] = 0;
header("location: glowna");
?>