from constants import *
from fileLoader import *
from templateManager import *
class MetaCoder:
    def fillTemplate(source, file):
        filename = source + ".html"
        sourceDir = join(THIS_DIR, "template", "additions", filename)
        code = FileManager.loadHTML(sourceDir)
        code = TemplateManager.fillTemplate(code, file)
        return code