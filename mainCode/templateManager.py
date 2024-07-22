from getProjectInfo import *
class TemplateManager:
    def fillTemplate(code, file):
        flags = {"*#imagesForGallery#*": "images", "*#SITE_LINK#*" : "link"}
        PROJECTS[file]["link"] = "https://github.com/Kamilek7/" + file 
        for flag in flags:
            info = PROJECTS[file][flags[flag]]
            num = code.count(flag)
            for i in range (num):
                if isinstance(info, list):
                    code = code.replace(flag, info[i])
                else:
                    code = code.replace(flag, info)
        return code