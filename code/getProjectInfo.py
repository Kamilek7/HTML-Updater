from constants import *

class Projects:

    @staticmethod
    def getProjectPaths():
        folders = next(walk(MAIN_PROJECT_DIR))[1]
        folderNames = folders
        while len(folders)>0 and not "imagesForGallery" in folderNames:
            temp = []
            for folder in folders:
                temp1 = next(walk(join(MAIN_PROJECT_DIR, folder)))[1]
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

    def getProjectData():
        projects = Projects.getProjectPaths()
        for project in projects:
            imageFolderPath = join(MAIN_PROJECT_DIR, projects[project], "imagesForGallery")
            images = listdir(imageFolderPath)
            descriptionPath = join(MAIN_PROJECT_DIR, projects[project], "README.md")
            print(descriptionPath)
            file = open(descriptionPath,'r')
            description = file.read()
            file.close()
            projects[project] = {"images" : images, "description": description}
        return projects
print(Projects.getProjectData())