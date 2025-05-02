from django.urls import include, path
from rest_framework import routers
from . import views

router = routers.SimpleRouter()
router.register('user', views.UserViewSet, basename='user')
router.register('profile', views.ProfileViewSet, basename='profile')
router.register('activity-type', views.ActivityTypeViewSet, basename='activitytype')
router.register('activity', views.ActivityViewSet, basename='activity')
router.register('measure-type', views.MeasureTypeViewSet, basename='measuretype')
router.register('measure', views.MeasureViewSet, basename='measure')
router.register('passive-measure', views.PassiveMeasureViewSet, basename='passivemeasure')
 
urlpatterns = [
    path('api-auth/', include('rest_framework.urls')),
    path('api/', include(router.urls))
]