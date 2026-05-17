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

        # 1. Matching du nom
        score = SequenceMatcher(None, expected_name.lower(), text.lower()).ratio()
        result["name_score"] = round(score, 2)
        result["name_match"] = score > 0.7 or expected_name.lower() in text.lower()

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