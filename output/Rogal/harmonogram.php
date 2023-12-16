<?php
    #Wszystko na CBA działało w oparciu o Cron więc nie wiem jak to wszystko byłoby kompatybilne z innymi stronami. Wszystko działa w taki sposób, że co godzinę był wykonywany skrypt który sprawdzał która jest godzina oraz dzień, i w oparciu o tą datę wysyłał pingi na Discordzie o wykonaniu taska z harmonogramu, a rano wrzucał wszystkie zadania z harmonogramu na dzień do listy.
    $dzisiaj = date("D");
    $numer;
    if ($dzisiaj=="Mon") $numer = 1;
    else if ($dzisiaj=="Tue") $numer = 2;
    else if ($dzisiaj=="Wed") $numer = 3;
    else if ($dzisiaj=="Thu") $numer = 4;
    else if ($dzisiaj=="Fri") $numer = 5;
    else if ($dzisiaj=="Sat") $numer = 6;
    else if ($dzisiaj=="Sun") $numer = 7;
    #Dane z bazy danych w SQL, simple enough.
    $host = "mysql.cba.pl";
    $db_user = "kamilek777";
    $db_password = "Czolo42069";
    $db_name = "kamilek777";
    $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);

    $sql = "SELECT * FROM uzytkownicy";
    $result = $polaczenie->query($sql);
    $ilu = $result->num_rows;

    #Funkcja od Przemka która wysyła pingi na Discorda. To dalej mnie zachwyca, że api Discorda jest obsługiwane również przez PHP.
    function send($msg,$id="1092760909337862144"){
        $token="token";
        $curl = curl_init("https://discord.com/api/v9/channels/$id/messages");
        curl_setopt($curl, CURLOPT_POSTFIELDS, array('content' => $msg));
        curl_setopt($curl, CURLOPT_HTTPHEADER, ["authorization: $token"]);
        curl_exec($curl);
    }
    $sranie=1
    for ($i=1;$sranie<=$ilu;$i++)
    {
        #Tutaj coś musiałbym naprawić bo w gruncie rzeczy przy usuwaniu danych uzytkownikow z SQL może się zakłócić porządek w bazach danych. Rozwiązanie miałem gdzieś w loginie. Zmieniłem w funkcji for i na zmienna która sie zwieksza jezeli zostanie znaleziony uzytkownik, ale tego nie testowalem w ogole.
        $sql = "SELECT * FROM uzytkownicy WHERE ID='$i'";
        $result = $polaczenie->query($sql);
        $xd = $result->num_rows;
        $taskusgodz = "";
        if ($xd != 0)
        {
        $sranie++;
        $wiersz = $result->fetch_assoc();
        $czy = $wiersz['dni_wolne'];
        #ciekawym pomyslem byloby dodanie kalendarzyka ktorym mozna zmieniac daty dni wolnych, ale to nie dla mnie na ten moment.
        if ($czy!="")
        {
            $daty = array(
                "01-01",
                "01-06",
                "05-01",
                "05-02",
                "05-03",
                "08-15",
                "11-01",
                "11-11",
                "12-25",
                "12-26",
                "04-09",
                "04-10",
                "05-28",
                "06-08",
            );
            $dzis = date("Y-m-d");
            
            for ($l; $l<sizeof($daty);$l++)
            {
                $dataa = "2023-" . $daty[$l];
                if ($dzis == $dataa)
                {
                    exit();
                } 
            }

            
        }
        $uzytkownicy = $wiersz['login'];
        $discordurl = $wiersz['discord'];
        $TASKI = $uzytkownicy . "taski";
        $HARMONOGRAM = $uzytkownicy . "harmonogram";
        $sql = "SELECT * FROM $HARMONOGRAM";
        $rezultat = $polaczenie->query($sql);
        $ile = $rezultat->num_rows;
        for ($j=1; $j<=$ile; $j++)
        {
            #dni i godziny w harmonogramie sa w formiacie dni - cyfry, godziny - litery, wiec sprawdzamy czy cyfrowy odpowiednik dnia tygodnia znajduje sie w w harmonogramowym tasku o okreslonym id
            $sql1 = "SELECT * FROM $HARMONOGRAM WHERE ID='$j' AND jakiedni LIKE '%$numer%'";
            $rezultat = $polaczenie->query($sql1);
            if ($rezultat->num_rows!=0)
            {
                $wiersz = $rezultat->fetch_assoc();
                $nazwa = $wiersz['aktywnosc'];
                $waga = $wiersz['waga'];
                $typ = $wiersz['typ'];
                $godziny = $wiersz['godziny'];
                $jakiedni = $wiersz['jakiedni'];
                $temp = "";
                #tu sie zaczyna robic gorąco bo mam tutaj rozdzielic stringa z bazy danych na okreslone dni
                $godziny1 = array(1=>"",2=>"",3=>"",4=>"", 5=>"", 6=>"", 7=>"");
                $k=0;
                for ($a=0; $a<strlen($godziny);$a++)
                {
                    #jezeli nie ma spacji albo przecinka to znaczy ze zbior liter nalezy do jednego dnia i zbior tych liter zostaje dodany do odpowiedniego elementu listy odpowiadajacego dniu ktory bierzemy ze zbioru z jakiedni po kolei
                    if ($godziny[$a]!=" " && $godziny[$a]!=",")
                    {
                        $temp .= $godziny[$a];
                    }
                    else
                    {
                        $licznik = $jakiedni[$k];
                        $godziny1[$licznik] = $temp;
                        $a++;
                        $temp = "";
                        $k++;
                    }
                }
                $amo = $godziny1[$numer];
                #tutaj zamieniam kazda litere z godzin na odpowiednia godzine
                for ($g=0;$g<strlen($amo);$g++)
                {
                    $temp= $amo[$g];
                    $ciag = $temp;
                    $x = 1;
                    while ($amo[$g+1]==(chr(ord($temp)+$x)))
                    {
                        #laczylem wszystko w jeden ciąg jezeli litery nastepowaly jedna po drugiej
                        $ciag .=$amo[$g+1];
                        $x++;
                        $g++;
                    }
                    
                    if (strlen($ciag)>1)
                    {   
                        #potem taki zlozony ciag wrzucalem jako jeden np 16:00-20:00 zeby nie robic sobie spamu na dc ani na rogalu (chociaz godne uwagi jest to ze zapomnialem ustawic wage tak zeby byla wieksza jak byl dluzszy task)
                        $aw = intval(ord($ciag[0]))-90;
                        if ($aw>9)
                            {
                                $godzinytask = strval($aw).":00 - ".strval(intval(ord($ciag[(strlen($ciag)-1)])-90)).":00";
                                $SPRAWDZ = strval(intval(ord($ciag[0]))-91).":00";
                            }
                        else
                            {
                                $godzinytask = "0" . strval($aw).":00 - ".strval(intval(ord($ciag[(strlen($ciag)-1)])-90)).":00";
                                $SPRAWDZ = "0" . strval($aw - 1).":00";
                            }
                    }
                    else
                    {
                        $aw = intval(ord($ciag))-90;
                        if ($aw>9)
                        {
                            $godzinytask = strval($aw).":00";
                            $SPRAWDZ = strval($aw - 1).":00";
                        }
                        else
                        {
                            $godzinytask = "0" . strval($aw).":00";
                            $SPRAWDZ = "0" . strval($aw - 1).":00";
                        }

                    }
                    #tutaj glownie chodzi o to ze sql z jakiegos powodu zawalał spacje i musialem je zastępowac zerami zeby wszystko bylo git, ale w srodowiskach bardziej graficznych te zera zamienialem na spacje (chociaz nie wszedzie tak zrobilem bo I forgor)
                    $nazwatemp = "";
                    for ($z=0;$z<strlen($nazwa);$z++)
                    {
                        if($nazwa[$z]=="0") $nazwatemp.=" ";
                        else $nazwatemp.=$nazwa[$z];
                    }
                    #wszystko dzieje sie w obrębie jednego zlozenia godzin, dlatego to jest jeszcze w srodku petli
                    $temp1="Pamiętaj o wykonaniu dzisiaj swojego tasku: ".$nazwatemp." w godzinach: ";
                    $temp1 .= $godzinytask." ";
                    $taskusgodz= $temp1;
                    $data = date("Y-m-d");
                    $nazwa1 = $nazwatemp . " " . $godzinytask;
                    $GODZINA = date("H:i");
                    #O siodmej dodaja sie taski, zrob tak zeby waga byla wieksza o tyle razy na ile dlugi jest task (to jest proste do zrobienia raczej ale nie chce teraz robic bledow o ktorych zapomne bo i tak teraz niczego nie testuje)
                    if ($GODZINA=="07:00")
                    {
                    $sql2 = "INSERT INTO `$TASKI` (`dynID`, `nazwa`, `status`, `waga`, `data`, `typ`) VALUES ('0', '$nazwa1', 'niedokonane', '$waga', '$data', '$typ')";
                    $polaczenie->query($sql2);
                    }
                    #sprawdz to godzina tasku zmniejszona o jeden, jest tam gdzies wczesniej
                    if ($discordurl!=""&&$GODZINA==$SPRAWDZ) send($taskusgodz,$discordurl);
                }
            } 
        }
    }
    }
?>
