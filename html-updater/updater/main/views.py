from django.template import loader
from django.http import HttpResponse

def main(request):
    template = loader.get_template('test.html')
    return HttpResponse(template.render())