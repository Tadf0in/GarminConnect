from rest_framework.viewsets import ModelViewSet

from .models import *
from .serializers import *


class UserViewSet(ModelViewSet):
    serializer_class = UserSerializer

    def get_queryset(self):
        return User.objects.all()


class ProfileViewSet(ModelViewSet):
    serializer_class = ProfileSerializer

    def get_queryset(self):
        return Profile.objects.all()


class ActivityTypeViewSet(ModelViewSet):
    serializer_class = ActivityTypeSerializer

    def get_queryset(self):
        return ActivityType.objects.all()


class ActivityViewSet(ModelViewSet):
    serializer_class = ActivitySerializer

    def get_queryset(self):
        return Activity.objects.all()


class MeasureTypeViewSet(ModelViewSet):
    serializer_class = MeasureTypeSerializer

    def get_queryset(self):
        return MeasureType.objects.all()


class MeasureViewSet(ModelViewSet):
    serializer_class = MeasureSerializer

    def get_queryset(self):
        return Measure.objects.all()


class PassiveMeasureViewSet(ModelViewSet):
    serializer_class = PassiveMeasureSerializer

    def get_queryset(self):
        return PassiveMeasure.objects.all()
