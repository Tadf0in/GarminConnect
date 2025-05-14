from rest_framework import status
from rest_framework.permissions import IsAuthenticated
from rest_framework.response import Response
from rest_framework.views import APIView
from rest_framework.viewsets import ModelViewSet

from garminconnect import Garmin
from datetime import datetime, timedelta

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
    


class RefreshProfileView(APIView):
    permission_classes = [IsAuthenticated]

    def _add_mesure(type_name, unite, activity, data):
        measure_type, _ = MeasureType.objects.get_or_create(name=type_name, unite=unite)
        Measure.objects.create(activity=activity, type=measure_type, value=data)


    def post(self, request, id_profile):
        try:
            profile = Profile.objects.get(id=id_profile)
            if profile.user != request.user and not (request.user.is_superuser or request.user.groups.filter(name='Enseignant').exists()):
                return Response({"detail": "Not authorized to refresh this profile."}, status=status.HTTP_403_FORBIDDEN)

            if profile.brand == 'Garmin':
                client = Garmin(email=profile.email, password=profile.password)
                client.login()

                start = profile.last_update
                end = datetime.now()
                activities = client.get_activities_by_date(
                    startdate=start.strftime('%Y-%m-%d'), 
                    enddate=end.strftime('%Y-%m-%d')
                )

                for activity_data in activities:
                    # Si l'activité existe déjà on la skip (ca devrait pas arriver en prod mais pour je laisse pour tester)
                    if Activity.objects.filter(activity_manufacturer_id=activity_data["activityId"]).exists():
                        continue

                    # Données générales de l'activité
                    activity = Activity(
                        name=activity_data["activityName"],
                        start=activity_data["startTimeLocal"],
                        duration=timedelta(seconds=activity_data["duration"]),
                        location=activity_data.get("locationName", None),
                        user=profile.user,
                        activity_manufacturer_id=activity_data["activityId"],
                        manufacturer="Garmin",
                        calories=activity_data["calories"],
                        maxHR=activity_data["maxHR"],
                        averageHR=activity_data["maxHR"]
                    )
                    activity.type, _ = ActivityType.objects.get_or_create(name=activity_data["activityType"]["typeKey"])
                    activity.save()
  
                    # Données spécifiques
                    if activity.type.name == 'running':
                        self._add_mesure("Distance", "km", activity, activity_data["distance"])
                        self._add_mesure("Nombre de pas", "pas", activity, activity_data["steps"])
                        self._add_mesure("Dénivelé positif", "m", activity, activity_data["elevationGain"])
                        self._add_mesure("Dénivelé négatif", "m", activity, activity_data["elevationLoss"])
                        self._add_mesure("Vitesse moyenne", "km/h", activity, activity_data["maxSpeed"])
                        self._add_mesure("Vitesse max", "km/h", activity, activity_data["averageSpeed"])
                        
                    elif activity.type.name == 'strength_training':
                        pass

            elif profile.brand == 'Withings':
                # à l'autre groupe de faire
                pass
            
            profile.last_update = datetime.now()
            profile.save()

            return Response({"detail": "Profile data refreshed successfully."}, status=status.HTTP_200_OK)
        except Profile.DoesNotExist:
            return Response({"detail": "Profile not found."}, status=status.HTTP_404_NOT_FOUND)
        except Exception as e:
            import traceback
            traceback.print_exc()
            return Response({"detail": str(e)}, status=status.HTTP_500_INTERNAL_SERVER_ERROR)