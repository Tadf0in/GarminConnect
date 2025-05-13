from django.db import models
from django.contrib.auth.models import AbstractUser, Group, Permission
from .managers import UserManager


class User(AbstractUser):
    username = None
    email = models.EmailField(unique=True, max_length=200)
    USERNAME_FIELD = "email"
    REQUIRED_FIELDS = []

    groups = models.ManyToManyField(Group, related_name="custom_user_set", blank=True)
    user_permissions = models.ManyToManyField(Permission, related_name="custom_user_permissions", blank=True)
    objects = UserManager()

    def __str__(self):
        return f"{self.last_name} {self.first_name} ({self.email})"
    

class Profile(models.Model):
    email = models.EmailField()
    password = models.CharField(max_length=200)
    last_update = models.DateTimeField()
    brand = models.CharField(max_length=20, choices=[
        ('Garmin', 'Garmin'),
        ('Withings', 'Withings'),
        # ('Coros', 'Coros'),
        # ('Amazfit', 'Amazfit'),
        # ('Apple', 'Apple'),
        ('Autre', 'Autre'),
    ])
    user = models.ForeignKey(User, on_delete=models.CASCADE)
    code = models.CharField(max_length=200)
    token = models.CharField(max_length=200)
    client_id = models.CharField(max_length=200)
    client_secret = models.CharField(max_length=200)


class ActivityType(models.Model):
    name = models.CharField(max_length=200)

    def __str__(self):
        return self.name


class Activity(models.Model):
    name = models.CharField(max_length=200)
    start = models.DateTimeField()
    duration = models.DurationField()
    type = models.ForeignKey(ActivityType, null=True, on_delete=models.SET_NULL)
    location = models.CharField(max_length=200)
    user = models.ForeignKey(User, on_delete=models.CASCADE)
    activity_manufacturer_id = models.IntegerField()
    manufacturer = models.CharField(max_length=200)


class MeasureType(models.Model):
    unite = models.CharField(max_length=200)
    name = models.CharField(max_length=200)


class Measure(models.Model):
    activity = models.ForeignKey(Activity, on_delete=models.CASCADE)
    type = models.ForeignKey(MeasureType, null=True, on_delete=models.SET_NULL)
    value = models.CharField(max_length=20)


class PassiveMeasure(models.Model):
    instant = models.DateTimeField()
    value = models.SmallIntegerField()
    user = models.ForeignKey(User, on_delete=models.CASCADE)
    type = models.ForeignKey(MeasureType, null=True, on_delete=models.SET_NULL)

