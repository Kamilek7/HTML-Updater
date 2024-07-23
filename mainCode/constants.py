from os.path import *
from shutil import *
import os

# zdefiniowane dla mojego ukladu folderow

MAIN_PROJECT_DIR = join(dirname(dirname(dirname(dirname(dirname(abspath(__file__)))))), "skonczone")
THIS_DIR = dirname(dirname(abspath(__file__)))
TEMPLATE_DIR = join(THIS_DIR, "template")
MAIN_DIR = join(TEMPLATE_DIR, "main")
OUTPUT_DIR = join(THIS_DIR, "output")
IMAGES_DIR = join(OUTPUT_DIR,"images")

def loadFile(dir):
    if isfile(dir):
        file = open(dir, "r")
        html = file.read()
        file.close()
        return html
    else:
        raise OSError("Na scieżce " + dir + " nie znaleziono żądanego pliku.")
    
def findExtension(path, ext):
    files = os.listdir(path)
    output = []
    for file in files:
        if "." + ext in file:
            output.append(file) 
    return output

def createFile(path, code):
    file = open(path, "w")
    file.write(code)
    file.close()