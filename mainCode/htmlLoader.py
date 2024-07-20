from constants import *

class FileLoader:
    @staticmethod
    def loadHTML(dir):
        if isfile(dir):
            file = open(dir, "r")
            html = file.read()
            file.close()
            return html
        else:
            raise OSError("Na scieżce " + dir + " nie znaleziono żądanego pliku.")