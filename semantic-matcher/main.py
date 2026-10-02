import logging

from fastapi import FastAPI, File, HTTPException, UploadFile
from fastapi.middleware.cors import CORSMiddleware

from matcher import match_scholarships
from parser import parse_cv_from_pdf
from schemas import MatchRequest, MatchResult, Scholarship

logging.basicConfig(level=logging.INFO)
logger = logging.getLogger("semantic_matcher.main")

app = FastAPI(
    title="Jisr AI - Semantic Scholarship Matcher",
    description="Standalone semantic matching service (embeddings + hard filters).",
    version="0.1.0",
)

app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_methods=["*"],
    allow_headers=["*"],
)

MOCK_SCHOLARSHIPS = [
    Scholarship(
        id=1,
        title="DAAD Master Scholarship in Data & AI",
        target_degrees=["Master"],
        eligible_fields=["Computer Science", "Artificial Intelligence", "Data Science"],
        min_gpa=3.0,
        description="Full scholarship for postgraduate studies in AI, Machine Learning, and NLP in Germany.",
    ),
    Scholarship(
        id=2,
        title="Chevening Scholarship",
        target_degrees=["Master"],
        eligible_fields=["Any"],
        min_gpa=None,
        description="Prestigious UK leadership scholarship covering full tuition for master programs across multiple disciplines.",
    ),
]


@app.get("/health")
def health():
    return {"status": "ok"}


@app.post("/match-cv/")
async def match_cv_endpoint(file: UploadFile = File(...)):
    if file.content_type != "application/pdf":
        raise HTTPException(status_code=400, detail="Only PDF files are accepted.")

    content = await file.read()

    try:
        extracted_data = parse_cv_from_pdf(content)
    except ValueError as exc:
        raise HTTPException(status_code=422, detail=str(exc)) from exc
    except Exception as exc:
        logger.error("CV extraction failed: %s", exc)
        raise HTTPException(status_code=502, detail="Could not analyze this CV. Please try again.") from exc

    matches = match_scholarships(extracted_data, MOCK_SCHOLARSHIPS)

    return {
        "applicant_profile": extracted_data,
        "matched_scholarships": matches,
    }


@app.post("/match", response_model=list[MatchResult])
def match_endpoint(payload: MatchRequest):
    try:
        return match_scholarships(payload.cv, payload.scholarships)
    except Exception as exc:
        logger.error("Matching failed: %s", exc)
        raise HTTPException(status_code=502, detail="Matching service failed. Please try again.") from exc
