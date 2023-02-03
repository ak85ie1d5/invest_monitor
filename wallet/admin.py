from django.contrib import admin

from .models import Direction, Status, Product, Underlying

admin.site.register(Direction)
admin.site.register(Status)
admin.site.register(Product)
admin.site.register(Underlying)
