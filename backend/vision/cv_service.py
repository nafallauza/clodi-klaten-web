import os

def analyze_face(image_path: str) -> dict:
    """
    Mock implementation of Computer Vision face analysis.
    In the future, this will load YOLOv8/ResNet and run inference.
    """
    return {
        "severity": "Moderate",
        "confidence": 0.85,
        "details": "Moderate acne detected with some oily skin features.",
        "detected_issues": ["Acne", "Oily Skin"]
    }
