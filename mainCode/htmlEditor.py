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
        mainFiles = findExtension(MAIN_DIR,"html")
        for i in range(len(mainFiles)):
            mainFiles[i] = join(MAIN_DIR, mainFiles[i])
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
    def newPageLinks():
        pass

    @staticmethod
    def createOutputFiles():
        htmls = htmlEdit.getFilledHTML()
        if not exists(IMAGES_DIR):
            os.mkdir(IMAGES_DIR)
        for file in htmls:
            createFile(join(OUTPUT_DIR,basename(file)), htmls[file])
        processingFiles = os.listdir(MAIN_DIR)
        for i in processingFiles:
            for j in htmls:
                if i == basename(j):
                    processingFiles.remove(i)
        for file in processingFiles:
            copyfile(join(MAIN_DIR, file), join(OUTPUT_DIR, file))
        for project in PROJECTS:
            if not exists(join(IMAGES_DIR, project)):
                os.mkdir(join(IMAGES_DIR, project))
            for image in PROJECTS[project]["images"]:
                pathToImage = join(MAIN_PROJECT_DIR, PROJECTS[project]["path"], "imagesForGallery", basename(image))
                pathInOutput = join(OUTPUT_DIR, image)
                copyfile(pathToImage, pathInOutput)
