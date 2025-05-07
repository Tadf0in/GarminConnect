from rest_framework.permissions import BasePermission

ENSEIGNANT_METHODS = ['GET', 'POST', 'PUT', 'PATCH', 'HEAD', 'OPTIONS']
ETUDIANT_METHODS = ['GET', 'POST', 'HEAD', 'OPTIONS']

class IsTeacherOrOwnObjectOrAdmin(BasePermission):
    """
    Permission personnalisée :
    - Les enseignants peuvent accéder à toutes les vues.
    - Les étudiants ne peuvent accéder qu'à leurs propres objets
    """

    def has_object_permission(self, request, view, obj):
        # Admin autorisé
        if request.user.is_superuser:
            return True
        
        # Prof autorisé
        if request.user.groups.filter(name='Enseignant').exists():
            return request.method in ENSEIGNANT_METHODS

        # Etudiant autorisé si lui appartient
        if request.user.groups.filter(name='Etudiant').exists():
            if hasattr(obj, 'user'):
                if obj.user == request.user:
                    return request.method in ETUDIANT_METHODS
            elif hasattr(obj, 'activity'):
                if obj.activity.user == request.user:
                    return request.method in ETUDIANT_METHODS
        
        # Autre pas autorisé
        return False