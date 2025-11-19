// Islands (type: "ö")
// Total: 57 unique places
const islands = [
    {
        "name": "Azorerna",
        "lat": 37.7412,
        "lng": -25.6756,
        "type": "ö",
        "size": 80,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Bali",
        "lat": -8.3405,
        "lng": 115.092,
        "type": "ö",
        "size": 60,
        "difficulty": [
            "easy",
            "medium",
            "hard"
        ]
    },
    {
        "name": "Bora Bora",
        "lat": -16.5004,
        "lng": -151.7414,
        "type": "ö",
        "size": 10,
        "difficulty": [
            "medium",
            "hard"
        ]
    },
    {
        "name": "Borneo",
        "lat": 0.9619,
        "lng": 114.5548,
        "type": "ö",
        "size": 400,
        "difficulty": [
            "medium",
            "hard"
        ]
    },
    {
        "name": "Cypern",
        "lat": 35.1264,
        "lng": 33.4299,
        "type": "ö",
        "size": 80,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Fiji",
        "lat": -17.7134,
        "lng": 178.065,
        "type": "ö",
        "size": 80,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Franska Polynesien",
        "lat": -17.6797,
        "lng": -149.4068,
        "type": "ö",
        "size": 150,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Färöarna",
        "lat": 61.8926,
        "lng": -6.9118,
        "type": "ö",
        "size": 50,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Galapagosöarna",
        "lat": -0.9538,
        "lng": -90.9656,
        "type": "ö",
        "size": 100,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Gotland",
        "lat": 57.4684,
        "lng": 18.4867,
        "type": "ö",
        "size": 50,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Grönland",
        "lat": 71.7069,
        "lng": -42.6043,
        "type": "ö",
        "size": 1000,
        "difficulty": [
            "easy",
            "medium"
        ]
    },
    {
        "name": "Guam",
        "lat": 13.4443,
        "lng": 144.7937,
        "type": "ö",
        "size": 30,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Guernsey",
        "lat": 49.4657,
        "lng": -2.5853,
        "type": "ö",
        "size": 20,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Hawaii",
        "lat": 19.8968,
        "lng": -155.5828,
        "type": "ö",
        "size": 80,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Hokkaido",
        "lat": 43.0642,
        "lng": 141.3469,
        "type": "ö",
        "size": 200,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Irland",
        "lat": 53.4129,
        "lng": -8.2439,
        "type": "ö",
        "size": 150,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Island",
        "lat": 64.9631,
        "lng": -19.0208,
        "type": "ö",
        "size": 200,
        "difficulty": [
            "easy",
            "medium"
        ]
    },
    {
        "name": "Isle of Man",
        "lat": 54.2361,
        "lng": -4.5481,
        "type": "ö",
        "size": 30,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Jamaica",
        "lat": 18.1096,
        "lng": -77.2975,
        "type": "ö",
        "size": 100,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Jeju",
        "lat": 33.4996,
        "lng": 126.5312,
        "type": "ö",
        "size": 50,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Jersey",
        "lat": 49.2144,
        "lng": -2.1312,
        "type": "ö",
        "size": 20,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Kanariöarna",
        "lat": 28.2916,
        "lng": -16.6291,
        "type": "ö",
        "size": 100,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Komorerna",
        "lat": -11.6455,
        "lng": 43.3333,
        "type": "ö",
        "size": 40,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Korfu",
        "lat": 39.6243,
        "lng": 19.9217,
        "type": "ö",
        "size": 40,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Korsika",
        "lat": 42.0396,
        "lng": 9.0129,
        "type": "ö",
        "size": 70,
        "difficulty": [
            "medium",
            "hard"
        ]
    },
    {
        "name": "Kreta",
        "lat": 35.2401,
        "lng": 24.8093,
        "type": "ö",
        "size": 80,
        "difficulty": [
            "easy",
            "medium"
        ]
    },
    {
        "name": "Kuba",
        "lat": 21.5218,
        "lng": -77.7812,
        "type": "ö",
        "size": 200,
        "difficulty": [
            "easy",
            "medium"
        ]
    },
    {
        "name": "Madagaskar",
        "lat": -18.7669,
        "lng": 46.8691,
        "type": "ö",
        "size": 400,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Madeira",
        "lat": 32.7607,
        "lng": -16.9595,
        "type": "ö",
        "size": 50,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Maldiverna",
        "lat": 3.2028,
        "lng": 73.2207,
        "type": "ö",
        "size": 50,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Mallorca",
        "lat": 39.6953,
        "lng": 3.0176,
        "type": "ö",
        "size": 60,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Malta",
        "lat": 35.9375,
        "lng": 14.3754,
        "type": "ö",
        "size": 20,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Mauritius",
        "lat": -20.3484,
        "lng": 57.5522,
        "type": "ö",
        "size": 40,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Mayotte",
        "lat": -12.8275,
        "lng": 45.1662,
        "type": "ö",
        "size": 20,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Mikronesien",
        "lat": 7.4256,
        "lng": 150.5508,
        "type": "ö",
        "size": 150,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Mykonos",
        "lat": 37.4467,
        "lng": 25.3289,
        "type": "ö",
        "size": 15,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Ny Kaledonien",
        "lat": -20.9043,
        "lng": 165.618,
        "type": "ö",
        "size": 100,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Okinawa",
        "lat": 26.3344,
        "lng": 127.8056,
        "type": "ö",
        "size": 50,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Palau",
        "lat": 7.515,
        "lng": 134.5825,
        "type": "ö",
        "size": 50,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Phuket",
        "lat": 7.8804,
        "lng": 98.3923,
        "type": "ö",
        "size": 40,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Påskön",
        "lat": -27.1127,
        "lng": -109.3497,
        "type": "ö",
        "size": 15,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Réunion",
        "lat": -21.1151,
        "lng": 55.5364,
        "type": "ö",
        "size": 40,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Rhodos",
        "lat": 36.1341,
        "lng": 27.9528,
        "type": "ö",
        "size": 50,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Salomonöarna",
        "lat": -9.6457,
        "lng": 160.1562,
        "type": "ö",
        "size": 200,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Samoa",
        "lat": -13.759,
        "lng": -172.1046,
        "type": "ö",
        "size": 40,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Santorini",
        "lat": 36.3932,
        "lng": 25.4615,
        "type": "ö",
        "size": 20,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Sardinien",
        "lat": 40.1209,
        "lng": 9.0129,
        "type": "ö",
        "size": 80,
        "difficulty": [
            "easy",
            "medium"
        ]
    },
    {
        "name": "Seychellerna",
        "lat": -4.6796,
        "lng": 55.492,
        "type": "ö",
        "size": 30,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Sicilien",
        "lat": 37.5999,
        "lng": 14.0154,
        "type": "ö",
        "size": 120,
        "difficulty": [
            "easy",
            "medium"
        ]
    },
    {
        "name": "Sri Lanka",
        "lat": 7.8731,
        "lng": 80.7718,
        "type": "ö",
        "size": 150,
        "difficulty": [
            "easy",
            "medium",
            "hard"
        ]
    },
    {
        "name": "Sumatra",
        "lat": -0.5897,
        "lng": 101.3431,
        "type": "ö",
        "size": 300,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Taiwan",
        "lat": 23.6978,
        "lng": 120.9605,
        "type": "ö",
        "size": 100,
        "difficulty": [
            "easy",
            "medium"
        ]
    },
    {
        "name": "Tasmanien",
        "lat": -41.4545,
        "lng": 145.9707,
        "type": "ö",
        "size": 150,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Tonga",
        "lat": -21.1789,
        "lng": -175.1982,
        "type": "ö",
        "size": 50,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Vanuatu",
        "lat": -15.3767,
        "lng": 166.9592,
        "type": "ö",
        "size": 100,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Zanzibar",
        "lat": -6.1659,
        "lng": 39.2026,
        "type": "ö",
        "size": 60,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Öland",
        "lat": 56.7167,
        "lng": 16.65,
        "type": "ö",
        "size": 40,
        "difficulty": [
            "hard"
        ]
    }
];

export default islands;
