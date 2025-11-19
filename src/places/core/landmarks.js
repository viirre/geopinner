// Landmarks and places (type: "plats")
// Total: 66 unique places
const landmarks = [
    {
        "name": "Akropolis",
        "lat": 37.9715,
        "lng": 23.7269,
        "type": "plats",
        "size": 1,
        "difficulty": [
            "easy",
            "medium"
        ]
    },
    {
        "name": "Akropolis, Aten",
        "lat": 37.9715,
        "lng": 23.7257,
        "type": "plats",
        "size": 1,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Alhambra",
        "lat": 37.176,
        "lng": -3.5881,
        "type": "plats",
        "size": 1,
        "difficulty": [
            "easy",
            "medium",
            "hard"
        ]
    },
    {
        "name": "Amazonas",
        "lat": -3.4653,
        "lng": -62.2159,
        "type": "plats",
        "size": 1500,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Angkor Wat",
        "lat": 13.4125,
        "lng": 103.867,
        "type": "plats",
        "size": 2,
        "difficulty": [
            "medium",
            "hard"
        ]
    },
    {
        "name": "Angkor Wat, Kambodja",
        "lat": 13.4125,
        "lng": 103.867,
        "type": "plats",
        "size": 5,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Ayers Rock/Uluru",
        "lat": -25.3444,
        "lng": 131.0369,
        "type": "plats",
        "size": 3,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Big Ben",
        "lat": 51.5007,
        "lng": -0.1246,
        "type": "plats",
        "size": 1,
        "difficulty": [
            "easy",
            "medium"
        ]
    },
    {
        "name": "Big Ben, London",
        "lat": 51.5007,
        "lng": -0.1246,
        "type": "plats",
        "size": 1,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Borobudur",
        "lat": -7.6079,
        "lng": 110.2038,
        "type": "plats",
        "size": 2,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Brandenburg Gate",
        "lat": 52.5163,
        "lng": 13.3777,
        "type": "plats",
        "size": 1,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Burj Khalifa",
        "lat": 25.1972,
        "lng": 55.2744,
        "type": "plats",
        "size": 1,
        "difficulty": [
            "easy",
            "medium",
            "hard"
        ]
    },
    {
        "name": "Chichen Itza",
        "lat": 20.6843,
        "lng": -88.5678,
        "type": "plats",
        "size": 1,
        "difficulty": [
            "medium",
            "hard"
        ]
    },
    {
        "name": "Christoförlösaren",
        "lat": -22.9519,
        "lng": -43.2105,
        "type": "plats",
        "size": 1,
        "difficulty": [
            "medium",
            "hard"
        ]
    },
    {
        "name": "CN Tower",
        "lat": 43.6426,
        "lng": -79.3871,
        "type": "plats",
        "size": 1,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Colosseum",
        "lat": 41.8902,
        "lng": 12.4922,
        "type": "plats",
        "size": 1,
        "difficulty": [
            "medium",
            "hard"
        ]
    },
    {
        "name": "Duomo di Milano",
        "lat": 45.4642,
        "lng": 9.19,
        "type": "plats",
        "size": 1,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Eiffeltornet",
        "lat": 48.8584,
        "lng": 2.2945,
        "type": "plats",
        "size": 1,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Forbidden City",
        "lat": 39.9163,
        "lng": 116.3972,
        "type": "plats",
        "size": 2,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Forntida Forum Romanum",
        "lat": 41.8925,
        "lng": 12.4853,
        "type": "plats",
        "size": 1,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Frihetsgudinnan",
        "lat": 40.6892,
        "lng": -74.0445,
        "type": "plats",
        "size": 1,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Golden Gate Bridge",
        "lat": 37.8199,
        "lng": -122.4783,
        "type": "plats",
        "size": 2,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Grand Canyon",
        "lat": 36.1069,
        "lng": -112.1129,
        "type": "plats",
        "size": 30,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Grand Canyon, USA",
        "lat": 36.1069,
        "lng": -112.1129,
        "type": "plats",
        "size": 80,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Hagia Sophia",
        "lat": 41.0086,
        "lng": 28.9802,
        "type": "plats",
        "size": 1,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Hermitage",
        "lat": 59.9398,
        "lng": 30.3146,
        "type": "plats",
        "size": 1,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Kilimanjaro",
        "lat": -3.0674,
        "lng": 37.3556,
        "type": "plats",
        "size": 5,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Kinesiska muren",
        "lat": 40.4319,
        "lng": 116.5704,
        "type": "plats",
        "size": 100,
        "difficulty": [
            "easy",
            "medium"
        ]
    },
    {
        "name": "Kreml, Moskva",
        "lat": 55.752,
        "lng": 37.6175,
        "type": "plats",
        "size": 2,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Kremlin",
        "lat": 55.752,
        "lng": 37.6175,
        "type": "plats",
        "size": 1,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Louvren",
        "lat": 48.8606,
        "lng": 2.3376,
        "type": "plats",
        "size": 1,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Lutande tornet i Pisa",
        "lat": 43.723,
        "lng": 10.3966,
        "type": "plats",
        "size": 1,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Machu Picchu",
        "lat": -13.1631,
        "lng": -72.545,
        "type": "plats",
        "size": 1,
        "difficulty": [
            "medium",
            "hard"
        ]
    },
    {
        "name": "Machu Picchu, Peru",
        "lat": -13.1631,
        "lng": -72.545,
        "type": "plats",
        "size": 3,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Matterhorn",
        "lat": 45.9763,
        "lng": 7.6586,
        "type": "plats",
        "size": 5,
        "difficulty": [
            "medium",
            "hard"
        ]
    },
    {
        "name": "Moai på Påskön",
        "lat": -27.1127,
        "lng": -109.3497,
        "type": "plats",
        "size": 2,
        "difficulty": [
            "medium",
            "hard"
        ]
    },
    {
        "name": "Mont Blanc",
        "lat": 45.8326,
        "lng": 6.8652,
        "type": "plats",
        "size": 5,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Mont Saint-Michel",
        "lat": 48.6361,
        "lng": -1.5115,
        "type": "plats",
        "size": 1,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Mont-Blanc",
        "lat": 45.8326,
        "lng": 6.8652,
        "type": "plats",
        "size": 5,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Mount Everest",
        "lat": 27.9881,
        "lng": 86.925,
        "type": "plats",
        "size": 10,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Neuschwanstein",
        "lat": 47.5576,
        "lng": 10.7498,
        "type": "plats",
        "size": 1,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Niagara Falls",
        "lat": 43.0828,
        "lng": -79.0763,
        "type": "plats",
        "size": 2,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Niagarafallen",
        "lat": 43.0828,
        "lng": -79.0763,
        "type": "plats",
        "size": 5,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Nordpolen",
        "lat": 90,
        "lng": 0,
        "type": "plats",
        "size": 50,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Notre-Dame",
        "lat": 48.853,
        "lng": 2.3499,
        "type": "plats",
        "size": 1,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Operahuset i Sydney",
        "lat": -33.8568,
        "lng": 151.2153,
        "type": "plats",
        "size": 1,
        "difficulty": [
            "easy",
            "medium"
        ]
    },
    {
        "name": "Petra",
        "lat": 30.3285,
        "lng": 35.4444,
        "type": "plats",
        "size": 2,
        "difficulty": [
            "easy",
            "medium",
            "hard"
        ]
    },
    {
        "name": "Petra, Jordanien",
        "lat": 30.3285,
        "lng": 35.4444,
        "type": "plats",
        "size": 5,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Potala Palace",
        "lat": 29.6558,
        "lng": 91.1173,
        "type": "plats",
        "size": 1,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Pyramiderna i Giza",
        "lat": 29.9792,
        "lng": 31.1342,
        "type": "plats",
        "size": 2,
        "difficulty": [
            "easy",
            "medium"
        ]
    },
    {
        "name": "Sagrada Familia",
        "lat": 41.4036,
        "lng": 2.1744,
        "type": "plats",
        "size": 1,
        "difficulty": [
            "easy",
            "medium"
        ]
    },
    {
        "name": "Sagrada Familia, Barcelona",
        "lat": 41.4036,
        "lng": 2.1744,
        "type": "plats",
        "size": 1,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Sahara",
        "lat": 23.4162,
        "lng": 25.6628,
        "type": "plats",
        "size": 2000,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Saint Basil's Cathedral",
        "lat": 55.7525,
        "lng": 37.6231,
        "type": "plats",
        "size": 1,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Space Needle",
        "lat": 47.6205,
        "lng": -122.3493,
        "type": "plats",
        "size": 1,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Stonehenge",
        "lat": 51.1789,
        "lng": -1.8262,
        "type": "plats",
        "size": 1,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Stonehenge, England",
        "lat": 51.1789,
        "lng": -1.8262,
        "type": "plats",
        "size": 1,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Taj Mahal",
        "lat": 27.1751,
        "lng": 78.0421,
        "type": "plats",
        "size": 1,
        "difficulty": [
            "easy",
            "medium"
        ]
    },
    {
        "name": "Topkapi Palace",
        "lat": 41.0115,
        "lng": 28.9833,
        "type": "plats",
        "size": 1,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Tower Bridge",
        "lat": 51.5055,
        "lng": -0.0754,
        "type": "plats",
        "size": 1,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Triumfbågen",
        "lat": 48.8738,
        "lng": 2.295,
        "type": "plats",
        "size": 1,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Vatikanstaten",
        "lat": 41.9029,
        "lng": 12.4534,
        "type": "plats",
        "size": 1,
        "difficulty": [
            "easy",
            "medium"
        ]
    },
    {
        "name": "Versailles",
        "lat": 48.8049,
        "lng": 2.1204,
        "type": "plats",
        "size": 2,
        "difficulty": [
            "medium",
            "hard"
        ]
    },
    {
        "name": "Versailles, Frankrike",
        "lat": 48.8049,
        "lng": 2.1204,
        "type": "plats",
        "size": 3,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Victoria Falls",
        "lat": -17.9243,
        "lng": 25.8572,
        "type": "plats",
        "size": 3,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Westminster Abbey",
        "lat": 51.4993,
        "lng": -0.1273,
        "type": "plats",
        "size": 1,
        "difficulty": [
            "hard"
        ]
    }
];

export default landmarks;
