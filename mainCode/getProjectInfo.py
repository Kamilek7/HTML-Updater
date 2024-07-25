from constants import *

class Projects:

    @staticmethod
    def getProjectPaths():
        folders = next(os.walk(MAIN_PROJECT_DIR))[1]
        folderNames = folders
        while len(folders)>0 and not "imagesForGallery" in folderNames:
            temp = []
            for folder in folders:
                temp1 = next(os.walk(join(MAIN_PROJECT_DIR, folder)))[1]
                for new in temp1:
                    temp.append(join(folder,new))
            folders = temp
            folderNames = []
            for folder in folders:
                folderNames.append(basename(folder))
        folders = [dirname(folder) for folder in folders]
        folders = list(dict.fromkeys(folders))
        projects = {}
        for folder in folders:
            projects[basename(folder)] = folder

        return projects

    @staticmethod
    def getProjectData():
        projects = Projects.getProjectPaths()
        for project in projects:
            imageFolderPath = join(MAIN_PROJECT_DIR, projects[project], "imagesForGallery")
            images = os.listdir(imageFolderPath)
            for i in range(len(images)):
                images[i] = join("images", project, images[i])
            descriptionPath = join(MAIN_PROJECT_DIR, projects[project], "README.md")
            description= "None"
            if isfile(descriptionPath):
                file = open(descriptionPath,'r')
                description = file.read()
                file.close()
            files = os.listdir(join(MAIN_PROJECT_DIR, projects[project]))
            html = False
            for file in files:
                if ".html" in file:
                    html = True
                    break
            projects[project] = {"images" : images, "description": description, "path": projects[project], "html": html}
        return projects
    
PROJECTS = Projects.getProjectData()