from constants import *
import getProjectInfo

class htmlEdit:


    @staticmethod
    def getPaths():
        thisDir = abspath(__file__)
        template = join(dirname(dirname(thisDir)), "template")
        mainDir = join(template, "main", "index.html")
        fillingDir = join(template, "gallery", "window.html")
        return mainDir, fillingDir

    @staticmethod
    def getHTML():
        mainDir, fillingDir = htmlEdit.getPaths()
        file = open(mainDir, "r")
        mainCode = file.read()
        file.close()
        file = open(fillingDir, "r")
        fillingCode = file.read()
        file.close()
        return mainCode, fillingCode

    @staticmethod
    def fillTemplate():
        data = getProjectInfo.Projects.getProjectData()
        mainCode, fillingCode = htmlEdit.getHTML()
        tempCode = ""
        for project in data:
            tempFill = fillingCode
            githubURL = join("https://github.com/Kamilek7", project)
            tempFill = tempFill.replace("#SITE LINK#", githubURL)
            tempFill = tempFill.replace("#IMAGE#", join("images",project,data[project]["images"][0]))
            tempCode += tempFill
        mainCode = mainCode.replace("#WINDOW GALLERY#", tempCode)
        return(mainCode)

    @staticmethod
    def createOutputFiles():
        mainCode = htmlEdit.fillTemplate()
