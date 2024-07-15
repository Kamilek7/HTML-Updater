from os.path import *
class htmlEdit:
    mainCode = ""
    mainDir = ""
    fillingCode = ""
    fillingDir = ""
    dataDir = ""
    data = {}

    @staticmethod
    def loadPaths():
        thisDir = abspath(__file__)
        template = join(dirname(dirname(thisDir)), "template")
        htmlEdit.mainDir = join(template, "main", "index.html")
        htmlEdit.fillingDir = join(template, "gallery", "window.html")
        resources = join(dirname(dirname(thisDir)), "resources")

    @staticmethod
    def loadHTML():
        file = open(htmlEdit.mainDir, "r")
        htmlEdit.mainCode = file.read()
        file.close()
        file = open(htmlEdit.fillingDir, "r")
        htmlEdit.fillingCode = file.read()
        file.close()

    @staticmethod
    def loadImages():
        pass

    @staticmethod
    def loadData():
        pass

    @staticmethod
    def fillTemplate():
        pass

htmlEdit.loadPaths()
htmlEdit.loadHTML()
print(htmlEdit.mainCode)