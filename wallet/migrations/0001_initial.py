# Generated by Django 4.1.6 on 2023-02-02 16:58

from django.db import migrations, models


class Migration(migrations.Migration):

    initial = True

    dependencies = []

    operations = [
        migrations.CreateModel(
            name="Product",
            fields=[
                (
                    "id",
                    models.BigAutoField(
                        auto_created=True,
                        primary_key=True,
                        serialize=False,
                        verbose_name="ID",
                    ),
                ),
                ("rtl_quote_url", models.URLField()),
                ("recommandation", models.URLField()),
                ("unit_cost", models.FloatField()),
                ("quantity", models.IntegerField(default=0)),
                ("created_at", models.DateTimeField(verbose_name="date published")),
            ],
        ),
        migrations.CreateModel(
            name="Status",
            fields=[
                (
                    "id",
                    models.BigAutoField(
                        auto_created=True,
                        primary_key=True,
                        serialize=False,
                        verbose_name="ID",
                    ),
                ),
                ("label", models.CharField(max_length=10)),
                ("direction", models.CharField(max_length=10)),
                ("created_at", models.DateTimeField(verbose_name="date published")),
            ],
        ),
        migrations.CreateModel(
            name="Underlying",
            fields=[
                (
                    "id",
                    models.BigAutoField(
                        auto_created=True,
                        primary_key=True,
                        serialize=False,
                        verbose_name="ID",
                    ),
                ),
                ("name", models.CharField(max_length=30)),
                ("rtl_quote_url", models.URLField()),
                ("objectif", models.FloatField()),
                ("stop", models.FloatField()),
                ("created_at", models.DateTimeField(verbose_name="date published")),
            ],
        ),
    ]
