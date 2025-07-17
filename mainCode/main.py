import json, os, shutil
from datetime import datetime

PYTHON_DIR = os.path.dirname(os.path.abspath(__file__))
MAIN_DIR =  os.path.dirname(PYTHON_DIR)
TEMPLATE_DIR = os.path.join(MAIN_DIR, "template")
OUTPUT_DIR = os.path.join(MAIN_DIR, "output")
SETTINGS_FILE = "loadedSettings.json"
MEM_FILE = "currentState.json"
CONFIG = "config.json"
htmlData = ""

with open(os.path.join(TEMPLATE_DIR, "index.html"), 'r') as html:
    htmlData = html.read()

class TimeRow:
    def __init__(self, year):
        self.year = year
    
    def getCode(self):
        return f"<div class='yearRow'><div>{self.year}</div><div>{self.year}</div></div>\n"
    
class Project:
    def __init__(self, name, langs, images, url):
        self.name = name
        self.langs = langs
        self.images = images
        self.url = url
    
    def getCode(self):
        return f"<div class='project'><img src='{self.images[0]}'><div class='projectTitle'><a href='{self.url}' target='_blank'>{self.name}</a></div></div>\n"

data = ""
with open(os.path.join(TEMPLATE_DIR, SETTINGS_FILE)) as json_data:
    data = json_data.read()

memory = ""
with open(os.path.join(OUTPUT_DIR, MEM_FILE)) as json_data:
    memory = json_data.read()

if data!=memory:
    # with open(os.path.join(OUTPUT_DIR, MEM_FILE), 'w') as output:
    #     output.write(data)
    data = json.loads(data)
    conf = ""
    with open (os.path.join(MAIN_DIR, CONFIG)) as cnfg:
        conf = cnfg.read()
        conf = json.loads(conf)
    repos = []
    def sorter(el):
        confs = conf["projectData"]
        for exc in confs:
            if el["name"]==exc["name"]:
                for sets in exc.keys():
                    el[sets] = exc[sets]
                break
        return datetime.strptime((el["createdAt"]), "%Y-%m-%dT%H:%M:%SZ")
    data.sort(key=sorter)

    divs = []
    crntDate =""

    for repo in data:
        repo["createdAt"] = repo["createdAt"][:4]
        if crntDate!= repo["createdAt"]:
            crntDate= repo["createdAt"]
            divs.append(TimeRow(crntDate))
        if repo["images"] != "":
            repo["images"] = repo["images"].split("\n")
        else:
            repo["images"] = ["none"]
        numLang = len(repo["languages"])
        repo["languages"] = [lang["node"]["name"] for lang in repo["languages"]]
        repo["name"] = repo["name"].replace("-", " ")
        if numLang>3:
            repo["languages"] = repo["languages"][:3]
        divs.append(Project(repo["name"], repo["languages"], repo["images"], repo["url"]))
    
    projectCode = ""
    for div in divs:
        projectCode += div.getCode()
    htmlData = htmlData.replace("{PROJECT DATA}", projectCode)

    files = ["main.js", "styles.css"]
    for file in files:
        pathToFile = os.path.join(OUTPUT_DIR, file)
        pathCopy = os.path.join(TEMPLATE_DIR, file)
        if os.path.isfile(pathToFile):
            os.remove(pathToFile)
        shutil.copyfile(pathCopy, pathToFile)

    with open(os.path.join(OUTPUT_DIR, "index.html"), "w") as output:
        output.write(htmlData)
else:
    print("Brak zmian!")