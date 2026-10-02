import io
import logging

import pdfplumber
from google import genai

from schemas import ExtractedCV

logger = logging.getLogger("semantic_matcher.parser")

client = genai.Client()


def extract_text_from_pdf(pdf_bytes: bytes) -> str:
    full_text = ""
    with pdfplumber.open(io.BytesIO(pdf_bytes)) as pdf:
        for page in pdf.pages:
            full_text += (page.extract_text() or "") + "\n"
    return full_text.strip()


def parse_cv_from_pdf(pdf_bytes: bytes) -> ExtractedCV:
    full_text = extract_text_from_pdf(pdf_bytes)

    if not full_text:
        raise ValueError("No extractable text found in this PDF. It may be a scanned image without a text layer.")

    prompt = f"""
    Analyze the following CV/resume text and extract the requested fields precisely.
    If a field is not mentioned, leave it empty or null rather than guessing.

    CV TEXT:
    {full_text}
    """

    response = client.models.generate_content(
        model="gemini-2.5-flash",
        contents=prompt,
        config={
            "response_mime_type": "application/json",
            "response_schema": ExtractedCV,
        },
    )

    return ExtractedCV.model_validate_json(response.text)
