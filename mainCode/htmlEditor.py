from constants import *
from htmlAnalyser import *

class htmlEdit:

    @staticmethod
    def fillFile(dir):
        code = loadFile(dir)
        codesAndLines = CodesExtractor.extractCoding(code)
        for codes in codesAndLines:
            code = CodeAnalyser.getNewHTML(codes, code)
        return code

    @staticmethod
    def getPaths():
        template = join(THIS_DIR, "template")
        mainDir = join(template, "main")
        mainFiles = findExtension(mainDir,"html")
        for i in range(len(mainFiles)):
            mainFiles[i] = join(mainDir, mainFiles[i])
        return mainFiles

    @staticmethod
    def getFilledHTML():
        mainDirs = htmlEdit.getPaths()
        dirsWithCodes = {}
        for file in mainDirs:
            temp = htmlEdit.fillFile(file)
            dirsWithCodes[file] = temp
        return dirsWithCodes
    
    @staticmethod
    def createOutputFiles():
        template = join(THIS_DIR, "template")
        mainDir = join(template, "main")
        htmls = htmlEdit.getFilledHTML()
        outputDir = join(THIS_DIR, "output")
        imagesDir = join(outputDir,"images")
        if not exists(imagesDir):
            os.mkdir(imagesDir)
        for file in htmls:
            createFile(join(outputDir,basename(file)), htmls[file])
        processingFiles = os.listdir(mainDir)
        for i in processingFiles:
            for j in htmls:
                if i == basename(j):
                    processingFiles.remove(i)
        for file in processingFiles:
            copyfile(join(mainDir, file), join(outputDir, file))
        for project in PROJECTS:
            if not exists(join(imagesDir, project)):
                os.mkdir(join(imagesDir, project))
            for image in PROJECTS[project]["images"]:
                pathToImage = join(MAIN_PROJECT_DIR, PROJECTS[project]["path"], "imagesForGallery", basename(image))
                pathInOutput = join(outputDir,image)
                copyfile(pathToImage, pathInOutput)

htmlEdit.createOutputFiles()