# pyrefly: ignore [missing-import]
from sqlalchemy.orm import Session
from database.database import SessionLocal
from database.models import Product

def get_recommendation(cv_results: dict) -> list:
    """
    Real recommendation engine.
    Fetches products from the SQLite database that match the detected issues.
    """
    db: Session = SessionLocal()
    try:
        # Simplistic recommendation logic based on skin concerns and active ingredients
        detected_issues = cv_results.get("detected_issues", [])
        
        # Query all products
        all_products = db.query(Product).all()
        
        recommended = []
        for p in all_products:
            score = 0
            match_reason = []
            
            # Match logic: if product concern matches any of the detected issues
            if p.skin_concern:
                for issue in detected_issues:
                    if issue.lower() in p.skin_concern.lower():
                        score += 10
                        match_reason.append(f"Cocok untuk mengatasi {issue}")
            
            if score > 0:
                recommended.append({
                    "product": p,
                    "score": score,
                    "reason": " dan ".join(match_reason)
                })
        
        # Sort by score descending and take top 2
        recommended.sort(key=lambda x: x["score"], reverse=True)
        top_recs = recommended[:2]
        
        results = []
        for rec in top_recs:
            p = rec["product"]
            results.append({
                "product_name": p.product_name,
                "brand": p.brand,
                "category": p.category,
                "ingredients": p.active_ingredients or p.ingredients[:50],
                "reason": f"Produk ini direkomendasikan karena: {rec['reason']}. Diperkaya dengan {p.active_ingredients}."
            })
            
        # Fallback if no match
        if not results:
            results.append({
                "product_name": "Wardah Acnederm Pure Foaming Cleanser",
                "brand": "Wardah",
                "category": "Cleanser",
                "ingredients": "Salicylic Acid",
                "reason": "Rekomendasi umum untuk perawatan dasar kulit Anda."
            })
            
        return results
    finally:
        db.close()
