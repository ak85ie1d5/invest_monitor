from django.contrib import admin

from .models import Status, Product, Underlying

admin.site.register(Status)
admin.site.register(Product)
admin.site.register(Underlying)
