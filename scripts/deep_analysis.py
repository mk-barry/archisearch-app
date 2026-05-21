# import re
# import sys
# import json
# from datetime import datetime
# from difflib import SequenceMatcher

# def analyze():
#     # Structure par défaut pour éviter le "Undefined array key"
#     result = {
#         "name_match": False,
#         "name_score": 0,
#         "is_expired": False,
#         "expiry_date": None,
#         "flags": []
#     }

#     try:
#         # Récupération des arguments
#         if len(sys.argv) < 2:
#             return result
            
#         data = json.loads(sys.argv[1])
#         text = data.get('text', '')
#         expected_name = data.get('name', '')
#         check_expiry = data.get('check_expiry', False)

#         # --- REMPLACE LA SECTION 1 PAR CELLE-CI ---

#         # 1. Matching du nom
#         expected_name_clean = expected_name.lower().strip()
#         text_clean = text.lower().replace(" ", "") # On enlève les espaces du texte extrait pour comparer

#         # On calcule le score classique (ratio)
#         score = SequenceMatcher(None, expected_name_clean, text.lower()).ratio()

#         # NOUVELLE LOGIQUE : Vérification par mots individuels
#         # On sépare "Orielle Onana" en ["orielle", "onana"]
#         name_parts = expected_name_clean.split()
#         found_parts = 0

#         for part in name_parts:
#             if part in text_clean: # On cherche si "orielle" est dans "onanaalbeneoriellejoelle"
#                 found_parts += 1

#         # Le match est validé si le score est bon OU si TOUS les prénoms sont présents dans le bloc collé
#         is_name_present = (found_parts == len(name_parts)) and len(name_parts) > 0

#         result["name_score"] = round(max(score, found_parts/len(name_parts) if len(name_parts) > 0 else 0), 2)
#         result["name_match"] = score > 0.7 or is_name_present

#         # 2. Vérification d'expiration
#         if check_expiry:
#             date_pattern = r'(\d{2}[/-]\d{2}[/-]\d{4})'
#             import re
#             dates = re.findall(date_pattern, text)
#             if dates:
#                 parsed_dates = []
#                 for d in dates:
#                     try:
#                         parsed_dates.append(datetime.strptime(d.replace('-', '/'), '%d/%m/%Y'))
#                     except: continue
                
#                 if parsed_dates:
#                     expiry = max(parsed_dates)
#                     result["expiry_date"] = expiry.strftime('%d/%m/%Y')
#                     if expiry < datetime.now():
#                         result["is_expired"] = True
#                         result["flags"].append("Document expiré")

#     except Exception as e:
#         result["flags"].append(f"Erreur Python: {str(e)}")
    
#     return result

# if __name__ == "__main__":
#     print(json.dumps(analyze()))


import re
import sys
import json
from datetime import datetime
from difflib import SequenceMatcher

# =========================================================
# UTILS
# =========================================================

def normalize(text):

    if not text:
        return ""

    return re.sub(r'\s+', ' ', text.lower()).strip()

def similarity(a, b):

    return SequenceMatcher(
        None,
        normalize(a),
        normalize(b)
    ).ratio()

# =========================================================
# EXTRACTION GENERIQUE
# =========================================================

GLOBAL_PATTERNS = {

    "student_name": [
        r"(?:nom|name|candidate)\s*[:\-]?\s*([A-Z\s]+)"
    ],

    "birth_date": [
        r"(?:né le|date de naissance|born on)\s*[:\-]?\s*([0-9\/\-]+)"
    ],

    "birth_year": [
        r"(?:né en|born in)\s*[:\-]?\s*(\d{4})"
    ],

    "matricule": [
        r"(?:matricule|student id|registration number)\s*[:\-]?\s*([A-Z0-9\-\/]+)"
    ],

    "document_number": [
        r"(?:numéro|numero|number|id)\s*[:\-]?\s*([A-Z0-9\-\/]+)"
    ],

    "mention": [
        r"(?:mention)\s*[:\-]?\s*(Très Bien|Bien|Assez Bien|Passable|Excellent)"
    ],

    "jury": [
        r"(?:jury)\s*[:\-]?\s*([0-9\-]+)"
    ],

    "issued_date": [
        r"(?:fait le|délivré le|issued on)\s*[:\-]?\s*([0-9\/\-]+)"
    ]
}

# =========================================================
# EXTRACTION
# =========================================================

def extract_metadata(text, custom_patterns=None):

    metadata = {}

    patterns = GLOBAL_PATTERNS.copy()

    if custom_patterns:

        for key, value in custom_patterns.items():
            patterns[key] = value

    for field, regex_list in patterns.items():

        for regex in regex_list:

            try:

                match = re.search(
                    regex,
                    text,
                    re.IGNORECASE
                )

                if match:

                    value = match.group(1).strip()

                    value = re.sub(
                        r'\s+',
                        ' ',
                        value
                    )

                    metadata[field] = value

                    break

            except:
                continue

    return metadata

# =========================================================
# DETECTION DOCUMENT
# =========================================================

def detect_document(text, rules):

    text_normalized = normalize(text)

    required = rules.get(
        "required_keywords",
        []
    )

    forbidden = rules.get(
        "forbidden_keywords",
        []
    )

    minimum = rules.get(
        "minimum_confidence",
        70
    )

    score = 0

    details = []

    # =====================================================
    # REQUIRED
    # =====================================================

    if required:

        weight = 100 / len(required)

        for keyword in required:

            if normalize(keyword) in text_normalized:

                score += weight

                details.append(
                    f"Mot requis trouvé : {keyword}"
                )

    # =====================================================
    # FORBIDDEN
    # =====================================================

    for keyword in forbidden:

        if normalize(keyword) in text_normalized:

            score -= 100

            details.append(
                f"Mot interdit détecté : {keyword}"
            )

    score = max(0, min(100, score))

    return {
        "valid": score >= minimum,
        "score": round(score, 2),
        "details": details
    }

# =========================================================
# NOM MATCH
# =========================================================

def analyze_name(expected_name, text):

    expected_name = normalize(expected_name)

    text = normalize(text)

    ratio = similarity(
        expected_name,
        text
    )

    words = expected_name.split()

    found = 0

    for word in words:

        if word in text:
            found += 1

    words_score = (
        found / len(words)
    ) if words else 0

    final_score = max(
        ratio,
        words_score
    )

    return {
        "match": final_score >= 0.75,
        "score": round(final_score, 2)
    }

# =========================================================
# DATES
# =========================================================

def extract_dates(text):

    patterns = [
        r'\d{2}[\/\-]\d{2}[\/\-]\d{4}',
        r'\d{4}[\/\-]\d{2}[\/\-]\d{2}'
    ]

    dates = []

    for pattern in patterns:

        dates.extend(
            re.findall(pattern, text)
        )

    parsed = []

    for d in dates:

        formats = [
            '%d/%m/%Y',
            '%d-%m-%Y',
            '%Y-%m-%d'
        ]

        for fmt in formats:

            try:

                parsed.append(
                    datetime.strptime(d, fmt)
                )

                break

            except:
                continue

    return parsed

# =========================================================
# MAIN
# =========================================================

def analyze():

    result = {
        "document_valid": False,
        "document_score": 0,
        "document_details": [],
        "name_match": False,
        "name_score": 0,
        "metadata": {},
        "flags": [],
        "is_expired": False,
        "expiry_date": None
    }

    try:

        if len(sys.argv) < 2:
            return result

        data = json.loads(sys.argv[1])

        text = data.get("text", "")

        student = data.get(
            "student",
            {}
        )

        rules = data.get(
            "rules",
            {}
        )

        # =================================================
        # DOCUMENT DETECTION
        # =================================================

        doc_analysis = detect_document(
            text,
            rules
        )

        result["document_valid"] = (
            doc_analysis["valid"]
        )

        result["document_score"] = (
            doc_analysis["score"]
        )

        result["document_details"] = (
            doc_analysis["details"]
        )

        # =================================================
        # EXTRACTION
        # =================================================

        metadata = extract_metadata(
            text,
            rules.get(
                "metadata_patterns",
                {}
            )
        )

        result["metadata"] = metadata

        # =================================================
        # NOM
        # =================================================

        name_analysis = analyze_name(
            student.get("name", ""),
            text
        )

        result["name_match"] = (
            name_analysis["match"]
        )

        result["name_score"] = (
            name_analysis["score"]
        )

        # =================================================
        # EXPIRATION
        # =================================================

        if rules.get(
            "is_perishable",
            False
        ):

            dates = extract_dates(text)

            if dates:

                expiry = max(dates)

                result["expiry_date"] = (
                    expiry.strftime('%d/%m/%Y')
                )

                if expiry < datetime.now():

                    result["is_expired"] = True

                    result["flags"].append(
                        "Document expiré"
                    )

    except Exception as e:

        result["flags"].append(
            f"Erreur Python: {str(e)}"
        )

    return result

# =========================================================
# START
# =========================================================

if __name__ == "__main__":

    print(
        json.dumps(
            analyze(),
            ensure_ascii=False
        )
    )