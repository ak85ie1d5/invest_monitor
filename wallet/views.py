from django.http import HttpResponse
from .models import Product

def index(request):
    product_list = Product.objects.order_by('name')
    output = ', '.join([p.name for p in product_list])
    return HttpResponse(output)
