from constants import *
from fileLoader import *
class MetaCoder:
    def fillTemplate(source, file):
        filename = source + ".html"
        sourceDir = join(THIS_DIR, "template", "additions", filename)
        code = FileManager.loadHTML(sourceDir)