import pandas as pd
import requests
import json
import datetime
from typing import List, Dict, Any, Optional

# Configuration de l'API
API_BASE_URL = "http://votre-api-url.com/api"  # À remplacer par l'URL réelle de votre API
headers = {
    "Content-Type": "application/json",
    # Ajoutez ici votre token d'authentification si nécessaire
    # "Authorization": "Bearer your_token"
}

def read_excel_data(file_path: str) -> pd.DataFrame:
    """
    Lit les données depuis le fichier Excel et les retourne sous forme de DataFrame
    """
    print(f"Lecture du fichier Excel: {file_path}")
    try:
        df = pd.read_excel(file_path)
        print(f"Fichier lu avec succès. {len(df)} lignes trouvées.")
        return df
    except Exception as e:
        print(f"Erreur lors de la lecture du fichier: {str(e)}")
        raise

def clean_data(df: pd.DataFrame) -> pd.DataFrame:
    """
    Nettoie les données du DataFrame
    """
    print("Nettoyage des données...")
    
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
    
    print(f"Données nettoyées. {len(df)} lignes restantes.")
    return df

def create_activity_types(df: pd.DataFrame) -> Dict[str, int]:
    """
    Crée les types d'activités à partir des données et retourne un dictionnaire de mapping
    """
    print("Création des types d'activités...")
    
    if 'type' not in df.columns:
        print("Colonne 'type' non trouvée.")
        return {}
    
    # Extraire les types d'activités uniques
    activity_types = df['type'].dropna().unique()
    
    activity_type_mapping = {}
    
    for activity_type in activity_types:
        # Créer le type d'activité via l'API
        payload = {"name": activity_type}
        
        try:
            response = requests.post(f"{API_BASE_URL}/activity-types/", 
                                    headers=headers, 
                                    data=json.dumps(payload))
            
            if response.status_code in [201, 200]:
                activity_type_id = response.json().get('id')
                activity_type_mapping[activity_type] = activity_type_id
                print(f"Type d'activité '{activity_type}' créé avec ID: {activity_type_id}")
            else:
                print(f"Erreur lors de la création du type d'activité '{activity_type}': {response.status_code}")
                print(response.text)
        except Exception as e:
            print(f"Exception lors de la création du type d'activité '{activity_type}': {str(e)}")
    
    return activity_type_mapping

def create_measure_types() -> Dict[str, int]:
    """
    Crée les types de mesures et retourne un dictionnaire de mapping
    """
    print("Création des types de mesures...")
    
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
        try:
            response = requests.post(f"{API_BASE_URL}/measure-types/", 
                                    headers=headers, 
                                    data=json.dumps(measure_type))
            
            if response.status_code in [201, 200]:
                measure_type_id = response.json().get('id')
                measure_type_mapping[measure_type["name"]] = measure_type_id
                print(f"Type de mesure '{measure_type['name']}' créé avec ID: {measure_type_id}")
            else:
                print(f"Erreur lors de la création du type de mesure '{measure_type['name']}': {response.status_code}")
                print(response.text)
        except Exception as e:
            print(f"Exception lors de la création du type de mesure '{measure_type['name']}': {str(e)}")
    
    return measure_type_mapping

def create_user(user_data: Dict[str, Any]) -> Optional[int]:
    """
    Crée un utilisateur et retourne son ID
    """
    try:
        response = requests.post(f"{API_BASE_URL}/users/", 
                                headers=headers, 
                                data=json.dumps(user_data))
        
        if response.status_code in [201, 200]:
            user_id = response.json().get('id')
            print(f"Utilisateur créé avec ID: {user_id}")
            return user_id
        else:
            print(f"Erreur lors de la création de l'utilisateur: {response.status_code}")
            print(response.text)
            return None
    except Exception as e:
        print(f"Exception lors de la création de l'utilisateur: {str(e)}")
        return None

def create_profile(profile_data: Dict[str, Any]) -> Optional[int]:
    """
    Crée un profil et retourne son ID
    """
    try:
        response = requests.post(f"{API_BASE_URL}/profiles/", 
                                headers=headers, 
                                data=json.dumps(profile_data))
        
        if response.status_code in [201, 200]:
            profile_id = response.json().get('id')
            print(f"Profil créé avec ID: {profile_id}")
            return profile_id
        else:
            print(f"Erreur lors de la création du profil: {response.status_code}")
            print(response.text)
            return None
    except Exception as e:
        print(f"Exception lors de la création du profil: {str(e)}")
        return None

def create_activities(df: pd.DataFrame, user_id: int, activity_type_mapping: Dict[str, int]) -> Dict[int, int]:
    """
    Crée les activités à partir des données et retourne un dictionnaire de mapping
    """
    print("Création des activités...")
    
    activity_mapping = {}  # Pour stocker le mapping entre l'ID Excel et l'ID API
    
    for _, row in df.iterrows():
        # Préparer les données de l'activité
        activity_data = {
            "name": row.get('title', 'Activité sans titre'),
            "marque_activite_id": row.get('activity_id', None),
            "start": row.get('date', datetime.datetime.now()).isoformat() if pd.notna(row.get('date', None)) else datetime.datetime.now().isoformat(),
            "duree": float(row.get('duration', 0)) if pd.notna(row.get('duration', None)) else 0,
            "type_id": activity_type_mapping.get(row.get('type', ''), None),
            "location": "",  # Non fourni dans les données
            "user_id": user_id,
            "manufacture": "Importé depuis Excel"
        }
        
        # Filtrer les valeurs None
        activity_data = {k: v for k, v in activity_data.items() if v is not None}
        
        try:
            response = requests.post(f"{API_BASE_URL}/activities/", 
                                    headers=headers, 
                                    data=json.dumps(activity_data))
            
            if response.status_code in [201, 200]:
                api_activity_id = response.json().get('id')
                excel_activity_id = row.get('activity_id')
                if pd.notna(excel_activity_id):
                    activity_mapping[int(excel_activity_id)] = api_activity_id
                print(f"Activité '{activity_data['name']}' créée avec ID: {api_activity_id}")
            else:
                print(f"Erreur lors de la création de l'activité '{activity_data['name']}': {response.status_code}")
                print(response.text)
        except Exception as e:
            print(f"Exception lors de la création de l'activité '{activity_data['name']}': {str(e)}")
    
    return activity_mapping

def create_measures(df: pd.DataFrame, activity_mapping: Dict[int, int], measure_type_mapping: Dict[str, int]):
    """
    Crée les mesures à partir des données
    """
    print("Création des mesures...")
    
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
                
                # Créer la mesure
                measure_data = {
                    "activite_id": api_activity_id,
                    "type_mesure_id": measure_type_id
                }
                
                try:
                    measure_response = requests.post(f"{API_BASE_URL}/measures/", 
                                                  headers=headers, 
                                                  data=json.dumps(measure_data))
                    
                    if measure_response.status_code in [201, 200]:
                        measure_id = measure_response.json().get('id')
                        print(f"Mesure de type '{measure_type_name}' créée pour l'activité {api_activity_id} avec ID: {measure_id}")
                        
                        # Créer la valeur instantanée
                        value_data = {
                            "type_mesure_id": measure_type_id,
                            "value": float(row[column])
                        }
                        
                        # Note: j'ai remarqué que vous n'avez pas d'endpoint pour InstantValue dans vos URL
                        # Vous devrez peut-être ajouter cet endpoint ou utiliser un endpoint existant
                        # Pour l'instant, nous utiliserons un endpoint fictif
                        value_endpoint = f"{API_BASE_URL}/instant-values/"
                        
                        try:
                            value_response = requests.post(value_endpoint, 
                                                        headers=headers, 
                                                        data=json.dumps(value_data))
                            
                            if value_response.status_code in [201, 200]:
                                print(f"Valeur instantanée créée pour la mesure {measure_id}")
                            else:
                                print(f"Erreur lors de la création de la valeur instantanée: {value_response.status_code}")
                                print(value_response.text)
                        except Exception as e:
                            print(f"Exception lors de la création de la valeur instantanée: {str(e)}")
                    else:
                        print(f"Erreur lors de la création de la mesure: {measure_response.status_code}")
                        print(measure_response.text)
                except Exception as e:
                    print(f"Exception lors de la création de la mesure: {str(e)}")

def process_data(file_path: str):
    """
    Fonction principale qui orchestre tout le processus
    """
    print("Début du traitement des données...")
    
    # Lire les données
    df = read_excel_data(file_path)
    
    # Nettoyer les données
    df = clean_data(df)
    
    # Créer un utilisateur par défaut pour associer les activités
    user_data = {
        "nom": "Utilisateur",
        "prenom": "Importation",
        "role": "utilisateur",
        "email": "import@example.com",
        "password": "password123"  # À remplacer par un mot de passe sécurisé
    }
    user_id = create_user(user_data)
    
    if user_id is None:
        print("Impossible de continuer sans ID utilisateur.")
        return
    
    # Créer un profil pour l'utilisateur
    profile_data = {
        "email": "import@example.com",
        "password": "password123",  # À remplacer par un mot de passe sécurisé
        "last_update": datetime.datetime.now().isoformat(),
        "marque_id": None,
        "user_id": user_id,
        "code_token": None,
        "client_id": None,
        "client_seat": None
    }
    create_profile(profile_data)
    
    # Créer les types d'activités
    activity_type_mapping = create_activity_types(df)
    
    # Créer les types de mesures
    measure_type_mapping = create_measure_types()
    
    # Créer les activités
    activity_mapping = create_activities(df, user_id, activity_type_mapping)
    
    # Créer les mesures
    create_measures(df, activity_mapping, measure_type_mapping)
    
    print("Traitement des données terminé avec succès!")

if __name__ == "__main__":
    # Remplacer par le chemin réel de votre fichier Excel
    file_path = "isocc.xlsx"
    process_data(file_path)