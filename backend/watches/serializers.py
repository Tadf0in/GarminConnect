from rest_framework import serializers
from .models import User, Profile, ActivityType, Activity, MeasureType, Measure, PassiveMeasure

class UserSerializer(serializers.ModelSerializer):
    class Meta:
        model = User
        fields = '__all__' # ['id', 'email', 'is_staff', 'is_active']


class ProfileSerializer(serializers.ModelSerializer):
    class Meta:
        model = Profile
        fields = '__all__'


class ActivityTypeSerializer(serializers.ModelSerializer):
    class Meta:
        model = ActivityType
        fields = '__all__'


class ActivitySerializer(serializers.ModelSerializer):
    class Meta:
        model = Activity
        fields = '__all__'


class MeasureTypeSerializer(serializers.ModelSerializer):
    class Meta:
        model = MeasureType
        fields = '__all__'


class MeasureSerializer(serializers.ModelSerializer):
    class Meta:
        model = Measure
        fields = '__all__'


class PassiveMeasureSerializer(serializers.ModelSerializer):
    class Meta:
        model = PassiveMeasure
        fields = '__all__'
