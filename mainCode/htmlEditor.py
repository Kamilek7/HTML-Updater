import getProjectInfo
from constants import *

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
        return(mainCode, data)

    @staticmethod
    def createOutputFiles():
        mainDir = dirname(dirname(abspath(__file__)))
        mainCode, data = htmlEdit.fillTemplate()
        outputDir = join(mainDir, "output")
        imagesDir = join(outputDir,"images")
        if not exists(imagesDir):
            os.mkdir(imagesDir)
        file = open(join(outputDir,"index.html"), "w")
        file.write(mainCode)
        file.close()
        templateDir = join(mainDir, "template", "main")
        for file in ["main.js", "styles.css"]:
            copyfile(join(templateDir, file), join(outputDir, file))
        for project in data:
            if not exists(join(imagesDir, project)):
                os.mkdir(join(imagesDir, project))
            for image in data[project]["images"]:
                pathToImage = join(MAIN_PROJECT_DIR, data[project]["path"], "imagesForGallery", image)
                pathInOutput = join(imagesDir,project, image)
                copyfile(pathToImage, pathInOutput)
