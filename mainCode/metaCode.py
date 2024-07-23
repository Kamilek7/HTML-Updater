from constants import *
from templateManager import *
class MetaCoder:
    def fillTemplate(source, file):
        filename = source + ".html"
        sourceDir = join(TEMPLATE_DIR, "additions", filename)
        code = loadFile(sourceDir)
        code = TemplateManager.fillTemplate(code, file)
        return code