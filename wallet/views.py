from django.shortcuts import render
from .models import Product

def index(request):
    product_list = Product.objects.order_by('name')
    context = {
        'product_list': product_list,
    }
    return render(request, 'wallet/index.html', context)
