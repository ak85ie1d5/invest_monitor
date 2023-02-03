from django.db import models

class Status(models.Model):
    label = models.CharField(max_length=10)
    direction = models.CharField(max_length=10)
    created_at = models.DateTimeField('date published')

class Product(models.Model):
    rtl_quote_url = models.URLField()
    recommandation = models.URLField()
    unit_cost = models.FloatField()
    quantity = models.IntegerField(default=0)
    created_at = models.DateTimeField('date published')

class Underlying(models.Model):
    name = models.CharField(max_length=(30))
    rtl_quote_url = models.URLField()
    objectif = models.FloatField()
    stop = models.FloatField()
    created_at = models.DateTimeField('date published')