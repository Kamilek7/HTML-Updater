from htmlLoader import *
class CodesExtractor:

    @staticmethod
    def removeSpaces(splitLines):
        i = 0
        while i<len(splitLines) and len(splitLines[i]) - splitLines[i].count(" ")<3:
            i+=1
        copy = splitLines[i:]
        firstLine = copy[0]
        count = 0
        for char in firstLine:
            if char==" ":
                count+=1
            else:
                break
        for i in range(len(copy)):
            copy[i] = copy[i][count:]
        return copy
    
    @staticmethod 
    def splitCoding(codes):
        if not "*#" in codes and not "#*" in codes:
            codesLines = []
            for code in codes:
                lines = code.split("\n")
                lines = CodesExtractor.removeSpaces(lines)
                codesLines.append(lines)
            return codesLines
        else:
            raise OSError("W przetworzonym przez extractCoding kodzie znaleziono znaki kodujace (*# i #*).")
        
    @staticmethod
    def extractCoding(code):
        codeCpy = code
        if codeCpy.count("*#") == codeCpy.count("#*") and codeCpy.count("*#")>0:
            numberOfCodings = codeCpy.count("*#")
            codes = []
            for i in range (numberOfCodings):
                startIdx = codeCpy.find("*#")
                endIdx = codeCpy.find("#*")
                tempCode = codeCpy[startIdx+2:endIdx]
                codes.append(tempCode)
                codeCpy = codeCpy[endIdx+2:]
            codes = CodesExtractor.splitCoding(codes)
            return codes
        else:
            raise OSError("Plik ze ścieżki " + dir + " jest źle okodowany lub w części uzytkowej wystąpily znaki kodujące (*# i #*).")
        

class CodeAnalyser:
    @staticmethod
    def getAllInfo(dir):
        code = FileManager.loadHTML(dir)
        codesAndLines = CodesExtractor.extractCoding(code)
        for codes in codesAndLines:
            CodeAnalyser.checkLines(codes)
    
    @staticmethod
    def checkForFlags(line):
        tab = 0
        for char in line:
            if char==" ":
                tab+=1
            else:
                break
        if tab+3>=len(line):
            return "-"
        flagList = {"fill-template" : "MetaCoder.fillTemplate"}
        for flag in flagList:
            if flag in line:
                words = line.split()
                line = tab*" " + flagList[flag] + "("
                for key in words:
                    line += key + ", "
                line = line[:-2] + ")"
            return(line + "\n")


    @staticmethod
    def checkLines(lines):
        code = ""
        for line in lines:
            code += CodeAnalyser.checkForFlags(line)
        if code[-1]=="-":
            code = code[:-2]
        print(code)




CodeAnalyser.getAllInfo("C:\\Users\\kamil\\Documents\\projekty\\nieskonczone\\Python\\HTML-Updater\\template\\main\\index.html")