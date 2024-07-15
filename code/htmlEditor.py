class htmlEdit:
    def __init__(self):
        pass



    def loadHTML(self):
        file = open(self.mainDir, "r")
        self.main = file.read()
        self.template = open(self.templateDir, "r")

    def fillTemplate(self):
        pass