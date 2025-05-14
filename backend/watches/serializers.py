from django.contrib.auth.hashers import make_password
from django.contrib.auth.password_validation import validate_password
from rest_framework import serializers
from .models import *

class UserSerializer(serializers.ModelSerializer):
    class Meta:
        model = User
        fields = [field.name for field in User._meta.fields if field.name not in ('is_staff', 'is_superuser', 'is_active')]

    def create(self, validated_data):
        # Hash le mot de passe avant la création
        validated_data['password'] = make_password(validated_data['password'])
        return super().create(validated_data)
    
    def update(self, instance, validated_data):
        # Hash le mot de passe si il est modifié
        if 'password' in validated_data:
            validated_data['password'] = make_password(validated_data['password'])
        return super().update(instance, validated_data)


class ProfileSerializer(serializers.ModelSerializer):
    class Meta:
        model = Profile
        fields = '__all__'


class ActivityTypeSerializer(serializers.ModelSerializer):
    class Meta:
        model = ActivityType
        fields = '__all__'


class MeasureTypeSerializer(serializers.ModelSerializer):
    class Meta:
        model = MeasureType
        fields = '__all__'


class MeasureSerializer(serializers.ModelSerializer):
    type = MeasureTypeSerializer()

    class Meta:
        model = Measure
        fields = '__all__'


class PassiveMeasureSerializer(serializers.ModelSerializer):
    class Meta:
        model = PassiveMeasure
        fields = '__all__'


class ActivitySerializer(serializers.ModelSerializer):
    type = ActivityTypeSerializer()
    measures = serializers.SerializerMethodField()

    class Meta:
        model = Activity
        fields = '__all__'

    def get_measures(self, obj):
        measures = Measure.objects.filter(activity=obj)
        return MeasureSerializer(measures, many=True).data