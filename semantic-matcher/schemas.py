from typing import List, Optional
from pydantic import BaseModel, Field


class ExtractedCV(BaseModel):
    degree_level: str = Field(description="Current or target degree level: Bachelor, Master, PhD")
    field_of_study: str = Field(description="Primary field, e.g. Computer Science, AI, Engineering")
    gpa: Optional[float] = Field(default=None, description="GPA on a 4.0 scale, or as a percentage out of 100")
    nationality: Optional[str] = Field(default=None, description="Applicant nationality or country of residence")
    skills: List[str] = Field(default_factory=list, description="Core technical and research skills")
    research_interests: List[str] = Field(default_factory=list, description="Research interests or areas of work")


class Scholarship(BaseModel):
    id: int
    title: str
    target_degrees: List[str]
    eligible_fields: List[str]
    min_gpa: Optional[float] = None
    description: str


class MatchResult(BaseModel):
    scholarship: Scholarship
    match_score: float


class MatchRequest(BaseModel):
    cv: ExtractedCV
    scholarships: List[Scholarship]
