from htmlEditor import *
def runGenerator():
    htmlEdit.createOutputFiles()
szerokosc = 60

wiadomosc = "Witaj w progamie sluzacym do generowania gotowych projektow HTML na podstawie odpowiednich szablonow i ustawień w nich zapisanych. Program jak na razie kompletnie raczkuje i został stworzony z zamysłem obsługi go przez odpowiedni serwer (np web server Django ze swoim 'gui')."

podkreslenia = "="* szerokosc
slowa = wiadomosc.split()
wiadomosc = ""
i = 0
linijka = ""
while i < len(slowa):
    slowo = slowa[i] + " "
    if len(slowo) + len(linijka) <= szerokosc:
        linijka+=slowo
        i+=1
    else:
        linijka = linijka.ljust(szerokosc, " ")
        wiadomosc += linijka + "\n"
        linijka = ""
wiadomosc += linijka


wiadomosc = podkreslenia+ "\n" + wiadomosc + "\n" + podkreslenia

print(wiadomosc)
runGenerator()