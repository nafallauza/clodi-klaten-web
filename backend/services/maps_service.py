import os

def find_nearby_dermatologist(lat: float, lng: float) -> list:
    """
    Mock service to find nearby dermatologists using Google Places API.
    Currently returns dummy data.
    """
    # In the future:
    # api_key = os.getenv("MAPS_API_KEY")
    # if api_key: ...
    
    return [
        {
            "name": "Klinik Estetika Erha",
            "rating": 4.8,
            "address": "Jl. Raya Dummy No. 123, Jakarta",
            "operating_hours": "09:00 - 20:00",
            "maps_url": "https://maps.google.com/?q=Klinik+Estetika+Erha"
        },
        {
            "name": "Natasha Skin Clinic Center",
            "rating": 4.6,
            "address": "Mall Dummy Lt. 2, Jakarta",
            "operating_hours": "10:00 - 21:00",
            "maps_url": "https://maps.google.com/?q=Natasha+Skin+Clinic"
        }
    ]
