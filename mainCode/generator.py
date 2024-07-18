from htmlEditor import *
szerokosc = 10
wiadomosc = "Witaj w progamie sluzacym do generowania gotowych projektow HTML na podstawie odpowiednich szablonow i ustawień wypisanych w załączonym pliku .JSON. Program jak na razie kompletnie raczkuje i został stworzony z zamysłem obsługi go przez odpowiedni serwer (np web server Django ze swoim 'gui')."
podkreslenia = "="* szerokosc
wiadomosc = podkreslenia+ "\n" + wiadomosc + "\n" + podkreslenia
wiadomosc.rjust(szerokosc," ")
print(wiadomosc)
htmlEdit.createOutputFiles()