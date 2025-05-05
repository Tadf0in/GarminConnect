class InjectJWTMiddleware:
    """
    Middleware pour injecter un token JWT dans l'interface DRF via le header Authorization.
    """

    def __init__(self, get_response):
        self.get_response = get_response

    def __call__(self, request):
        # Si l'utilisateur n'est pas authentifié et qu'il n'a pas de token,
        # ajouter un token par défaut ou une logique pour générer un token temporaire
        token = request.GET.get('token', None)

        if token:
            request.META['HTTP_AUTHORIZATION'] = f'Bearer {token}'

        response = self.get_response(request)
        return response
