from django.db import models

class Direction(models.Model):
    label = models.CharField(max_length=10)
    created_at = models.DateTimeField(auto_now_add=True)
    updated_at = models.DateTimeField(auto_now=True)
    
    def __str__(self):
        return self.label

class Status(models.Model):
    label = models.CharField(max_length=10)
    created_at = models.DateTimeField(auto_now_add=True)
    updated_at = models.DateTimeField(auto_now=True)
    
    def __str__(self):
        return self.label

class Underlying(models.Model):
    name = models.CharField(max_length=(30))
    rtl_quote_url = models.URLField()
    created_at = models.DateTimeField(auto_now_add=True)
    updated_at = models.DateTimeField(auto_now=True)
    
    def __str__(self):
        return self.name
    
class Product(models.Model):
    name = models.CharField(max_length=20)
    rtl_quote_url = models.URLField()
    recommandation = models.URLField()
    unit_cost = models.FloatField()
    quantity = models.IntegerField(default=0)
    objectif = models.FloatField(default=0)
    stop = models.FloatField(default=0)
    direction = models.ForeignKey(Direction, on_delete=models.CASCADE)
    status = models.ForeignKey(Status, on_delete=models.CASCADE)
    underlying = models.ForeignKey(Underlying, on_delete=models.CASCADE)
    created_at = models.DateTimeField(auto_now_add=True)
    updated_at = models.DateTimeField(auto_now=True)
    
    def __str__(self):
        return self.name

