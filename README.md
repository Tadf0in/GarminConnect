Créér l'environnement virtuel :
```bash
py -m venv env
```

Activer l'environnement virtuel :
```bash
env\Scripts\activate
```

Installer les librairies :
```bash
py -m pip install -r requirements.txt
```

Lancer le serveur :
```bash
py backend\manage.py runserver
```

backend/db.cnf :
```cnf
[client]
database = NAME
user = USER
password = PASSWORD
default-character-set = utf8mb4
```