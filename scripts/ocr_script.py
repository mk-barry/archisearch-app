import sys
import json
import fitz  # PyMuPDF
from PIL import Image
import io
from rapidocr_onnxruntime import RapidOCR

# Initialisation du moteur OCR
engine = RapidOCR()

def get_text_from_pdf(file_path):
    """Transforme chaque page du PDF en image et extrait le texte."""
    full_text = ""
    doc = fitz.open(file_path)
    for page in doc:
        # Transformation de la page en image (haute résolution pour l'OCR)
        pix = page.get_pixmap(matrix=fitz.Matrix(2, 2))
        img_data = pix.tobytes("png")
        
        # Analyse OCR sur l'image de la page
        result, _ = engine(img_data)
        if result:
            full_text += " ".join([line[1] for line in result]) + " "
    doc.close()
    return full_text.lower()

def get_text_from_image(file_path):
    """Extrait le texte d'une image directe."""
    result, _ = engine(file_path)
    if result:
        return " ".join([line[1] for line in result]).lower()
    return ""

def validate(file_path, rules):
    try:
        # 1. Extraction du texte selon le format
        if file_path.lower().endswith('.pdf'):
            text = get_text_from_pdf(file_path)
        else:
            text = get_text_from_image(file_path)

        if not text.strip():
            return {"status": "error", "message": "Aucun texte détecté."}
        
        # raw_text = text

        # 2. Logique de scoring basée sur la BD
        score = 0
        keywords = rules.get('keywords', [])
        min_score = rules.get('min_score', 1)

        found_keywords = []
        for kw in keywords:
            if kw.lower() in text:
                score += 1
                found_keywords.append(kw)

        valid = score >= min_score

        return {
            "status": "submitted" if valid else "error",
            "score": score,
            "min_required": min_score,
            "match_keywords": found_keywords,
            "extracted_text": text,
            "is_valid": valid,
            # "preview": text[:100] # Optionnel pour debug
        }

    except Exception as e:
        return {"status": "error", "message": str(e)}

if __name__ == "__main__":
    if len(sys.argv) > 2:
        path = sys.argv[1]
        rules_json = json.loads(sys.argv[2])
        print(json.dumps(validate(path, rules_json)))