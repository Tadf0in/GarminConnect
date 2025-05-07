from django.urls import include, path
from rest_framework import permissions, routers
from . import views
from rest_framework_simplejwt.views import TokenObtainPairView, TokenRefreshView
from drf_yasg.views import get_schema_view
from drf_yasg import openapi

router = routers.SimpleRouter()
router.register('user', views.UserViewSet, basename='user')
router.register('profile', views.ProfileViewSet, basename='profile')
router.register('activity-type', views.ActivityTypeViewSet, basename='activitytype')
router.register('activity', views.ActivityViewSet, basename='activity')
router.register('measure-type', views.MeasureTypeViewSet, basename='measuretype')
router.register('measure', views.MeasureViewSet, basename='measure')
router.register('passive-measure', views.PassiveMeasureViewSet, basename='passivemeasure')
 
schema_view = get_schema_view(openapi.Info(
      title="API",
      default_version='v1',
      description="Documentation de l'API",
   ),
    public=True,
    permission_classes=[permissions.AllowAny],
)

urlpatterns = [
    # path('api-auth/', include('rest_framework.urls')),
    path('docs/', schema_view.with_ui('swagger', cache_timeout=0), name='schema-swagger-ui'),
    
    path('token/', TokenObtainPairView.as_view(), name='token_obtain_pair'),
    path('token/refresh/', TokenRefreshView.as_view(), name='token_refresh'),
    path('', include(router.urls))
]