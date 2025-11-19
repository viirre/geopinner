// Cities (type: "stad")
// Total: 222 unique places
const cities = [
    {
        "name": "Addis Abeba, Etiopien",
        "lat": 9.032,
        "lng": 38.7469,
        "type": "stad",
        "capital": true,
        "size": 12,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Almaty, Kazakstan",
        "lat": 43.222,
        "lng": 76.8512,
        "type": "stad",
        "size": 10,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Amman, Jordanien",
        "lat": 31.9454,
        "lng": 35.9284,
        "type": "stad",
        "size": 10,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Amsterdam, Nederländerna",
        "lat": 52.3676,
        "lng": 4.9041,
        "type": "stad",
        "capital": true,
        "size": 10,
        "difficulty": [
            "easy",
            "medium"
        ]
    },
    {
        "name": "Ankara, Turkiet",
        "lat": 39.9334,
        "lng": 32.8597,
        "type": "stad",
        "capital": true,
        "size": 15,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Antananarivo, Madagaskar",
        "lat": -18.8792,
        "lng": 47.5079,
        "type": "stad",
        "size": 10,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Antwerpen, Belgien",
        "lat": 51.2194,
        "lng": 4.4025,
        "type": "stad",
        "size": 10,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Apia, Samoa",
        "lat": -13.8333,
        "lng": -171.7667,
        "type": "stad",
        "size": 5,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Ashgabat, Turkmenistan",
        "lat": 37.9601,
        "lng": 58.3261,
        "type": "stad",
        "size": 8,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Asmara, Eritrea",
        "lat": 15.3229,
        "lng": 38.9251,
        "type": "stad",
        "size": 8,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Astana, Kazakstan",
        "lat": 51.1694,
        "lng": 71.4491,
        "type": "stad",
        "size": 10,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Asunción, Paraguay",
        "lat": -25.2637,
        "lng": -57.5759,
        "type": "stad",
        "size": 10,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Aten, Grekland",
        "lat": 37.9838,
        "lng": 23.7275,
        "type": "stad",
        "capital": true,
        "size": 12,
        "difficulty": [
            "easy",
            "medium"
        ]
    },
    {
        "name": "Auckland, Nya Zeeland",
        "lat": -36.8485,
        "lng": 174.7633,
        "type": "stad",
        "size": 12,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Bagdad, Irak",
        "lat": 33.3152,
        "lng": 44.3661,
        "type": "stad",
        "size": 12,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Baku, Azerbajdzjan",
        "lat": 40.4093,
        "lng": 49.8671,
        "type": "stad",
        "size": 10,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Bamako, Mali",
        "lat": 12.6392,
        "lng": -8.0029,
        "type": "stad",
        "size": 10,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Bangalore, Indien",
        "lat": 12.9716,
        "lng": 77.5946,
        "type": "stad",
        "size": 15,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Bangkok, Thailand",
        "lat": 13.7563,
        "lng": 100.5018,
        "type": "stad",
        "capital": true,
        "size": 15,
        "difficulty": [
            "easy",
            "medium",
            "hard"
        ]
    },
    {
        "name": "Bangui, Centralafrikanska republiken",
        "lat": 4.3947,
        "lng": 18.5582,
        "type": "stad",
        "size": 8,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Banjul, Gambia",
        "lat": 13.4549,
        "lng": -16.579,
        "type": "stad",
        "size": 6,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Barcelona, Spanien",
        "lat": 41.3851,
        "lng": 2.1734,
        "type": "stad",
        "size": 12,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Beirut, Libanon",
        "lat": 33.8886,
        "lng": 35.4955,
        "type": "stad",
        "size": 8,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Belgrad, Serbien",
        "lat": 44.7866,
        "lng": 20.4489,
        "type": "stad",
        "size": 10,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Belmopan, Belize",
        "lat": 17.251,
        "lng": -88.759,
        "type": "stad",
        "size": 5,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Bergen, Norge",
        "lat": 60.3913,
        "lng": 5.3221,
        "type": "stad",
        "size": 10,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Berlin, Tyskland",
        "lat": 52.52,
        "lng": 13.405,
        "type": "stad",
        "capital": true,
        "size": 15,
        "difficulty": [
            "easy",
            "medium"
        ]
    },
    {
        "name": "Bilbao, Spanien",
        "lat": 43.263,
        "lng": -2.935,
        "type": "stad",
        "size": 10,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Bishkek, Kirgizistan",
        "lat": 42.8746,
        "lng": 74.5698,
        "type": "stad",
        "size": 8,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Bogotá, Colombia",
        "lat": 4.711,
        "lng": -74.0721,
        "type": "stad",
        "capital": true,
        "size": 15,
        "difficulty": [
            "medium",
            "hard"
        ]
    },
    {
        "name": "Bologna, Italien",
        "lat": 44.4949,
        "lng": 11.3426,
        "type": "stad",
        "size": 10,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Boston, USA",
        "lat": 42.3601,
        "lng": -71.0589,
        "type": "stad",
        "size": 12,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Bratislava, Slovakien",
        "lat": 48.1486,
        "lng": 17.1077,
        "type": "stad",
        "size": 8,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Brazzaville, Kongo",
        "lat": -4.2634,
        "lng": 15.2429,
        "type": "stad",
        "size": 10,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Bridgetown, Barbados",
        "lat": 13.1132,
        "lng": -59.5988,
        "type": "stad",
        "size": 6,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Brisbane, Australien",
        "lat": -27.4698,
        "lng": 153.0251,
        "type": "stad",
        "size": 12,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Bryssel, Belgien",
        "lat": 50.8503,
        "lng": 4.3517,
        "type": "stad",
        "capital": true,
        "size": 10,
        "difficulty": [
            "easy",
            "medium"
        ]
    },
    {
        "name": "Budapest, Ungern",
        "lat": 47.4979,
        "lng": 19.0402,
        "type": "stad",
        "capital": true,
        "size": 10,
        "difficulty": [
            "easy",
            "medium",
            "hard"
        ]
    },
    {
        "name": "Buenos Aires, Argentina",
        "lat": -34.6037,
        "lng": -58.3816,
        "type": "stad",
        "capital": true,
        "size": 15,
        "difficulty": [
            "easy",
            "medium"
        ]
    },
    {
        "name": "Bukarest, Rumänien",
        "lat": 44.4268,
        "lng": 26.1025,
        "type": "stad",
        "size": 10,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Caracas, Venezuela",
        "lat": 10.4806,
        "lng": -66.9036,
        "type": "stad",
        "capital": true,
        "size": 12,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Casablanca, Marocko",
        "lat": 33.5731,
        "lng": -7.5898,
        "type": "stad",
        "size": 12,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Castries, Saint Lucia",
        "lat": 14.0101,
        "lng": -60.9875,
        "type": "stad",
        "size": 5,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Cayenne, Franska Guyana",
        "lat": 4.9333,
        "lng": -52.3333,
        "type": "stad",
        "size": 6,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Chengdu, Kina",
        "lat": 30.5728,
        "lng": 104.0668,
        "type": "stad",
        "size": 15,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Chicago, USA",
        "lat": 41.8781,
        "lng": -87.6298,
        "type": "stad",
        "size": 18,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Chișinău, Moldavien",
        "lat": 47.0105,
        "lng": 28.8638,
        "type": "stad",
        "size": 8,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Colombo, Sri Lanka",
        "lat": 6.9271,
        "lng": 79.8612,
        "type": "stad",
        "size": 10,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Damaskus, Syrien",
        "lat": 33.5138,
        "lng": 36.2765,
        "type": "stad",
        "size": 10,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Dar es Salaam, Tanzania",
        "lat": -6.7924,
        "lng": 39.2083,
        "type": "stad",
        "size": 12,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Delhi, Indien",
        "lat": 28.7041,
        "lng": 77.1025,
        "type": "stad",
        "capital": true,
        "size": 22,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Den Haag, Nederländerna",
        "lat": 52.0705,
        "lng": 4.3007,
        "type": "stad",
        "size": 10,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Dhaka, Bangladesh",
        "lat": 23.8103,
        "lng": 90.4125,
        "type": "stad",
        "capital": true,
        "size": 15,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Dili, Östtimor",
        "lat": -8.5569,
        "lng": 125.5603,
        "type": "stad",
        "size": 6,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Djibouti, Djibouti",
        "lat": 11.8251,
        "lng": 42.5903,
        "type": "stad",
        "size": 6,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Doha, Qatar",
        "lat": 25.2854,
        "lng": 51.531,
        "type": "stad",
        "size": 10,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Douglas, Isle of Man",
        "lat": 54.15,
        "lng": -4.4833,
        "type": "stad",
        "size": 5,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Dresden, Tyskland",
        "lat": 51.0504,
        "lng": 13.7373,
        "type": "stad",
        "size": 10,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Dubai, UAE",
        "lat": 25.2048,
        "lng": 55.2708,
        "type": "stad",
        "size": 12,
        "difficulty": [
            "medium",
            "hard"
        ]
    },
    {
        "name": "Dublin, Irland",
        "lat": 53.3498,
        "lng": -6.2603,
        "type": "stad",
        "capital": true,
        "size": 10,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Dushanbe, Tadzjikistan",
        "lat": 38.5598,
        "lng": 68.7738,
        "type": "stad",
        "size": 8,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Edinburgh, Skottland",
        "lat": 55.9533,
        "lng": -3.1883,
        "type": "stad",
        "size": 8,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Florens, Italien",
        "lat": 43.7696,
        "lng": 11.2558,
        "type": "stad",
        "size": 10,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Frankfurt, Tyskland",
        "lat": 50.1109,
        "lng": 8.6821,
        "type": "stad",
        "size": 12,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Gaborone, Botswana",
        "lat": -24.6282,
        "lng": 25.9231,
        "type": "stad",
        "size": 8,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Genève, Schweiz",
        "lat": 46.2044,
        "lng": 6.1432,
        "type": "stad",
        "size": 8,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Georgetown, Guyana",
        "lat": 6.8013,
        "lng": -58.1551,
        "type": "stad",
        "size": 8,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Granada, Spanien",
        "lat": 37.1773,
        "lng": -3.5986,
        "type": "stad",
        "size": 8,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Guangzhou, Kina",
        "lat": 23.1291,
        "lng": 113.2644,
        "type": "stad",
        "size": 18,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Guatemala City, Guatemala",
        "lat": 14.6349,
        "lng": -90.5069,
        "type": "stad",
        "size": 12,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Guayaquil, Ecuador",
        "lat": -2.1894,
        "lng": -79.8886,
        "type": "stad",
        "size": 12,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Göteborg, Sverige",
        "lat": 57.7089,
        "lng": 11.9746,
        "type": "stad",
        "size": 12,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Hamburg, Tyskland",
        "lat": 53.5511,
        "lng": 9.9937,
        "type": "stad",
        "size": 15,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Hanoi, Vietnam",
        "lat": 21.0285,
        "lng": 105.8542,
        "type": "stad",
        "capital": true,
        "size": 12,
        "difficulty": [
            "medium",
            "hard"
        ]
    },
    {
        "name": "Harare, Zimbabwe",
        "lat": -17.8252,
        "lng": 31.0335,
        "type": "stad",
        "size": 10,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Helsingfors, Finland",
        "lat": 60.1695,
        "lng": 24.9354,
        "type": "stad",
        "capital": true,
        "size": 10,
        "difficulty": [
            "easy",
            "medium"
        ]
    },
    {
        "name": "Ho Chi Minh-staden, Vietnam",
        "lat": 10.8231,
        "lng": 106.6297,
        "type": "stad",
        "size": 15,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Hongkong",
        "lat": 22.3193,
        "lng": 114.1694,
        "type": "stad",
        "size": 12,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Istanbul, Turkiet",
        "lat": 41.0082,
        "lng": 28.9784,
        "type": "stad",
        "size": 18,
        "difficulty": [
            "easy",
            "medium"
        ]
    },
    {
        "name": "Jakarta, Indonesien",
        "lat": -6.2088,
        "lng": 106.8456,
        "type": "stad",
        "capital": true,
        "size": 18,
        "difficulty": [
            "easy",
            "medium",
            "hard"
        ]
    },
    {
        "name": "Jerusalem",
        "lat": 31.7683,
        "lng": 35.2137,
        "type": "stad",
        "size": 8,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Johannesburg, Sydafrika",
        "lat": -26.2041,
        "lng": 28.0473,
        "type": "stad",
        "size": 15,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Juba, Sydsudan",
        "lat": 4.8517,
        "lng": 31.5825,
        "type": "stad",
        "size": 8,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Kabul, Afghanistan",
        "lat": 34.5553,
        "lng": 69.2075,
        "type": "stad",
        "size": 10,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Kairo, Egypten",
        "lat": 30.0444,
        "lng": 31.2357,
        "type": "stad",
        "capital": true,
        "size": 18,
        "difficulty": [
            "easy",
            "medium"
        ]
    },
    {
        "name": "Kampala, Uganda",
        "lat": 0.3476,
        "lng": 32.5825,
        "type": "stad",
        "size": 10,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Kapstaden, Sydafrika",
        "lat": -33.9249,
        "lng": 18.4241,
        "type": "stad",
        "size": 12,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Karachi, Pakistan",
        "lat": 24.8607,
        "lng": 67.0011,
        "type": "stad",
        "size": 18,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Kathmandu, Nepal",
        "lat": 27.7172,
        "lng": 85.324,
        "type": "stad",
        "size": 10,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Khartoum, Sudan",
        "lat": 15.5007,
        "lng": 32.5599,
        "type": "stad",
        "size": 12,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Kiev, Ukraina",
        "lat": 50.4501,
        "lng": 30.5234,
        "type": "stad",
        "size": 12,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Kigali, Rwanda",
        "lat": -1.9706,
        "lng": 30.1044,
        "type": "stad",
        "size": 8,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Kingstown, Saint Vincent",
        "lat": 13.1579,
        "lng": -61.2248,
        "type": "stad",
        "size": 5,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Kinshasa, DR Kongo",
        "lat": -4.3276,
        "lng": 15.3136,
        "type": "stad",
        "size": 15,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Kraków, Polen",
        "lat": 50.0647,
        "lng": 19.945,
        "type": "stad",
        "size": 10,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Kuala Lumpur, Malaysia",
        "lat": 3.139,
        "lng": 101.6869,
        "type": "stad",
        "capital": true,
        "size": 12,
        "difficulty": [
            "easy",
            "medium",
            "hard"
        ]
    },
    {
        "name": "Kuwait City, Kuwait",
        "lat": 29.3759,
        "lng": 47.9774,
        "type": "stad",
        "size": 10,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Köpenhamn, Danmark",
        "lat": 55.6761,
        "lng": 12.5683,
        "type": "stad",
        "capital": true,
        "size": 10,
        "difficulty": [
            "easy",
            "medium"
        ]
    },
    {
        "name": "La Paz, Bolivia",
        "lat": -16.5,
        "lng": -68.15,
        "type": "stad",
        "size": 10,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Lagos, Nigeria",
        "lat": 6.5244,
        "lng": 3.3792,
        "type": "stad",
        "size": 18,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Libreville, Gabon",
        "lat": 0.4162,
        "lng": 9.4673,
        "type": "stad",
        "size": 8,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Lilongwe, Malawi",
        "lat": -13.9626,
        "lng": 33.7741,
        "type": "stad",
        "size": 8,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Lima, Peru",
        "lat": -12.0464,
        "lng": -77.0428,
        "type": "stad",
        "capital": true,
        "size": 15,
        "difficulty": [
            "medium",
            "hard"
        ]
    },
    {
        "name": "Lissabon, Portugal",
        "lat": 38.7223,
        "lng": -9.1393,
        "type": "stad",
        "capital": true,
        "size": 10,
        "difficulty": [
            "easy",
            "medium"
        ]
    },
    {
        "name": "Ljubljana, Slovenien",
        "lat": 46.0569,
        "lng": 14.5058,
        "type": "stad",
        "size": 6,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Lomé, Togo",
        "lat": 6.1256,
        "lng": 1.2315,
        "type": "stad",
        "size": 8,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "London, Storbritannien",
        "lat": 51.5074,
        "lng": -0.1278,
        "type": "stad",
        "capital": true,
        "size": 20,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Los Angeles, USA",
        "lat": 34.0522,
        "lng": -118.2437,
        "type": "stad",
        "size": 18,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Luanda, Angola",
        "lat": -8.8383,
        "lng": 13.2344,
        "type": "stad",
        "size": 12,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Lusaka, Zambia",
        "lat": -15.3875,
        "lng": 28.3228,
        "type": "stad",
        "size": 10,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Lyon, Frankrike",
        "lat": 45.764,
        "lng": 4.8357,
        "type": "stad",
        "size": 10,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Madrid, Spanien",
        "lat": 40.4168,
        "lng": -3.7038,
        "type": "stad",
        "capital": true,
        "size": 12,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Malabo, Ekvatorialguinea",
        "lat": 3.7504,
        "lng": 8.7371,
        "type": "stad",
        "size": 6,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Málaga, Spanien",
        "lat": 36.7213,
        "lng": -4.4214,
        "type": "stad",
        "size": 10,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Malé, Maldiverna",
        "lat": 4.1755,
        "lng": 73.5093,
        "type": "stad",
        "size": 5,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Malmö, Sverige",
        "lat": 55.605,
        "lng": 13.0038,
        "type": "stad",
        "size": 10,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Managua, Nicaragua",
        "lat": 12.1149,
        "lng": -86.2362,
        "type": "stad",
        "size": 10,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Manama, Bahrain",
        "lat": 26.0667,
        "lng": 50.5577,
        "type": "stad",
        "size": 8,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Manila, Filippinerna",
        "lat": 14.5995,
        "lng": 120.9842,
        "type": "stad",
        "capital": true,
        "size": 15,
        "difficulty": [
            "easy",
            "medium",
            "hard"
        ]
    },
    {
        "name": "Maputo, Moçambique",
        "lat": -25.9655,
        "lng": 32.5832,
        "type": "stad",
        "size": 10,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Marseille, Frankrike",
        "lat": 43.2965,
        "lng": 5.3698,
        "type": "stad",
        "size": 12,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Maseru, Lesotho",
        "lat": -29.3167,
        "lng": 27.4833,
        "type": "stad",
        "size": 6,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Mbabane, Eswatini",
        "lat": -26.3054,
        "lng": 31.1367,
        "type": "stad",
        "size": 6,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Melbourne, Australien",
        "lat": -37.8136,
        "lng": 144.9631,
        "type": "stad",
        "size": 15,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Mexico City, Mexiko",
        "lat": 19.4326,
        "lng": -99.1332,
        "type": "stad",
        "capital": true,
        "size": 20,
        "difficulty": [
            "easy",
            "medium"
        ]
    },
    {
        "name": "Miami, USA",
        "lat": 25.7617,
        "lng": -80.1918,
        "type": "stad",
        "size": 15,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Milano, Italien",
        "lat": 45.4642,
        "lng": 9.19,
        "type": "stad",
        "size": 15,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Minsk, Vitryssland",
        "lat": 53.9045,
        "lng": 27.5615,
        "type": "stad",
        "size": 10,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Mogadishu, Somalia",
        "lat": 2.0469,
        "lng": 45.3182,
        "type": "stad",
        "size": 10,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Montevideo, Uruguay",
        "lat": -34.9011,
        "lng": -56.1645,
        "type": "stad",
        "size": 10,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Montreal, Kanada",
        "lat": 45.5017,
        "lng": -73.5673,
        "type": "stad",
        "size": 15,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Moroni, Komorerna",
        "lat": -11.7172,
        "lng": 43.2473,
        "type": "stad",
        "size": 5,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Moskva, Ryssland",
        "lat": 55.7558,
        "lng": 37.6173,
        "type": "stad",
        "capital": true,
        "size": 20,
        "difficulty": [
            "easy",
            "medium"
        ]
    },
    {
        "name": "Mumbai, Indien",
        "lat": 19.076,
        "lng": 72.8777,
        "type": "stad",
        "size": 20,
        "difficulty": [
            "easy",
            "medium"
        ]
    },
    {
        "name": "Muscat, Oman",
        "lat": 23.588,
        "lng": 58.3829,
        "type": "stad",
        "size": 10,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "N'Djamena, Tchad",
        "lat": 12.1348,
        "lng": 15.0557,
        "type": "stad",
        "size": 8,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Nairobi, Kenya",
        "lat": -1.2921,
        "lng": 36.8219,
        "type": "stad",
        "capital": true,
        "size": 12,
        "difficulty": [
            "medium",
            "hard"
        ]
    },
    {
        "name": "Neapel, Italien",
        "lat": 40.8518,
        "lng": 14.2681,
        "type": "stad",
        "size": 12,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "New York, USA",
        "lat": 40.7128,
        "lng": -74.006,
        "type": "stad",
        "size": 20,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Niamey, Niger",
        "lat": 13.5127,
        "lng": 2.1128,
        "type": "stad",
        "size": 8,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Nice, Frankrike",
        "lat": 43.7102,
        "lng": 7.262,
        "type": "stad",
        "size": 10,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Nuuk, Grönland",
        "lat": 64.1814,
        "lng": -51.6941,
        "type": "stad",
        "size": 6,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Nürnberg, Tyskland",
        "lat": 49.4521,
        "lng": 11.0767,
        "type": "stad",
        "size": 10,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Odense, Danmark",
        "lat": 55.4038,
        "lng": 10.4024,
        "type": "stad",
        "size": 8,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Oslo, Norge",
        "lat": 59.9139,
        "lng": 10.7522,
        "type": "stad",
        "capital": true,
        "size": 10,
        "difficulty": [
            "easy",
            "medium"
        ]
    },
    {
        "name": "Ouagadougou, Burkina Faso",
        "lat": 12.3714,
        "lng": -1.5197,
        "type": "stad",
        "size": 10,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Palermo, Italien",
        "lat": 38.1157,
        "lng": 13.3615,
        "type": "stad",
        "size": 12,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Panama City, Panama",
        "lat": 8.9824,
        "lng": -79.5199,
        "type": "stad",
        "size": 10,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Paramaribo, Surinam",
        "lat": 5.852,
        "lng": -55.2038,
        "type": "stad",
        "size": 8,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Paris, Frankrike",
        "lat": 48.8566,
        "lng": 2.3522,
        "type": "stad",
        "capital": true,
        "size": 15,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Peking, Kina",
        "lat": 39.9042,
        "lng": 116.4074,
        "type": "stad",
        "capital": true,
        "size": 20,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Phnom Penh, Kambodja",
        "lat": 11.5564,
        "lng": 104.9282,
        "type": "stad",
        "size": 10,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Podgorica, Montenegro",
        "lat": 42.4304,
        "lng": 19.2594,
        "type": "stad",
        "size": 6,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Port Louis, Mauritius",
        "lat": -20.1609,
        "lng": 57.5012,
        "type": "stad",
        "size": 6,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Porto, Portugal",
        "lat": 41.1579,
        "lng": -8.6291,
        "type": "stad",
        "size": 10,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Prag, Tjeckien",
        "lat": 50.0755,
        "lng": 14.4378,
        "type": "stad",
        "capital": true,
        "size": 10,
        "difficulty": [
            "easy",
            "medium"
        ]
    },
    {
        "name": "Pristina, Kosovo",
        "lat": 42.6629,
        "lng": 21.1655,
        "type": "stad",
        "size": 8,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Quito, Ecuador",
        "lat": -0.1807,
        "lng": -78.4678,
        "type": "stad",
        "size": 12,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Reykjavik, Island",
        "lat": 64.1466,
        "lng": -21.9426,
        "type": "stad",
        "size": 8,
        "difficulty": [
            "medium",
            "hard"
        ]
    },
    {
        "name": "Riga, Lettland",
        "lat": 56.9496,
        "lng": 24.1052,
        "type": "stad",
        "size": 8,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Rio de Janeiro, Brasilien",
        "lat": -22.9068,
        "lng": -43.1729,
        "type": "stad",
        "size": 15,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Riyadh, Saudiarabien",
        "lat": 24.7136,
        "lng": 46.6753,
        "type": "stad",
        "size": 15,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Rom, Italien",
        "lat": 41.9028,
        "lng": 12.4964,
        "type": "stad",
        "capital": true,
        "size": 12,
        "difficulty": [
            "easy",
            "medium"
        ]
    },
    {
        "name": "Roseau, Dominica",
        "lat": 15.3017,
        "lng": -61.387,
        "type": "stad",
        "size": 5,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Rotterdam, Nederländerna",
        "lat": 51.9244,
        "lng": 4.4777,
        "type": "stad",
        "size": 12,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Saint-Denis, Réunion",
        "lat": -20.8823,
        "lng": 55.4504,
        "type": "stad",
        "size": 6,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "San Francisco, USA",
        "lat": 37.7749,
        "lng": -122.4194,
        "type": "stad",
        "size": 15,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "San José, Costa Rica",
        "lat": 9.9281,
        "lng": -84.0907,
        "type": "stad",
        "size": 10,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "San Salvador, El Salvador",
        "lat": 13.6929,
        "lng": -89.2182,
        "type": "stad",
        "size": 10,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Sana'a, Jemen",
        "lat": 15.5527,
        "lng": 48.5164,
        "type": "stad",
        "size": 10,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Santiago, Chile",
        "lat": -33.4489,
        "lng": -70.6693,
        "type": "stad",
        "capital": true,
        "size": 15,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "São Tomé, São Tomé och Príncipe",
        "lat": 0.3365,
        "lng": 6.7273,
        "type": "stad",
        "size": 5,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Sarajevo, Bosnien",
        "lat": 43.8563,
        "lng": 18.4131,
        "type": "stad",
        "size": 8,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Seattle, USA",
        "lat": 47.6062,
        "lng": -122.3321,
        "type": "stad",
        "size": 12,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Seoul, Sydkorea",
        "lat": 37.5665,
        "lng": 126.978,
        "type": "stad",
        "capital": true,
        "size": 18,
        "difficulty": [
            "easy",
            "medium"
        ]
    },
    {
        "name": "Sevilla, Spanien",
        "lat": 37.3891,
        "lng": -5.9845,
        "type": "stad",
        "size": 10,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Shanghai, Kina",
        "lat": 31.2304,
        "lng": 121.4737,
        "type": "stad",
        "size": 22,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Shenzhen, Kina",
        "lat": 22.5431,
        "lng": 114.0579,
        "type": "stad",
        "size": 15,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Skopje, Nordmakedonien",
        "lat": 41.9973,
        "lng": 21.428,
        "type": "stad",
        "size": 8,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Sofia, Bulgarien",
        "lat": 42.6977,
        "lng": 23.3219,
        "type": "stad",
        "size": 10,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "St. George's, Grenada",
        "lat": 12.0561,
        "lng": -61.7488,
        "type": "stad",
        "size": 5,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Stockholm, Sverige",
        "lat": 59.3293,
        "lng": 18.0686,
        "type": "stad",
        "capital": true,
        "size": 12,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Strasbourg, Frankrike",
        "lat": 48.5734,
        "lng": 7.7521,
        "type": "stad",
        "size": 10,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Stuttgart, Tyskland",
        "lat": 48.7758,
        "lng": 9.1829,
        "type": "stad",
        "size": 10,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Sucre, Bolivia",
        "lat": -19.0196,
        "lng": -65.2619,
        "type": "stad",
        "size": 8,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Suva, Fiji",
        "lat": -18.1416,
        "lng": 178.4419,
        "type": "stad",
        "size": 6,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Sydney, Australien",
        "lat": -33.8688,
        "lng": 151.2093,
        "type": "stad",
        "size": 15,
        "difficulty": [
            "easy",
            "medium"
        ]
    },
    {
        "name": "Taipei, Taiwan",
        "lat": 25.033,
        "lng": 121.5654,
        "type": "stad",
        "capital": true,
        "size": 12,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Tallinn, Estland",
        "lat": 59.437,
        "lng": 24.7536,
        "type": "stad",
        "size": 8,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Tampere, Finland",
        "lat": 61.4978,
        "lng": 23.761,
        "type": "stad",
        "size": 10,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Tashkent, Uzbekistan",
        "lat": 41.2995,
        "lng": 69.2401,
        "type": "stad",
        "size": 10,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Tbilisi, Georgien",
        "lat": 41.7151,
        "lng": 44.8271,
        "type": "stad",
        "size": 8,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Tegucigalpa, Honduras",
        "lat": 14.0723,
        "lng": -87.1921,
        "type": "stad",
        "size": 10,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Teheran, Iran",
        "lat": 35.6892,
        "lng": 51.389,
        "type": "stad",
        "size": 18,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Tel Aviv, Israel",
        "lat": 32.0853,
        "lng": 34.7818,
        "type": "stad",
        "size": 12,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Thimphu, Bhutan",
        "lat": 27.4728,
        "lng": 89.6393,
        "type": "stad",
        "size": 6,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Tirana, Albanien",
        "lat": 41.3275,
        "lng": 19.8187,
        "type": "stad",
        "size": 8,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Tokyo, Japan",
        "lat": 35.6762,
        "lng": 139.6503,
        "type": "stad",
        "capital": true,
        "size": 25,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Toronto, Kanada",
        "lat": 43.6532,
        "lng": -79.3832,
        "type": "stad",
        "size": 15,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Tórshavn, Färöarna",
        "lat": 62.0079,
        "lng": -6.79,
        "type": "stad",
        "size": 5,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Toulouse, Frankrike",
        "lat": 43.6047,
        "lng": 1.4442,
        "type": "stad",
        "size": 10,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Trondheim, Norge",
        "lat": 63.4305,
        "lng": 10.3951,
        "type": "stad",
        "size": 8,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Turin, Italien",
        "lat": 45.0703,
        "lng": 7.6869,
        "type": "stad",
        "size": 12,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Ulaanbaatar, Mongoliet",
        "lat": 47.8864,
        "lng": 106.9057,
        "type": "stad",
        "size": 10,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Valencia, Spanien",
        "lat": 39.4699,
        "lng": -0.3763,
        "type": "stad",
        "size": 12,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Vancouver, Kanada",
        "lat": 49.2827,
        "lng": -123.1207,
        "type": "stad",
        "size": 12,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Venedig, Italien",
        "lat": 45.4408,
        "lng": 12.3155,
        "type": "stad",
        "size": 10,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Verona, Italien",
        "lat": 45.4384,
        "lng": 10.9916,
        "type": "stad",
        "size": 8,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Victoria, Seychellerna",
        "lat": -4.6167,
        "lng": 55.45,
        "type": "stad",
        "size": 5,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Vientiane, Laos",
        "lat": 17.9757,
        "lng": 102.6331,
        "type": "stad",
        "size": 8,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Vilnius, Litauen",
        "lat": 54.6872,
        "lng": 25.2797,
        "type": "stad",
        "size": 8,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Warszawa, Polen",
        "lat": 52.2297,
        "lng": 21.0122,
        "type": "stad",
        "capital": true,
        "size": 12,
        "difficulty": [
            "easy",
            "medium",
            "hard"
        ]
    },
    {
        "name": "Wellington, Nya Zeeland",
        "lat": -41.2865,
        "lng": 174.7762,
        "type": "stad",
        "size": 8,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Wien, Österrike",
        "lat": 48.2082,
        "lng": 16.3738,
        "type": "stad",
        "capital": true,
        "size": 12,
        "difficulty": [
            "easy",
            "medium"
        ]
    },
    {
        "name": "Windhoek, Namibia",
        "lat": -22.5597,
        "lng": 17.0832,
        "type": "stad",
        "size": 8,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Xi'an, Kina",
        "lat": 34.3416,
        "lng": 108.9398,
        "type": "stad",
        "size": 12,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Yangon, Myanmar",
        "lat": 16.8661,
        "lng": 96.1951,
        "type": "stad",
        "size": 12,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Yerevan, Armenien",
        "lat": 40.1792,
        "lng": 44.4991,
        "type": "stad",
        "size": 8,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Zagreb, Kroatien",
        "lat": 45.815,
        "lng": 15.9819,
        "type": "stad",
        "size": 10,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Zaragoza, Spanien",
        "lat": 41.6488,
        "lng": -0.8891,
        "type": "stad",
        "size": 10,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Zürich, Schweiz",
        "lat": 47.3769,
        "lng": 8.5417,
        "type": "stad",
        "size": 8,
        "difficulty": [
            "easy",
            "medium"
        ]
    },
    {
        "name": "Århus, Danmark",
        "lat": 56.1629,
        "lng": 10.2039,
        "type": "stad",
        "size": 10,
        "difficulty": [
            "medium"
        ]
    }
];

export default cities;
