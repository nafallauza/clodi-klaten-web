from sqlalchemy import Column, Integer, String, Float, Text
from .database import Base

class Product(Base):
    __tablename__ = "products"

    id = Column(Integer, primary_key=True, index=True)
    product_name = Column(String, index=True)
    brand = Column(String, index=True)
    category = Column(String, index=True)
    skin_type = Column(String)       # e.g., "Oily, Dry, Combination"
    skin_concern = Column(String)    # e.g., "Acne, Dullness, Aging"
    ingredients = Column(Text)
    active_ingredients = Column(Text)
    benefits = Column(Text)
    texture = Column(String)
    fragrance = Column(String)
    bpom_status = Column(String)
    price = Column(Float)
    rating = Column(Float)
    total_reviews = Column(Integer)
    source_dataset = Column(String)
