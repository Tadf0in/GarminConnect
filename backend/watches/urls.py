from django.urls import path
from . import views

urlpatterns = [
    # User
    path('users/', views.UserListCreateView.as_view(), name='user-list'),
    path('users/<int:pk>/', views.UserDetailView.as_view(), name='user-detail'),

    # Profile
    path('profiles/', views.ProfileListCreateView.as_view(), name='profile-list'),
    path('profiles/<int:pk>/', views.ProfileDetailView.as_view(), name='profile-detail'),

    # Activity Type
    path('activity-types/', views.ActivityTypeListCreateView.as_view(), name='activitytype-list'),
    path('activity-types/<int:pk>/', views.ActivityTypeDetailView.as_view(), name='activitytype-detail'),

    # Activity
    path('activities/', views.ActivityListCreateView.as_view(), name='activity-list'),
    path('activities/<int:pk>/', views.ActivityDetailView.as_view(), name='activity-detail'),

    # Measure Type
    path('measure-types/', views.MeasureTypeListCreateView.as_view(), name='measuretype-list'),
    path('measure-types/<int:pk>/', views.MeasureTypeDetailView.as_view(), name='measuretype-detail'),

    # Measure
    path('measures/', views.MeasureListCreateView.as_view(), name='measure-list'),
    path('measures/<int:pk>/', views.MeasureDetailView.as_view(), name='measure-detail'),

    # Passive Measure
    path('passive-measures/', views.PassiveMeasureListCreateView.as_view(), name='passivemeasure-list'),
    path('passive-measures/<int:pk>/', views.PassiveMeasureDetailView.as_view(), name='passivemeasure-detail'),
]
