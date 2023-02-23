from django.shortcuts import render
from .models import Product
from .models import Underlying

def index(request):
    product_list = Product.objects.order_by('name')
    underlying_list = Underlying.objects.order_by('name')
    context = {
        'product_list': product_list,
        'underlying_list': underlying_list
    }
    return render(request, 'wallet/index.html', context)
