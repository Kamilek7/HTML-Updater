from getProjectInfo import *
class TemplateManager:
    def fillTemplate(code, file):
        flags = {"*#imagesForGallery#*": "images", "*#GITHUB#*" : "link"}
        PROJECTS[file]["link"] = "https://github.com/Kamilek7/" + file 
        if PROJECTS[file]["html"]:
            PROJECTS[file]["link"] = join(file, "index.html")
        for flag in flags:
            info = PROJECTS[file][flags[flag]]
            num = code.count(flag)
            for i in range (num):
                if isinstance(info, list):
                    code = code.replace(flag, info[i])
                else:
                    code = code.replace(flag, info)
        return code