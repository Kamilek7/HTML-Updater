from metaCode import *
from getProjectInfo import *

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
    def checkForFlags(line):
        tab = 0
        for char in line:
            if char==" ":
                tab+=1
            else:
                break
        if tab+3>=len(line):
            return "-"
        flags = ["fill-template", "get"]
        flagList = {"fill-template" : "MetaCoder.fillTemplate"}
        lineTemp = ""
        flagCount = 0
        for flag in flags:
            if flag in line:
                flagCount+=1
        for flag in flagList:
            if flag in line:
                words = line.split()
                lineTemp += flagList[flag] + "("
                for key in words[flagCount:]:
                    lineTemp += key + ", "
                lineTemp = lineTemp[:-2] + ")"
            else:
                lineTemp = line
        if "get" in line:
            lineTemp = "results.append(" + lineTemp + ")"
        lineTemp = tab*" " + lineTemp
        return(lineTemp + "\n")


    @staticmethod
    def checkLines(lines):
        code = ""
        for line in lines:
            code += CodeAnalyser.checkForFlags(line)
        if code[-1]=="-":
            code = code[:-2]
        results = []
        exec(code)
        return(results)

    def getNewHTML(lines, code):
        results = CodeAnalyser.checkLines(lines)
        temp = ""
        codeTemp = code
        for line in lines:
            codeTemp = codeTemp.replace(line, "")
        for i in results:
            temp+= i
        codeTemp = codeTemp.replace("*#", temp)
        codeTemp = codeTemp.replace("#*", "")
        return codeTemp
