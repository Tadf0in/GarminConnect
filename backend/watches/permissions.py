from rest_framework.permissions import BasePermission


class IsTeacherOrOwnObjectOrAdmin(BasePermission):
    """
    Permission personnalisée :
    - Les enseignants peuvent accéder à toutes les vues.
    - Les étudiants ne peuvent accéder qu'à leurs propres objets
    """

    def has_permission(self, request, view):
        # Admin autorisé
        if request.user.is_superuser:
            return True
        
        # Prof autorisé
        if request.user.groups.filter(name='Enseignant').exists():
            return True
        
        # Autre pas autorisé
        return False


    def has_object_permission(self, request, view, obj):
        # Admin autorisé
        if request.user.is_superuser:
            return True
        
        # Prof autorisé
        if request.user.groups.filter(name='Enseignant').exists():
            return True

        # Etudiant autorisé si lui appartient
        if request.user.groups.filter(name='Etudiant').exists():
            return True
            print('etuuuuuuuuuuuuuuuu')
            if hasattr(obj, 'user'):
                if obj.user == request.user:
                    return True
        
        # Autre pas autorisé
        return False