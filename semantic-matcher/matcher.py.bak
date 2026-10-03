import logging
from functools import lru_cache

import numpy as np
from google import genai
from sklearn.metrics.pairwise import cosine_similarity

from schemas import ExtractedCV, MatchResult, Scholarship

logger = logging.getLogger("semantic_matcher.matcher")

client = genai.Client()

EMBEDDING_MODEL = "text-embedding-004"


@lru_cache(maxsize=2048)
def _get_embedding_cached(text: str):
    result = client.models.embed_content(model=EMBEDDING_MODEL, contents=text)
    return tuple(result.embedding.values)


def get_embedding(text: str) -> np.ndarray:
    return np.array(_get_embedding_cached(text)).reshape(1, -1)


def _passes_hard_filter(cv: ExtractedCV, scholarship: Scholarship) -> bool:
    target_degrees = [d.lower() for d in scholarship.target_degrees]

    if target_degrees and "any" not in target_degrees:
        if cv.degree_level.lower() not in target_degrees:
            return False

    if scholarship.min_gpa is not None and cv.gpa is not None:
        if cv.gpa < scholarship.min_gpa:
            return False

    return True


def match_scholarships(cv_data: ExtractedCV, all_scholarships: list):
    filtered = [s for s in all_scholarships if _passes_hard_filter(cv_data, s)]

    if not filtered:
        return []

    cv_summary = f"{cv_data.field_of_study}. Interests: {', '.join(cv_data.research_interests)}. Skills: {', '.join(cv_data.skills)}"
    cv_vector = get_embedding(cv_summary)

    ranked = []

    for scholarship in filtered:
        try:
            s_vector = get_embedding(scholarship.description)
            score = float(cosine_similarity(cv_vector, s_vector)[0][0])
        except Exception as exc:
            logger.error("Embedding failed for scholarship_id=%s: %s", scholarship.id, exc)
            continue

        ranked.append(MatchResult(scholarship=scholarship, match_score=round(score * 100, 2)))

    ranked.sort(key=lambda r: r.match_score, reverse=True)
    return ranked
