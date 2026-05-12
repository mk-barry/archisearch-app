import sys
import json
import pytesseract
from PIL import Image
import pdf2image
import os

def check_document(file_path, label):
    try:
        # Vérification si le fichier existe
        if not os.path.exists(file_path):
            return {"status": "error", "message": "Fichier introuvable"}

        # Conversion PDF -> Image ou ouverture directe
        if file_path.lower().endswith('.pdf'):
            images = pdf2image.convert_from_path(file_path)
            text = "".join([pytesseract.image_to_string(img) for img in images])
        else:
            text = pytesseract.image_to_string(Image.open(file_path))

        text_content = text.lower()
        
        # Logique de mots-clés par label (à enrichir)
        keywords = {
            "CNI": ["carte nationale", "identite", "republique", "specimen"],
            "Passport": ["passeport", "republic", "surname"],
            "Diplôme": ["diplome", "universite", "attestation", "reussite"]
        }

        # On vérifie si un des mots-clés correspond au label
        checks = keywords.get(label, [label.lower()])
        is_valid = any(word in text_content for word in checks)

        if is_valid:
            return {
                "status": "success",
                "text": text, # On renvoie le texte pour Laravel
                "metadata": {
                    "word_count": len(text.split()),
                    "ocr_engine": "Tesseract 5.0"
                }
            }
        else:
            return {"status": "error", "message": f"Le document ne semble pas être un(e) {label}"}

    except Exception as e:
        return {"status": "error", "message": str(e)}

if __name__ == "__main__":
    # Récupération des arguments passés par Laravel Process
    path_arg = sys.argv[1]
    label_arg = sys.argv[2]
    
    result = check_document(path_arg, label_arg)
    print(json.dumps(result))