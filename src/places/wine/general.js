// General wine regions (type: "vin")
// Total: 48 unique places
const generalWineRegions = [
    {
        "name": "Alentejo, Portugal",
        "lat": 38.5667,
        "lng": -7.9,
        "type": "vin",
        "size": 120,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Alsace, Frankrike",
        "lat": 48.3181,
        "lng": 7.4416,
        "type": "vin",
        "size": 80,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Amarone/Valpolicella, Italien",
        "lat": 45.5333,
        "lng": 10.8833,
        "type": "vin",
        "size": 30,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Barolo, Italien",
        "lat": 44.6107,
        "lng": 7.9464,
        "type": "vin",
        "size": 10,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Barossa Valley, Australien",
        "lat": -34.5331,
        "lng": 138.9978,
        "type": "vin",
        "size": 50,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Beaujolais, Frankrike",
        "lat": 46.1667,
        "lng": 4.6333,
        "type": "vin",
        "size": 50,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Bordeaux, Frankrike",
        "lat": 44.8378,
        "lng": -0.5792,
        "type": "vin",
        "size": 80,
        "difficulty": [
            "easy",
            "medium"
        ]
    },
    {
        "name": "Brunello di Montalcino, Italien",
        "lat": 43.0567,
        "lng": 11.4933,
        "type": "vin",
        "size": 15,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Burgund, Frankrike",
        "lat": 47.05,
        "lng": 4.85,
        "type": "vin",
        "size": 100,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Carneros, USA",
        "lat": 38.25,
        "lng": -122.3667,
        "type": "vin",
        "size": 20,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Casablanca Valley, Chile",
        "lat": -33.3167,
        "lng": -71.4,
        "type": "vin",
        "size": 50,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Chablis, Burgund",
        "lat": 47.8167,
        "lng": 3.8,
        "type": "vin",
        "size": 20,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Champagne, Frankrike",
        "lat": 49.042,
        "lng": 4.036,
        "type": "vin",
        "size": 120,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Châteauneuf-du-Pape, Rhône",
        "lat": 44.0575,
        "lng": 4.8317,
        "type": "vin",
        "size": 12,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Chianti Classico, Italien",
        "lat": 43.5833,
        "lng": 11.3667,
        "type": "vin",
        "size": 40,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Chianti Rufina, Toscana",
        "lat": 43.8333,
        "lng": 11.4667,
        "type": "vin",
        "size": 15,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Côte d'Or, Burgund",
        "lat": 47.05,
        "lng": 4.85,
        "type": "vin",
        "size": 40,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Douro Valley, Portugal",
        "lat": 41.1621,
        "lng": -7.55,
        "type": "vin",
        "size": 100,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Franken, Tyskland",
        "lat": 49.75,
        "lng": 10,
        "type": "vin",
        "size": 80,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Gevrey-Chambertin, Burgund",
        "lat": 47.2267,
        "lng": 4.9644,
        "type": "vin",
        "size": 8,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Jerez, Spanien",
        "lat": 36.6833,
        "lng": -6.1333,
        "type": "vin",
        "size": 25,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Loire-dalen, Frankrike",
        "lat": 47.4,
        "lng": 0.7,
        "type": "vin",
        "size": 200,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Maipo Valley, Chile",
        "lat": -33.5,
        "lng": -70.75,
        "type": "vin",
        "size": 70,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Margaret River, Australien",
        "lat": -33.95,
        "lng": 115.0833,
        "type": "vin",
        "size": 80,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Marlborough, Nya Zeeland",
        "lat": -41.5167,
        "lng": 173.9667,
        "type": "vin",
        "size": 60,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Mendoza, Argentina",
        "lat": -33,
        "lng": -68.8333,
        "type": "vin",
        "size": 150,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Meursault, Burgund",
        "lat": 46.9792,
        "lng": 4.7744,
        "type": "vin",
        "size": 8,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Montepulciano d'Abruzzo, Italien",
        "lat": 42.4,
        "lng": 14,
        "type": "vin",
        "size": 40,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Mosel, Tyskland",
        "lat": 50,
        "lng": 7,
        "type": "vin",
        "size": 100,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Napa Valley, USA",
        "lat": 38.5025,
        "lng": -122.4167,
        "type": "vin",
        "size": 60,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Piemonte, Italien",
        "lat": 45.0522,
        "lng": 7.5153,
        "type": "vin",
        "size": 120,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Priorat, Spanien",
        "lat": 41.15,
        "lng": 0.8333,
        "type": "vin",
        "size": 25,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Prosecco, Veneto",
        "lat": 45.9,
        "lng": 12.25,
        "type": "vin",
        "size": 35,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Rheingau, Tyskland",
        "lat": 50,
        "lng": 8.0833,
        "type": "vin",
        "size": 40,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Rhônedalen, Frankrike",
        "lat": 44.1833,
        "lng": 4.8333,
        "type": "vin",
        "size": 150,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Rías Baixas Albariño, Spanien",
        "lat": 42.5,
        "lng": -8.75,
        "type": "vin",
        "size": 40,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Rías Baixas, Spanien",
        "lat": 42.5,
        "lng": -8.75,
        "type": "vin",
        "size": 50,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Ribera del Duero, Spanien",
        "lat": 41.6333,
        "lng": -4.0167,
        "type": "vin",
        "size": 60,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Riesling, Alsace",
        "lat": 48.3181,
        "lng": 7.4416,
        "type": "vin",
        "size": 50,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Rioja, Spanien",
        "lat": 42.35,
        "lng": -2.6,
        "type": "vin",
        "size": 100,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Soave, Veneto",
        "lat": 45.4167,
        "lng": 11.25,
        "type": "vin",
        "size": 20,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Sonoma, USA",
        "lat": 38.2919,
        "lng": -122.458,
        "type": "vin",
        "size": 50,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Stellenbosch, Sydafrika",
        "lat": -33.9321,
        "lng": 18.8602,
        "type": "vin",
        "size": 40,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Toro, Spanien",
        "lat": 41.5236,
        "lng": -5.3978,
        "type": "vin",
        "size": 20,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Toscana, Italien",
        "lat": 43.7711,
        "lng": 11.2486,
        "type": "vin",
        "size": 150,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Vinho Verde, Portugal",
        "lat": 41.5,
        "lng": -8.5,
        "type": "vin",
        "size": 80,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Vosne-Romanée, Burgund",
        "lat": 47.1606,
        "lng": 4.9594,
        "type": "vin",
        "size": 6,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Willamette Valley, USA",
        "lat": 45.0833,
        "lng": -123.0833,
        "type": "vin",
        "size": 80,
        "difficulty": [
            "medium"
        ]
    }
];

export default generalWineRegions;
