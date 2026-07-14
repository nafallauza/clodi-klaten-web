from fastapi import APIRouter, UploadFile, File, Form
from pydantic import BaseModel
from vision.cv_service import analyze_face
from rag.rag_service import get_rag_answer
from recommendation.rec_service import get_recommendation
from services.maps_service import find_nearby_dermatologist
import shutil
import os

router = APIRouter()

class ChatRequest(BaseModel):
    query: str
    cv_results: dict

class RecommendRequest(BaseModel):
    cv_results: dict

class MapsRequest(BaseModel):
    lat: float
    lng: float

@router.post("/vision/analyze")
async def analyze_skin(file: UploadFile = File(...)):
    # Save file temporarily
    upload_dir = "../uploads"
    os.makedirs(upload_dir, exist_ok=True)
    file_location = f"{upload_dir}/{file.filename}"
    
    with open(file_location, "wb") as buffer:
        shutil.copyfileobj(file.file, buffer)
        
    # Analyze face using CV service
    cv_results = analyze_face(file_location)
    
    return {"status": "success", "data": cv_results}

@router.post("/chat")
async def chat_consultation(request: ChatRequest):
    answer = get_rag_answer(request.query, request.cv_results)
    return {"status": "success", "data": {"answer": answer}}

@router.post("/recommendation")
async def get_skincare_recommendation(request: RecommendRequest):
    recs = get_recommendation(request.cv_results)
    return {"status": "success", "data": recs}

@router.post("/nearby-dermatologist")
async def get_nearby_dermatologist(request: MapsRequest):
    clinics = find_nearby_dermatologist(request.lat, request.lng)
    return {"status": "success", "data": clinics}
