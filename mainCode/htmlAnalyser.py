from htmlLoader import *
class CodesExtractor:

    @staticmethod
    def analyzeCoding(codes):
        if not "*#" in codes and not "#*" in codes:
            codesD = []
            for code in codes:
                codesD.append(code.split())
            return codesD
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
                codeCpy = codeCpy[endIdx+2:-1]
            codes = CodesExtractor.analyzeCoding(codes)
            return codes
        else:
            raise OSError("Plik ze ścieżki " + dir + " jest źle okodowany lub w części uzytkowej wystąpily znaki kodujące (*# i #*).")
        

class HtmlAnalyser:
    @staticmethod
    def getAllInfo(dir):
        code = FileManager.loadHTML(dir)
        codes = CodesExtractor.extractCoding(code)
        for section in codes:
            fileName = section[0] + ".html"
            mode = section[1]
            pathToFile = join(THIS_DIR, "template", "additions", fileName)
            newCode = FileManager.loadHTML(pathToFile)
            newCodes = CodesExtractor.extractCoding(newCode)
            print(newCodes)
        

HtmlAnalyser.getAllInfo("C:\\Users\\kamil\\Documents\\projekty\\nieskonczone\\Python\\HTML-Updater\\template\\main\\index.html")