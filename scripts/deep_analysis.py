import re
import sys
import json
from datetime import datetime
from difflib import SequenceMatcher

def analyze():
    # Structure par défaut pour éviter le "Undefined array key"
    result = {
        "name_match": False,
        "name_score": 0,
        "is_expired": False,
        "expiry_date": None,
        "flags": []
    }

    try:
        # Récupération des arguments
        if len(sys.argv) < 2:
            return result
            
        data = json.loads(sys.argv[1])
        text = data.get('text', '')
        expected_name = data.get('name', '')
        check_expiry = data.get('check_expiry', False)

        # --- REMPLACE LA SECTION 1 PAR CELLE-CI ---

        # 1. Matching du nom
        expected_name_clean = expected_name.lower().strip()
        text_clean = text.lower().replace(" ", "") # On enlève les espaces du texte extrait pour comparer

        # On calcule le score classique (ratio)
        score = SequenceMatcher(None, expected_name_clean, text.lower()).ratio()

        # NOUVELLE LOGIQUE : Vérification par mots individuels
        # On sépare "Orielle Onana" en ["orielle", "onana"]
        name_parts = expected_name_clean.split()
        found_parts = 0

        for part in name_parts:
            if part in text_clean: # On cherche si "orielle" est dans "onanaalbeneoriellejoelle"
                found_parts += 1

        # Le match est validé si le score est bon OU si TOUS les prénoms sont présents dans le bloc collé
        is_name_present = (found_parts == len(name_parts)) and len(name_parts) > 0

        result["name_score"] = round(max(score, found_parts/len(name_parts) if len(name_parts) > 0 else 0), 2)
        result["name_match"] = score > 0.7 or is_name_present

        # 2. Vérification d'expiration
        if check_expiry:
            date_pattern = r'(\d{2}[/-]\d{2}[/-]\d{4})'
            import re
            dates = re.findall(date_pattern, text)
            if dates:
                parsed_dates = []
                for d in dates:
                    try:
                        parsed_dates.append(datetime.strptime(d.replace('-', '/'), '%d/%m/%Y'))
                    except: continue
                
                if parsed_dates:
                    expiry = max(parsed_dates)
                    result["expiry_date"] = expiry.strftime('%d/%m/%Y')
                    if expiry < datetime.now():
                        result["is_expired"] = True
                        result["flags"].append("Document expiré")

    except Exception as e:
        result["flags"].append(f"Erreur Python: {str(e)}")
    
    return result

if __name__ == "__main__":
    print(json.dumps(analyze()))