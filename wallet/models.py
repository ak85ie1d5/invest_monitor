from django.db import models
import requests
import json
import datetime
import pytz

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
    name = models.CharField(max_length=30)
    memonic_code = models.CharField(max_length=20)
    rtl_quote_url = models.URLField()
    created_at = models.DateTimeField(auto_now_add=True)
    updated_at = models.DateTimeField(auto_now=True)
    
    def __str__(self):
        return self.name

class Currency(models.Model):
    name = models.CharField(max_length=3)
    
    def __str__(self):
        return self.name
    
class Product(models.Model):
    name = models.CharField(max_length=20)
    rtl_quote_url = models.URLField()
    recommandation = models.URLField()
    unit_cost = models.FloatField()
    currency = models.ForeignKey(Currency, on_delete=models.CASCADE)
    quantity = models.IntegerField(default=0)
    objectif = models.FloatField(default=0)
    stop = models.FloatField(default=0)
    direction = models.ForeignKey(Direction, on_delete=models.CASCADE)
    status = models.ForeignKey(Status, on_delete=models.CASCADE)
    underlying = models.ForeignKey(Underlying, on_delete=models.CASCADE)
    created_at = models.DateTimeField(auto_now_add=True)
    updated_at = models.DateTimeField(auto_now=True)
    
    @property
    def underlying_name(self):
        return self.underlying.name if self.underlying else None

    @property
    def underlying_rtl_quote_url(self):
        return self.underlying.rtl_quote_url if self.underlying else None

    @property
    def get_rtl_quote(self):
        now = datetime.datetime.now(pytz.timezone('Europe/Paris'))
        unix_timestamp = str(int(now.timestamp()))
        response = requests.get('https://www.boursedirect.fr/api/tradingview/history?symbol=XPAR:'+self.underlying.memonic_code+'&resolution=1D&from='+unix_timestamp+'&to='+unix_timestamp+'&currencyCode='+self.currency.name)
        quote_data = json.loads(response.text)

        #return quote_data['c'][0]
        return quote_data
    
    def __str__(self):
        return self.name
