import json
import os
import shutil

def zamienTekst(dane,kodHTML,strin):
    num = dane.find(strin) + len(strin) + 1
    tekst = ""
    while dane[num]!="#":
        tekst += dane[num]
        num+=1
    tekst = tekst[0:len(tekst)]
    num = kodHTML.find(strin)
    kodHTML = kodHTML[0:num] + tekst +kodHTML[num+len(strin):len(kodHTML)]
    return kodHTML
def wrzucTekst(kodGlowny,kodWewnetrzny):
    strin="#ARTYKUL"
    num = kodGlowny.find(strin)
    kodGlowny = kodGlowny[0:num] + kodWewnetrzny +kodGlowny[num+len(strin):len(kodGlowny)]
    return kodGlowny
current_dir = os.path.dirname(os.path.realpath(__file__))
print("Otworzyłeś program do ekstrakcji twoich projektow do twojej strony HTML (Portfolio)")
odp = input("Czy chcesz kontynuować? (Y/N)\n")
if (odp.lower()=="y"):
    print("\nInstrukcje:\n\nAby wygenerować nowy kod HTML pamietaj żeby zdefiniować następujące wartości w plikach i folderach:\n\n\nW ustawieniach:\n\nŚcieżka do folderu z projektami\nŚcieżka do folderu z plikami szkicu strony\nSciezke do folderu z danymi podstron\nListe wszystkich projektow ktorym ma zostac przypisana podstrona\n\nW plikach:\n\nUstawic odpowiednia baze HTML do wykorzystania jako szablon\nWstawic wszystkie pliki do folderu z danymi\nUpewnic sie ze wszystkie pliki sa na swoim wyznaczonym miejscu\n")
    odp = input("Czy chcesz przerwac program aby dokonac zmian w pliku ustawien?\nBŁĘDY MOGĄ MIEĆ NEGATYWNY WPLYW NA TWOJE PLIKI!\n(Y/N)\n")
    if (odp.lower()=="n"):
        plik = open(os.path.join((current_dir+"\\"),"ustawienia.json"),"rt")
        ustawienia = json.loads(plik.read())
        plik.close()
        sciezka = ustawienia["projektyDir"]
        szkice = ustawienia["szkice"]
        dane = ustawienia["dane"]
        projekty = ustawienia["projekty"]
        pPython = ""
        pHTML = ""
        pCPP = ""
        for i in projekty:
            if os.path.exists(os.path.join((sciezka + "\\"),i["sciezka"])):
                if i["typ"] == "HTML":
                    if os.path.exists(os.path.join((current_dir+"\\"),("output\\" + i["nazwa"]))):
                        shutil.rmtree(os.path.join((current_dir+"\\"),("output\\" + i["nazwa"])))
                    shutil.copytree(os.path.join((sciezka + "\\"),i["sciezka"]),os.path.join((current_dir+"\\"),("output\\" + i["nazwa"])))
                    temp = os.path.join((current_dir+"\\"),("output\\" + i["nazwa"]))
                    for file in os.listdir(temp):
                        if file.endswith(".html") or file.endswith(".php"):
                            f = open(os.path.join(temp,file),"r+",encoding='utf-8')
                            kod = f.read()
                            f.close()
                            n = kod.find("body") - 1
                            if n>20:
                                n+=5
                                while kod[n]==" ":
                                    n+=11
                                    while kod[n]!="\"":
                                        n+=1
                                    n+=1
                                if kod[n]==">":
                                    n+=1
                                    f1 = open(current_dir+"\\base\\doHTML.txt")
                                    if i["nazwa"] == "Color Palette Generator":
                                        f1.close()
                                        f1 = open(current_dir+"\\base\\doHTMLContrast.txt")
                                    kodHTML = f1.read()
                                    f1.close()
                                    if os.path.exists(current_dir+"\\dane\\" + i["nazwa"] + ".txt"):
                                        f1 = open(current_dir+"\\dane\\" + i["nazwa"] + ".txt",encoding='utf-8')
                                        dane = f1.read()
                                        kodHTML = zamienTekst(dane,kodHTML,"#POWITALNE")
                                        kodHTML = zamienTekst(dane,kodHTML,"#OPIS")
                                        f1.close()
                                    kod = kod[0:n] + kodHTML + kod[n+1:len(kod)-1]
                                    f = open(os.path.join(temp,file),"w",encoding='utf-8')
                                    f.write(kod)
                                    f.close()
                        elif file.endswith(".css"):
                            f = open(current_dir+"\\base\\doCSS.txt","r")
                            kod = f.read()
                            f.close()
                            f = open(os.path.join(temp,file),"a",encoding='utf-8')
                            f.write(kod)
                            f.close()
                if os.path.exists(current_dir+"\\dane\\" + i["nazwa"] + ".txt"):
                    f1 = open(current_dir+"\\dane\\" + i["nazwa"] + ".txt",encoding='utf-8')
                    dane = f1.read()
                    f1.close()
                    f1 = open(current_dir+"\\base\\tekstDoHTML.txt",encoding='utf-8')
                    kodHTML = f1.read()
                    f1.close()
                    kodHTML = zamienTekst(dane,kodHTML,"#NAGLOWEK")
                    kodHTML = zamienTekst(dane,kodHTML,"#TEKST")
                    if dane.find("#GALERIA")!=-1:
                        f1 = open(current_dir+"\\base\\tekstDoGalerii.txt",encoding='utf-8')
                        galeria = f1.read()
                        f1.close()
                        if os.path.exists(current_dir+"\\dane\\img\\" + i["nazwa"]):
                            num = len(os.listdir(current_dir+"\\dane\\img\\" + i["nazwa"]))
                            galeria = zamienTekst(dane,galeria,"#IMAGES")
                            left = str(14.65*(num-1)) + "vw";
                            galeria = galeria.replace("#LEFT",left)
                            kodHTML = kodHTML.replace("#GALERIA",galeria)
                    kodHTML = kodHTML.replace("#GALERIA","")
                    kodHTML = zamienTekst(dane,kodHTML,"#LINK")
                    if i["typ"] == "Python":
                        pPython += kodHTML
                    elif i["typ"] == "HTML":
                        pHTML += kodHTML
                    elif i["typ"] == "CPP":
                        pCPP += kodHTML
                else:
                    f1 = open(current_dir+"\\base\\tekstDoHTML.txt",encoding='utf-8')
                    kodHTML = f1.read()
                    f1.close()
                    dane = "#NAGLOWEK "+ i["nazwa"] + "#TEKST Troche tu pusto...<br><br> Ten projekt nie ma jeszcze stworzonego opisu#"
                    kodHTML = zamienTekst(dane,kodHTML,"#NAGLOWEK")
                    kodHTML = zamienTekst(dane,kodHTML,"#TEKST")
                    if i["typ"] == "Python":
                        pPython += kodHTML
                    elif i["typ"] == "HTML":
                        kodHTML = zamienTekst(dane,kodHTML,"#LINK")
                        pHTML += kodHTML
                    elif i["typ"] == "CPP":
                        pCPP += kodHTML
            else:
                print(str("Nieprawidlowa sciezka dla pliku " + i["nazwa"] + "\n" + str(os.path.join((sciezka + "\\"),i["sciezka"]))))
        f1 = open(current_dir+"\\base\\index.html",encoding='utf-8')
        kodGlowny1 = f1.read()
        f1.close()
        f = open(current_dir+"\\output\\indexPy.html","w",encoding='utf-8')
        kodGlowny = wrzucTekst(kodGlowny1,pPython)
        kodGlowny = kodGlowny.replace("#GALERIA","")
        f.write(kodGlowny)
        f.close()
        f = open(current_dir+"\\output\\indexWeb.html","w",encoding='utf-8')
        kodGlowny = wrzucTekst(kodGlowny1,pHTML)
        kodGlowny = kodGlowny.replace("#GALERIA","")
        f.write(kodGlowny)
        f.close()
        f = open(current_dir+"\\output\\indexCPP.html","w",encoding='utf-8')
        kodGlowny = wrzucTekst(kodGlowny1,pCPP)
        kodGlowny = kodGlowny.replace("#GALERIA","")
        f.write(kodGlowny)
        f.close()
        f = open(current_dir+"\\output\\index.html","w",encoding='utf-8')
        f1 = open(current_dir+"\\dane\\Main.txt",encoding='utf-8')
        dane = f1.read()
        f1.close()
        f1 = open(current_dir+"\\base\\tekstDoHTML.txt",encoding='utf-8')
        kodHTML = f1.read()
        f1.close()
        kodHTML = zamienTekst(dane,kodHTML,"#NAGLOWEK")
        kodHTML = zamienTekst(dane,kodHTML,"#TEKST")
        kodGlowny = wrzucTekst(kodGlowny1,kodHTML)
        f.write(kodGlowny)
        f.close()
        f = open(current_dir+"\\output\\me.html","w",encoding='utf-8')
        f1 = open(current_dir+"\\dane\\me.txt",encoding='utf-8')
        dane = f1.read()
        f1.close()
        f1 = open(current_dir+"\\base\\tekstDoHTML.txt",encoding='utf-8')
        kodHTML = f1.read()
        f1.close()
        kodHTML = zamienTekst(dane,kodHTML,"#NAGLOWEK")
        kodHTML = zamienTekst(dane,kodHTML,"#TEKST")
        kodGlowny = wrzucTekst(kodGlowny1,kodHTML)
        kodGlowny = kodGlowny.replace("#GALERIA","")
        f.write(kodGlowny)
        f.close()
        if os.path.isfile(current_dir + "\\output\\powrot.png"):
            os.remove(current_dir + "\\output\\powrot.png")
        shutil.copyfile((current_dir + "\\base\\powrot.png"),(current_dir + "\\output\\powrot.png"))
        if os.path.isfile(current_dir + "\\output\\bracketsR.png"):
            os.remove(current_dir + "\\output\\bracketsR.png")
        shutil.copyfile((current_dir + "\\base\\bracketsR.png"),(current_dir + "\\output\\bracketsR.png"))
        if os.path.isfile(current_dir + "\\output\\brackets.png"):
            os.remove(current_dir + "\\output\\brackets.png")
        shutil.copyfile((current_dir + "\\base\\brackets.png"),(current_dir + "\\output\\brackets.png"))
        if os.path.isfile(current_dir + "\\output\\styles.css"):
            os.remove(current_dir + "\\output\\styles.css")
        shutil.copyfile((current_dir + "\\base\\styles.css"),(current_dir + "\\output\\styles.css"))
        if os.path.exists(os.path.join((current_dir+"\\"),("output\\img"))):
            shutil.rmtree(os.path.join((current_dir+"\\"),("output\\img")))
        shutil.copytree(os.path.join((current_dir + "\\dane\\img")),os.path.join((current_dir+"\\"),("output\\img")))