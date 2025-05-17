## Backend :

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

Créer et remplir le fichier backend/db.cnf :
```cnf
[client]
database = NAME
user = USER
password = PASSWORD
default-character-set = utf8mb4
```

Lancer les migrations:
```bash
py backend\manage.py migrate
```

Créer un super utilisateur (qui peut se connecter à /admin):
```bash
py backend\manage.py createsuperuser
```

Lancer le serveur python (pour l'API) :
```bash
py backend\manage.py runserver
```


## Frontend :

Installer les modules :
```bash
cd frontend
npm install
```

Lancer le serveur react (pour le site) :
```bash
cd frontend
npm run dev
```