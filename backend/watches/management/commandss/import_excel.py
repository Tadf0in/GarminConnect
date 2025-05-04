from django.core.management.base import BaseCommand, CommandError
import pandas as pd
import datetime
from typing import Dict, Any, Optional
from watches.models import User, Profile, ActivityType, Activity, MeasureType, Measure

class Command(BaseCommand):
    help = 'Importe des données depuis un fichier Excel'

    def add_arguments(self, parser):
        parser.add_argument('file_path', type=str, help='Chemin vers le fichier Excel')
        parser.add_argument('--email', type=str, help='Email de l\'utilisateur qui recevra les données')

    def handle(self, *args, **options):
        file_path = options['file_path']
        email = options.get('email')
        
        # Vérifier si l'utilisateur existe
        try:
            if email:
                user = User.objects.get(email=email)
                self.stdout.write(self.style.SUCCESS(f"Utilisateur trouvé: {user}"))
            else:
                # Utiliser le premier superutilisateur disponible
                user = User.objects.filter(is_superuser=True).first()
                if not user:
                    raise CommandError("Aucun utilisateur superutilisateur trouvé. Veuillez fournir un email.")
                self.stdout.write(self.style.SUCCESS(f"Utilisation du superutilisateur par défaut: {user}"))
        except User.DoesNotExist:
            raise CommandError(f"Utilisateur avec l'email {email} introuvable")

        try:
            self.process_data(file_path, user)
            self.stdout.write(self.style.SUCCESS(f"Importation réussie depuis {file_path}"))
        except Exception as e:
            raise CommandError(f"Erreur lors de l'importation: {str(e)}")

    def read_excel_data(self, file_path: str) -> pd.DataFrame:
        """
        Lit les données depuis le fichier Excel et les retourne sous forme de DataFrame
        """
        self.stdout.write(f"Lecture du fichier Excel: {file_path}")
        try:
            df = pd.read_excel(file_path)
            self.stdout.write(f"Fichier lu avec succès. {len(df)} lignes trouvées.")
            return df
        except Exception as e:
            self.stdout.write(self.style.ERROR(f"Erreur lors de la lecture du fichier: {str(e)}"))
            raise

    def clean_data(self, df: pd.DataFrame) -> pd.DataFrame:
        """
        Nettoie les données du DataFrame
        """
        self.stdout.write("Nettoyage des données...")
        
        # Suppression des lignes vides
        df = df.dropna(how='all')
        
        # Renommage des colonnes pour plus de clarté
        column_mapping = {
            'A': 'activity_id',
            'B': 'date',
            'C': 'type',
            'D': 'title',
            'E': 'distance',
            'F': 'duration',
            'G': 'avg',
            'H': 'min_sp',
            'I': 'max_sp',
            'J': 'total_asc',
            'K': 'total_desc',
            'L': 'training_stress',
            'M': 'sdm',
            'N': 'total_p',
            'O': 'total_c',
            'P': 'min',
            'Q': 'compressed',
            'R': 'best_lap',
            'S': 'number_of_laps',
            'T': 'avg_fc',
            'U': 'moving_time',
            'V': 'rest_time',
            'W': 'moving_distance',
            'X': 'rest_distance',
            'Y': 'max_elev'
        }
        
        # Appliquer le renommage si les colonnes correspondent
        existing_columns = set(df.columns).intersection(column_mapping.keys())
        rename_dict = {k: column_mapping[k] for k in existing_columns}
        df = df.rename(columns=rename_dict)
        
        # Conversion des types de données
        numeric_columns = ['distance', 'duration', 'avg', 'min_sp', 'max_sp', 'total_asc', 'total_desc', 
                          'training_stress', 'sdm', 'total_p', 'total_c', 'min', 'best_lap', 'number_of_laps',
                          'avg_fc', 'moving_time', 'rest_time', 'moving_distance', 'rest_distance', 'max_elev']
        
        for col in numeric_columns:
            if col in df.columns:
                df[col] = pd.to_numeric(df[col], errors='coerce')
        
        # Conversion des dates
        if 'date' in df.columns:
            df['date'] = pd.to_datetime(df['date'], errors='coerce')
        
        # Suppression des lignes avec des valeurs manquantes essentielles
        essential_columns = ['type', 'title', 'duration']
        essential_columns = [col for col in essential_columns if col in df.columns]
        if essential_columns:
            df = df.dropna(subset=essential_columns)
        
        self.stdout.write(f"Données nettoyées. {len(df)} lignes restantes.")
        return df

    def create_activity_types(self, df: pd.DataFrame) -> Dict[str, int]:
        """
        Crée les types d'activités à partir des données et retourne un dictionnaire de mapping
        """
        self.stdout.write("Création des types d'activités...")
        
        if 'type' not in df.columns:
            self.stdout.write("Colonne 'type' non trouvée.")
            return {}
        
        # Extraire les types d'activités uniques
        activity_types = df['type'].dropna().unique()
        
        activity_type_mapping = {}
        
        for activity_type in activity_types:
            # Vérifier si le type d'activité existe déjà
            activity_type_obj, created = ActivityType.objects.get_or_create(name=activity_type)
            activity_type_id = activity_type_obj.id
            activity_type_mapping[activity_type] = activity_type_id
            
            if created:
                self.stdout.write(f"Type d'activité '{activity_type}' créé avec ID: {activity_type_id}")
            else:
                self.stdout.write(f"Type d'activité '{activity_type}' trouvé avec ID: {activity_type_id}")
        
        return activity_type_mapping

    def create_measure_types(self) -> Dict[str, int]:
        """
        Crée les types de mesures et retourne un dictionnaire de mapping
        """
        self.stdout.write("Création des types de mesures...")
        
        measure_types = [
            {"name": "Distance", "unite": "km"},
            {"name": "Durée", "unite": "min"},
            {"name": "Vitesse moyenne", "unite": "km/h"},
            {"name": "Vitesse minimale", "unite": "km/h"},
            {"name": "Vitesse maximale", "unite": "km/h"},
            {"name": "Ascension totale", "unite": "m"},
            {"name": "Descente totale", "unite": "m"},
            {"name": "Stress d'entraînement", "unite": "pts"},
            {"name": "Fréquence cardiaque moyenne", "unite": "bpm"},
            {"name": "Puissance totale", "unite": "watts"},
            {"name": "Calories totales", "unite": "kcal"},
            {"name": "Temps de déplacement", "unite": "min"},
            {"name": "Temps de repos", "unite": "min"},
            {"name": "Distance en déplacement", "unite": "km"},
            {"name": "Distance au repos", "unite": "km"},
            {"name": "Élévation maximale", "unite": "m"}
        ]
        
        measure_type_mapping = {}
        
        for measure_type in measure_types:
            # Vérifier si le type de mesure existe déjà
            measure_type_obj, created = MeasureType.objects.get_or_create(
                name=measure_type["name"],
                defaults={"unite": measure_type["unite"]}
            )
            measure_type_id = measure_type_obj.id
            measure_type_mapping[measure_type["name"]] = measure_type_id
            
            if created:
                self.stdout.write(f"Type de mesure '{measure_type['name']}' créé avec ID: {measure_type_id}")
            else:
                self.stdout.write(f"Type de mesure '{measure_type['name']}' trouvé avec ID: {measure_type_id}")
        
        return measure_type_mapping

    def create_activities(self, df: pd.DataFrame, user, activity_type_mapping: Dict[str, int]) -> Dict[int, int]:
        """
        Crée les activités à partir des données et retourne un dictionnaire de mapping
        """
        self.stdout.write("Création des activités...")
        
        activity_mapping = {}  # Pour stocker le mapping entre l'ID Excel et l'ID API
        
        for _, row in df.iterrows():
            activity_type_id = activity_type_mapping.get(row.get('type', ''))
            if activity_type_id is None:
                self.stdout.write(f"Type d'activité manquant pour l'activité '{row.get('title', 'Sans titre')}'. Ignoré.")
                continue
                
            # Préparer les données de l'activité
            start_date = row.get('date')
            if pd.isna(start_date):
                start_date = datetime.datetime.now()
                
            duration_value = row.get('duration', 0)
            if pd.isna(duration_value):
                duration_value = 0
                
            duration = datetime.timedelta(minutes=float(duration_value))
                
            # Créer l'activité
            activity = Activity(
                name=row.get('title', 'Activité sans titre'),
                start=start_date,
                duration=duration,
                type_id=activity_type_id,
                location="",
                user=user,
                activity_manufacturer_id=row.get('activity_id', 0) if pd.notna(row.get('activity_id', None)) else 0,
                manufacturer="Importé depuis Excel"
            )
            
            activity.save()
            
            excel_activity_id = row.get('activity_id')
            if pd.notna(excel_activity_id):
                activity_mapping[int(excel_activity_id)] = activity.id
                
            self.stdout.write(f"Activité '{activity.name}' créée avec ID: {activity.id}")
        
        return activity_mapping

    def create_measures(self, df: pd.DataFrame, activity_mapping: Dict[int, int], measure_type_mapping: Dict[str, int]):
        """
        Crée les mesures à partir des données
        """
        self.stdout.write("Création des mesures...")
        
        # Liste des colonnes et leur type de mesure correspondant
        column_measure_mapping = {
            'distance': 'Distance',
            'duration': 'Durée',
            'avg': 'Vitesse moyenne',
            'min_sp': 'Vitesse minimale',
            'max_sp': 'Vitesse maximale',
            'total_asc': 'Ascension totale',
            'total_desc': 'Descente totale',
            'training_stress': 'Stress d\'entraînement',
            'avg_fc': 'Fréquence cardiaque moyenne',
            'total_p': 'Puissance totale',
            'total_c': 'Calories totales',
            'moving_time': 'Temps de déplacement',
            'rest_time': 'Temps de repos',
            'moving_distance': 'Distance en déplacement',
            'rest_distance': 'Distance au repos',
            'max_elev': 'Élévation maximale'
        }
        
        for _, row in df.iterrows():
            excel_activity_id = row.get('activity_id')
            if pd.isna(excel_activity_id) or int(excel_activity_id) not in activity_mapping:
                continue
            
            api_activity_id = activity_mapping[int(excel_activity_id)]
            
            for column, measure_type_name in column_measure_mapping.items():
                if column in df.columns and pd.notna(row.get(column)):
                    measure_type_id = measure_type_mapping.get(measure_type_name)
                    if measure_type_id is None:
                        continue
                    
                    try:
                        # Créer la mesure
                        activity = Activity.objects.get(id=api_activity_id)
                        measure_type = MeasureType.objects.get(id=measure_type_id)
                        
                        measure = Measure(
                            activity=activity,
                            type=measure_type,
                            value=str(row[column])
                        )
                        measure.save()
                        
                        self.stdout.write(f"Mesure de type '{measure_type_name}' créée pour l'activité {api_activity_id}")
                    except Exception as e:
                        self.stdout.write(self.style.ERROR(f"Erreur lors de la création de la mesure: {str(e)}"))

    def process_data(self, file_path: str, user):
        """
        Fonction principale qui orchestre tout le processus
        """
        self.stdout.write(self.style.SUCCESS("Début du traitement des données..."))
        
        # Lire les données
        df = self.read_excel_data(file_path)
        
        # Nettoyer les données
        df = self.clean_data(df)
        
        # Créer les types d'activités
        activity_type_mapping = self.create_activity_types(df)
        
        # Créer les types de mesures
        measure_type_mapping = self.create_measure_types()
        
        # Créer les activités
        activity_mapping = self.create_activities(df, user, activity_type_mapping)
        
        # Créer les mesures
        self.create_measures(df, activity_mapping, measure_type_mapping)
        
        self.stdout.write(self.style.SUCCESS("Traitement des données terminé avec succès!"))