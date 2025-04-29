from django.contrib import admin
from django.contrib.auth.admin import UserAdmin as BaseUserAdmin
from django.contrib.auth.models import Group, Permission
from django.utils.translation import gettext_lazy as _

from .models import (
    User,
    Profile,
    ActivityType,
    Activity,
    MeasureType,
    Measure,
    PassiveMeasure
)
from .forms import CustomUserCreationForm, CustomUserChangeForm

@admin.register(User)
class UserAdmin(BaseUserAdmin):
    add_form = CustomUserCreationForm
    form = CustomUserChangeForm
    model = User

    list_display = ("email", "last_name", "first_name", "is_staff")
    list_filter = ("is_staff", "is_active", "groups")
    search_fields = ("email", "first_name", "last_name")
    ordering = ("last_name", "first_name")

    fieldsets = (
        (None, {"fields": ("last_name", "first_name", "email", "password")}),
        ("Permissions", {"fields": ("is_staff", "is_active", "is_superuser", "groups")}),
        ("Dates importantes", {"fields": ("last_login", "date_joined")}),
    )
    add_fieldsets = (
        (None, {"fields": ("last_name", "first_name", "email", "password1", "password2")}),
    )


@admin.register(Profile)
class ProfileAdmin(admin.ModelAdmin):
    list_display = ("email", "brand", "last_update", "user")
    search_fields = ("email", "brand", "user")
    list_filter = ("brand", "last_update")


@admin.register(ActivityType)
class ActivityTypeAdmin(admin.ModelAdmin):
    list_display = ("name",)
    search_fields = ("name",)


@admin.register(Activity)
class ActivityAdmin(admin.ModelAdmin):
    list_display = ("name", "user", "start", "duration", "type",)
    search_fields = ("name", "location", "user",)
    list_filter = ("type", "manufacturer", "start",)


@admin.register(MeasureType)
class MeasureTypeAdmin(admin.ModelAdmin):
    list_display = ("name", "unite")
    search_fields = ("name",)
    list_filter = ("unite",)


@admin.register(Measure)
class MeasureAdmin(admin.ModelAdmin):
    list_display = ("activity", "type", "value")
    search_fields = ("value", "activity")
    list_filter = ("type",)


@admin.register(PassiveMeasure)
class PassiveMeasureAdmin(admin.ModelAdmin):
    list_display = ("instant", "value", "type", "user")
    search_fields = ("user",)
    list_filter = ("type", "instant")
