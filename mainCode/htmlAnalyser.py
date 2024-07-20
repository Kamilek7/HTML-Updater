from htmlLoader import *
class HtmlAnalyser:
    @staticmethod
    def extractCoding(code):
        codeCpy = code
        if code.count("*#") == codeCpy.count("#*") and codeCpy.count("*#")>0:
            numberOfCodings = codeCpy.count("*#")
            codes = []
            for i in range (numberOfCodings):
                startIdx = codeCpy.find("*#")
                endIdx = codeCpy.find("#*")
                tempCode = codeCpy[startIdx+2:endIdx-2]
                codes.append(tempCode)
            return codes
        else:
            raise OSError("Plik ze ścieżki " + dir + " jest źle okodowany lub w części uzytkowej wystąpily znaki kodujące (*# i #*).")
        
    def analyzeCoding(codes):
        if not "*#" in codes and not "#*" in codes:
            codesD = []
            for code in codes:
                codesD.append(code.split())
            return codesD
        else:
            raise OSError("W przetworzonym przez extractCoding kodzie znaleziono znaki kodujace (*# i #*).")
    
    @staticmethod
    def getHTMLInfo(dir):
        code = FileManager.loadHTML(dir)
