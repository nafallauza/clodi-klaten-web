import os
import sys
import pandas as pd
from sqlalchemy.orm import Session

# Add the parent directory to the path so we can import the database modules
sys.path.append(os.path.dirname(os.path.dirname(os.path.abspath(__file__))))

from database.database import engine, SessionLocal, Base
from database.models import Product

def create_dummy_dataset(dummy_path: str):
    """Creates a dummy CSV dataset if none exists."""
    print("Creating dummy dataset...")
    data = {
        "product_name": ["Avoskin Miraculous Refining Toner", "Somethinc Niacinamide Moisture Sabi Beet Serum", "Wardah Acnederm Pure Foaming Cleanser"],
        "brand": ["Avoskin", "Somethinc", "Wardah"],
        "category": ["Toner", "Serum", "Cleanser"],
        "skin_type": ["All, Oily, Acne Prone", "All", "Oily, Acne Prone"],
        "skin_concern": ["Acne, Dullness", "Dullness, Acne, Sebum", "Acne, Oily"],
        "ingredients": ["Water, Glycerin, AHA, BHA, PHA, Niacinamide...", "Water, Niacinamide, Sabi Beet Extract...", "Water, Salicylic Acid, Glycerin..."],
        "active_ingredients": ["AHA, BHA, PHA, Niacinamide", "Niacinamide, Sabi Beet", "Salicylic Acid"],
        "benefits": ["Exfoliating, Brightening, Acne care", "Brightening, Sebum control", "Cleansing, Acne care"],
        "texture": ["Liquid", "Viscous liquid", "Foam"],
        "fragrance": ["None", "None", "Mild"],
        "bpom_status": ["Registered", "Registered", "Registered"],
        "price": [189000, 115000, 25000],
        "rating": [4.8, 4.7, 4.5],
        "total_reviews": [1500, 2000, 800],
        "source_dataset": ["dummy", "dummy", "dummy"]
    }
    df = pd.DataFrame(data)
    df.to_csv(dummy_path, index=False)
    return df

def preprocess_and_load(dataset_dir: str):
    # Initialize DB schema
    Base.metadata.create_all(bind=engine)
    db: Session = SessionLocal()

    # Look for any CSV files in the dataset directory
    csv_files = [f for f in os.listdir(dataset_dir) if f.endswith(".csv")]
    
    if not csv_files:
        print(f"No CSV files found in {dataset_dir}. Generating dummy dataset for testing.")
        dummy_path = os.path.join(dataset_dir, "dummy_dataset.csv")
        df = create_dummy_dataset(dummy_path)
    else:
        # Load the first found CSV for preprocessing (in a real scenario, we'd process all or specific ones)
        file_path = os.path.join(dataset_dir, csv_files[0])
        print(f"Processing dataset: {file_path}")
        df = pd.read_csv(file_path)

    # Clean data: fill NaN with None (which translates to NULL in SQLite)
    df = df.where(pd.notnull(df), None)

    # Clear existing data for idempotency
    db.query(Product).delete()
    
    # Load into SQLite
    products_to_add = []
    for _, row in df.iterrows():
        # Map columns gracefully (in case actual dataset lacks some columns)
        p = Product(
            product_name=row.get("product_name"),
            brand=row.get("brand"),
            category=row.get("category"),
            skin_type=row.get("skin_type"),
            skin_concern=row.get("skin_concern"),
            ingredients=row.get("ingredients"),
            active_ingredients=row.get("active_ingredients"),
            benefits=row.get("benefits"),
            texture=row.get("texture"),
            fragrance=row.get("fragrance"),
            bpom_status=row.get("bpom_status"),
            price=row.get("price"),
            rating=row.get("rating"),
            total_reviews=row.get("total_reviews"),
            source_dataset=row.get("source_dataset", "unknown")
        )
        products_to_add.append(p)

    db.add_all(products_to_add)
    db.commit()
    db.close()
    print(f"Successfully loaded {len(products_to_add)} products into the SQLite database.")

if __name__ == "__main__":
    base_dir = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
    dataset_dir = os.path.join(os.path.dirname(base_dir), "dataset", "skincare")
    preprocess_and_load(dataset_dir)
