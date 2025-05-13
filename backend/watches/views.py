from rest_framework.viewsets import ModelViewSet
from rest_framework.permissions import IsAuthenticated
from .models import *
from .serializers import *
from .permissions import IsTeacherOrOwnObjectOrAdmin

class UserViewSet(ModelViewSet):
    serializer_class = UserSerializer
    permission_classes = [IsAuthenticated, IsTeacherOrOwnObjectOrAdmin]

    def get_queryset(self):
        if self.request.user.is_superuser or self.request.user.groups.filter(name='Enseignant').exists():
            return User.objects.all()
        return User.objects.filter(id=self.request.user.id)

class ProfileViewSet(ModelViewSet):
    serializer_class = ProfileSerializer
    permission_classes = [IsAuthenticated, IsTeacherOrOwnObjectOrAdmin]

    def get_queryset(self):
        if self.request.user.is_superuser or self.request.user.groups.filter(name='Enseignant').exists():
            return Profile.objects.all()
        return Profile.objects.filter(user=self.request.user)

class ActivityTypeViewSet(ModelViewSet):
    serializer_class = ActivityTypeSerializer
    permission_classes = [IsAuthenticated, IsTeacherOrOwnObjectOrAdmin]

    def get_queryset(self):
        return ActivityType.objects.all()

class ActivityViewSet(ModelViewSet):
    serializer_class = ActivitySerializer
    permission_classes = [IsAuthenticated, IsTeacherOrOwnObjectOrAdmin]

    def get_queryset(self):
        if self.request.user.is_superuser or self.request.user.groups.filter(name='Enseignant').exists():
            return Activity.objects.all()
        return Activity.objects.filter(user=self.request.user)

class MeasureTypeViewSet(ModelViewSet):
    serializer_class = MeasureTypeSerializer
    permission_classes = [IsAuthenticated, IsTeacherOrOwnObjectOrAdmin]

    def get_queryset(self):
        return MeasureType.objects.all()

class MeasureViewSet(ModelViewSet):
    serializer_class = MeasureSerializer
    permission_classes = [IsAuthenticated, IsTeacherOrOwnObjectOrAdmin]

    def get_queryset(self):
        if self.request.user.is_superuser or self.request.user.groups.filter(name='Enseignant').exists():
            return Measure.objects.all()
        return Measure.objects.filter(activity__user=self.request.user)

class PassiveMeasureViewSet(ModelViewSet):
    serializer_class = PassiveMeasureSerializer
    permission_classes = [IsAuthenticated, IsTeacherOrOwnObjectOrAdmin]

    def get_queryset(self):
        if self.request.user.is_superuser or self.request.user.groups.filter(name='Enseignant').exists():
            return PassiveMeasure.objects.all()
        return PassiveMeasure.objects.filter(user=self.request.user)