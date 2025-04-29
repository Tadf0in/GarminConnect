from rest_framework import generics
from .models import User, Profile, ActivityType, Activity, MeasureType, Measure, PassiveMeasure
from .serializers import (
    UserSerializer, ProfileSerializer, ActivityTypeSerializer, ActivitySerializer,
    MeasureTypeSerializer, MeasureSerializer, PassiveMeasureSerializer
)

# --- USER ---
class UserListCreateView(generics.ListCreateAPIView):
    queryset = User.objects.all()
    serializer_class = UserSerializer

class UserDetailView(generics.RetrieveAPIView):
    queryset = User.objects.all()
    serializer_class = UserSerializer


# --- PROFILE ---
class ProfileListCreateView(generics.ListCreateAPIView):
    queryset = Profile.objects.all()
    serializer_class = ProfileSerializer

class ProfileDetailView(generics.RetrieveAPIView):
    queryset = Profile.objects.all()
    serializer_class = ProfileSerializer


# --- ACTIVITY TYPE ---
class ActivityTypeListCreateView(generics.ListCreateAPIView):
    queryset = ActivityType.objects.all()
    serializer_class = ActivityTypeSerializer

class ActivityTypeDetailView(generics.RetrieveAPIView):
    queryset = ActivityType.objects.all()
    serializer_class = ActivityTypeSerializer


# --- ACTIVITY ---
class ActivityListCreateView(generics.ListCreateAPIView):
    queryset = Activity.objects.all()
    serializer_class = ActivitySerializer

class ActivityDetailView(generics.RetrieveAPIView):
    queryset = Activity.objects.all()
    serializer_class = ActivitySerializer


# --- MEASURE TYPE ---
class MeasureTypeListCreateView(generics.ListCreateAPIView):
    queryset = MeasureType.objects.all()
    serializer_class = MeasureTypeSerializer

class MeasureTypeDetailView(generics.RetrieveAPIView):
    queryset = MeasureType.objects.all()
    serializer_class = MeasureTypeSerializer


# --- MEASURE ---
class MeasureListCreateView(generics.ListCreateAPIView):
    queryset = Measure.objects.all()
    serializer_class = MeasureSerializer

class MeasureDetailView(generics.RetrieveAPIView):
    queryset = Measure.objects.all()
    serializer_class = MeasureSerializer


# --- PASSIVE MEASURE ---
class PassiveMeasureListCreateView(generics.ListCreateAPIView):
    queryset = PassiveMeasure.objects.all()
    serializer_class = PassiveMeasureSerializer

class PassiveMeasureDetailView(generics.RetrieveAPIView):
    queryset = PassiveMeasure.objects.all()
    serializer_class = PassiveMeasureSerializer
