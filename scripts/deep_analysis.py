# ======================================================================================
# ARCHISEARCH - ANALYSE DOCUMENTAIRE INTELLIGENTE
# VERSION RAPIDOCR
# ======================================================================================

import os
import re
import cv2
import json
import fitz
import numpy as np

from PIL import Image
from PIL import ImageChops
from PIL import ExifTags

from rapidocr_onnxruntime import RapidOCR

from difflib import SequenceMatcher

from datetime import datetime

# ======================================================================================
# OCR ENGINE
# ======================================================================================

ocr = RapidOCR()

# ======================================================================================
# NORMALIZE
# ======================================================================================

def normalize(text):

    if not text:
        return ""

    text = str(text)

    text = text.lower()

    text = re.sub(r'\s+', ' ', text)

    return text.strip()

# ======================================================================================

def similarity(a, b):

    return SequenceMatcher(
        None,
        normalize(a),
        normalize(b)
    ).ratio()

# ======================================================================================
# CLEAN OCR TEXT
# ======================================================================================

def clean_ocr_text(text):

    if not text:
        return ""

    text = str(text)

    text = re.sub(
        r'[ \t]+',
        ' ',
        text
    )

    text = re.sub(
        r'\n+',
        '\n',
        text
    )

    return text.strip()

# ======================================================================================
# IMAGE PREPROCESSING
# ======================================================================================

# def preprocess_image(image):

#     gray = cv2.cvtColor(
#         image,
#         cv2.COLOR_BGR2GRAY
#     )

#     denoise = cv2.fastNlMeansDenoising(
#         gray
#     )

#     thresh = cv2.adaptiveThreshold(
#         denoise,
#         255,
#         cv2.ADAPTIVE_THRESH_GAUSSIAN_C,
#         cv2.THRESH_BINARY,
#         11,
#         2
#     )

#     return thresh

def preprocess_image(image):

    gray = cv2.cvtColor(
        image,
        cv2.COLOR_BGR2GRAY
    )

    gray = cv2.fastNlMeansDenoising(
        gray,
        None,
        10,
        7,
        21
    )

    return gray

# ======================================================================================
# PDF TO IMAGES
# ======================================================================================

def pdf_to_images(pdf_path):

    images = []

    document = fitz.open(pdf_path)

    for page in document:

        pix = page.get_pixmap(
            matrix=fitz.Matrix(4,4)
        )

        img = np.frombuffer(
            pix.samples,
            dtype=np.uint8
        ).reshape(
            pix.height,
            pix.width,
            pix.n
        )

        if pix.n == 4:

            img = cv2.cvtColor(
                img,
                cv2.COLOR_BGRA2BGR
            )

        images.append(img)

    return images

# ======================================================================================
# LOAD DOCUMENT
# ======================================================================================

def load_document(file_path):

    extension = os.path.splitext(
        file_path
    )[1].lower()

    if extension == '.pdf':

        return pdf_to_images(file_path)

    image = cv2.imread(file_path)

    return [image]

# ======================================================================================
# OCR
# ======================================================================================

def perform_ocr(images):

    full_text = ""

    xml_words = []

    confidences = []

    for page_index, image in enumerate(images):

        result, _ = ocr(image)

        if not result:

            processed = preprocess_image(image)

            result, _ = ocr(processed)

        if not result:
            continue

        lines = sorted(
            result,
            key=lambda x: (
                x[0][0][1],
                x[0][0][0]
            )
        )

        for line in lines:

            try:

                box = line[0]

                text = str(line[1])

                confidence = float(line[2])

                text = clean_ocr_text(
                    text
                )

                full_text += text + "\n"

                confidences.append(
                    confidence * 100
                )

                xml_words.append({

                    "page": page_index + 1,

                    "text": text,

                    "confidence": round(
                        confidence * 100,
                        2
                    ),

                    "box": box
                })

            except:
                continue

    average_confidence = 0

    if confidences:

        average_confidence = round(
            sum(confidences) / len(confidences),
            2
        )

    final_text = clean_ocr_text(
        full_text
    )

    return {

        "text": final_text,

        "xml_words": xml_words,

        "ocr_score": average_confidence
    }

# ======================================================================================
# KEYWORD CHECK
# ======================================================================================

def keyword_exists(keyword, text):

    keyword = normalize(keyword)

    text = normalize(text)

    if keyword in text:

        return True

    words = text.split()

    keyword_words = keyword.split()

    if len(keyword_words) == 1:

        for word in words:

            if similarity(
                keyword,
                word
            ) >= 0.85:

                return True

    return False

# ======================================================================================
# DOCUMENT DETECTION
# ======================================================================================

def detect_document_type(text, document_type):

    if not document_type:

        return {

            "score": 0,

            "valid": False
        }

    rules = document_type.get(
        "validation_rules",
        {}
    )

    required_keywords = rules.get(
        "required_keywords",
        []
    )

    forbidden_keywords = rules.get(
        "forbidden_keywords",
        []
    )

    minimum_confidence = rules.get(
        "minimum_confidence",
        70
    )

    score = 0

    if required_keywords:

        weight = 100 / len(
            required_keywords
        )

        for keyword in required_keywords:

            if keyword_exists(
                keyword,
                text
            ):

                score += weight

    for keyword in forbidden_keywords:

        if keyword_exists(
            keyword,
            text
        ):

            score -= 100

    score = max(
        0,
        min(100, score)
    )

    return {

        "score": round(score, 2),

        "valid": score >= minimum_confidence
    }

# ======================================================================================
# METADATA EXTRACTION
# ======================================================================================

def extract_metadata(text, metadata_patterns):

    metadata = {}

    for field, regex_list in metadata_patterns.items():

        for regex in regex_list:

            try:

                match = re.search(
                    regex,
                    text,
                    re.IGNORECASE
                )

                if match:

                    value = match.group(1)

                    value = re.sub(
                        r'\s+',
                        ' ',
                        value
                    ).strip()

                    metadata[field] = value

                    break

            except:
                continue

    return metadata

# ======================================================================================
# NAME ANALYSIS
# ======================================================================================

def analyze_name(expected_name, text):

    if not expected_name:
        return {
            "match": False,
            "score": 0
        }

    text = normalize(text)

    expected_words = [
        normalize(word)
        for word in expected_name.split()
        if word.strip()
    ]

    matched = 0

    for word in expected_words:

        if word in text:
            matched += 1
            continue

        for token in text.split():

            if similarity(word, token) >= 0.85:
                matched += 1
                break

    score = round(
        matched / len(expected_words) * 100,
        2
    )

    return {
        "match": score >= 80,
        "score": score
    }

# ======================================================================================
# DATE EXTRACTION
# ======================================================================================

def extract_dates(text):

    patterns = [

        r'\d{2}[\/\-\.]\d{2}[\/\-\.]\d{4}',

        r'\d{4}[\/\-\.]\d{2}[\/\-\.]\d{2}',

        r'\d{1,2}\s+[A-Za-zéèêàâîôû]+\s+\d{4}'
    ]

    dates = []

    for pattern in patterns:

        dates.extend(
            re.findall(
                pattern,
                text,
                re.IGNORECASE
            )
        )

    parsed_dates = []

    french_months = {

        "janvier":"01",
        "février":"02",
        "fevrier":"02",
        "mars":"03",
        "avril":"04",
        "mai":"05",
        "juin":"06",
        "juillet":"07",
        "août":"08",
        "aout":"08",
        "septembre":"09",
        "octobre":"10",
        "novembre":"11",
        "décembre":"12",
        "decembre":"12"
    }

    for date in dates:

        try:

            for month, value in french_months.items():

                date = re.sub(
                    month,
                    value,
                    date,
                    flags=re.IGNORECASE
                )

            date = date.replace(".", "/")
            date = date.replace("-", "/")

            parsed_dates.append(

                datetime.strptime(
                    date,
                    "%d/%m/%Y"
                )
            )

            continue

        except:
            pass

        try:

            parsed_dates.append(

                datetime.strptime(
                    date,
                    "%Y/%m/%d"
                )
            )

        except:
            pass

    return parsed_dates

# ======================================================================================
# EXPIRATION
# ======================================================================================

def analyze_expiration(text, is_perishable):

    result = {

        "expired": False,

        "expiry_date": None
    }

    if not is_perishable:

        return result

    dates = extract_dates(text)

    if not dates:

        result["expired"] = True

        return result

    expiry_date = max(dates)

    result["expiry_date"] = expiry_date.strftime(
        '%Y-%m-%d'
    )

    if expiry_date < datetime.now():

        result["expired"] = True

    return result

# ======================================================================================
# ELA
# ======================================================================================

def perform_ela(image_path):

    temp_file = "temp_ela.jpg"

    original = Image.open(
        image_path
    ).convert("RGB")

    original.save(
        temp_file,
        "JPEG",
        quality=90
    )

    compressed = Image.open(
        temp_file
    )

    diff = ImageChops.difference(
        original,
        compressed
    )

    extrema = diff.getextrema()

    max_diff = max(
        [e[1] for e in extrema]
    )

    os.remove(temp_file)

    return {

        "suspicious": max_diff > 40,

        "score": max_diff
    }

# ======================================================================================
# EXIF
# ======================================================================================

def analyze_exif(image_path):

    suspicious_flags = []

    try:

        image = Image.open(
            image_path
        )

        exif = image.getexif()

        suspicious_tools = [

            "photoshop",

            "gimp",

            "pixlr",

            "canva"
        ]

        for tag_id, value in exif.items():

            value = str(value).lower()

            for tool in suspicious_tools:

                if tool in value:

                    suspicious_flags.append(
                        tool
                    )

    except:
        pass

    return suspicious_flags

# ======================================================================================
# MAIN
# ======================================================================================

def analyze_document(data):

    file_path = data.get(
        "file_path"
    )

    student = data.get(
        "student",
        {}
    )

    document_type = data.get(
        "document_type",
        {}
    )

    validation_rules = document_type.get(
        "validation_rules",
        {}
    )

    metadata_patterns = validation_rules.get(
        "metadata_patterns",
        {}
    )

    images = load_document(
        file_path
    )

    ocr_result = perform_ocr(
        images
    )

    text = ocr_result["text"]

    ocr_words = ocr_result["xml_words"]

    ocr_score = ocr_result["ocr_score"]

    detection = detect_document_type(

        text,

        document_type
    )

    metadata = extract_metadata(

        text,

        metadata_patterns
    )

    name_analysis = analyze_name(

        student.get("name", ""),

        text
    )

    expiration = analyze_expiration(

        text,

        document_type.get(
            "is_perishable",
            False
        )
    )

    fraud_score = 0

    fraud_flags = []

    extension = os.path.splitext(
        file_path
    )[1].lower()

    if extension != '.pdf':

        ela = perform_ela(
            file_path
        )

        if ela["suspicious"]:

            fraud_score += 40

            fraud_flags.append(
                "ELA suspicious"
            )

        exif_flags = analyze_exif(
            file_path
        )

        if exif_flags:

            fraud_score += 20

            fraud_flags.extend(
                exif_flags
            )

    flags = []

    if fraud_score >= 40:

        flags.append(
            "Fraude potentielle"
        )

    if expiration["expired"]:

        flags.append(
            "Document expiré"
        )

    if not name_analysis["match"]:

        flags.append(
            "Nom incohérent"
        )


    semantic_score = round(

        detection["score"] * 0.7
        +
        name_analysis["score"] * 0.3,

        2
    )

    is_valid = (

        detection["valid"]
        and not expiration["expired"]
        and fraud_score < 40
        and name_analysis["match"]
    )

    # status = "validated"

    # if not is_valid:

    #     status = "rejected"

    result = {

        "document_type_id": (
            document_type.get("id")
        ),

        "ocr_score": ocr_score,

        "semantic_score": semantic_score,

        "name_match_score": (
            name_analysis["score"]
        ),

        "is_valid": is_valid,

        "is_flagged": (
            fraud_score >= 40
            or expiration["expired"]
            or not name_analysis["match"]
        ),

        "is_expired": (
            expiration["expired"]
        ),

        "expiry_date": (
            expiration["expiry_date"]
        ),

        "flags": flags,

        "ocr_words": ocr_words,

        "fraud_flags": fraud_flags,

        "fraud_score": fraud_score,

        "metadata": metadata,

        # "status": status,

        "extracted_text": text,

        "analyzed_at": datetime.now().strftime(
            '%Y-%m-%d %H:%M:%S'
        )
    }

    return result

# ======================================================================================
# ENTRY
# ======================================================================================

if __name__ == "__main__":

    try:

        if len(os.sys.argv) < 2:

            print(json.dumps({

                "success": False,

                "error": "Missing JSON input"
            }))

            exit()

        input_data = json.loads(
            os.sys.argv[1]
        )

        result = analyze_document(
            input_data
        )

        print(json.dumps({

            "success": True,

            "result": result

        }, ensure_ascii=True))

    except Exception as e:

        print(json.dumps({

            "success": False,

            "error": str(e)

        }, ensure_ascii=True))