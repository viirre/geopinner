// Countries (type: "land")
// Total: 142 unique places
const countries = [
    {
        "name": "Afghanistan",
        "lat": 33.9391,
        "lng": 67.71,
        "type": "land",
        "size": 500,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Albanien",
        "lat": 41.1533,
        "lng": 20.1683,
        "type": "land",
        "size": 100,
        "difficulty": [
            "medium",
            "hard"
        ]
    },
    {
        "name": "Algeriet",
        "lat": 28.0339,
        "lng": 1.6596,
        "type": "land",
        "size": 1000,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Angola",
        "lat": -11.2027,
        "lng": 17.8739,
        "type": "land",
        "size": 700,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Antarktis",
        "lat": -82.8628,
        "lng": 135,
        "type": "land",
        "size": 3000,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Argentina",
        "lat": -38.4161,
        "lng": -63.6167,
        "type": "land",
        "size": 1200,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Armenien",
        "lat": 40.0691,
        "lng": 45.0382,
        "type": "land",
        "size": 100,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Australien",
        "lat": -25.2744,
        "lng": 133.7751,
        "type": "land",
        "size": 2000,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Azerbajdzjan",
        "lat": 40.1431,
        "lng": 47.5769,
        "type": "land",
        "size": 150,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Bahrain",
        "lat": 26.0667,
        "lng": 50.5577,
        "type": "land",
        "size": 30,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Bangladesh",
        "lat": 23.685,
        "lng": 90.3563,
        "type": "land",
        "size": 250,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Belgien",
        "lat": 50.5039,
        "lng": 4.4699,
        "type": "land",
        "size": 100,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Benin",
        "lat": 9.3077,
        "lng": 2.3158,
        "type": "land",
        "size": 150,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Bhutan",
        "lat": 27.5142,
        "lng": 90.4336,
        "type": "land",
        "size": 100,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Bolivia",
        "lat": -16.2902,
        "lng": -63.5887,
        "type": "land",
        "size": 600,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Bosnien och Hercegovina",
        "lat": 43.9159,
        "lng": 17.6791,
        "type": "land",
        "size": 120,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Botswana",
        "lat": -22.3285,
        "lng": 24.6849,
        "type": "land",
        "size": 400,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Brasilien",
        "lat": -14.235,
        "lng": -51.9253,
        "type": "land",
        "size": 2000,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Bulgarien",
        "lat": 42.7339,
        "lng": 25.4858,
        "type": "land",
        "size": 200,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Burkina Faso",
        "lat": 12.2383,
        "lng": -1.5616,
        "type": "land",
        "size": 300,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Burundi",
        "lat": -3.3731,
        "lng": 29.9189,
        "type": "land",
        "size": 80,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Centralafrikanska republiken",
        "lat": 6.6111,
        "lng": 20.9394,
        "type": "land",
        "size": 500,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Chile",
        "lat": -35.6751,
        "lng": -71.543,
        "type": "land",
        "size": 1000,
        "difficulty": [
            "medium",
            "hard"
        ]
    },
    {
        "name": "Colombia",
        "lat": 4.5709,
        "lng": -74.2973,
        "type": "land",
        "size": 600,
        "difficulty": [
            "easy",
            "medium"
        ]
    },
    {
        "name": "Costa Rica",
        "lat": 9.7489,
        "lng": -83.7534,
        "type": "land",
        "size": 120,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Danmark",
        "lat": 56.2639,
        "lng": 9.5018,
        "type": "land",
        "size": 150,
        "difficulty": [
            "easy",
            "medium"
        ]
    },
    {
        "name": "Djibouti",
        "lat": 11.8251,
        "lng": 42.5903,
        "type": "land",
        "size": 80,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "DR Kongo",
        "lat": -4.0383,
        "lng": 21.7587,
        "type": "land",
        "size": 1200,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Ecuador",
        "lat": -1.8312,
        "lng": -78.1834,
        "type": "land",
        "size": 300,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Egypten",
        "lat": 26.8206,
        "lng": 30.8025,
        "type": "land",
        "size": 800,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Ekvatorialguinea",
        "lat": 1.6508,
        "lng": 10.2679,
        "type": "land",
        "size": 80,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Eritrea",
        "lat": 15.1794,
        "lng": 39.7823,
        "type": "land",
        "size": 200,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Estland",
        "lat": 58.5953,
        "lng": 25.0136,
        "type": "land",
        "size": 100,
        "difficulty": [
            "medium",
            "hard"
        ]
    },
    {
        "name": "Eswatini",
        "lat": -26.5225,
        "lng": 31.4659,
        "type": "land",
        "size": 60,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Etiopien",
        "lat": 9.145,
        "lng": 40.4897,
        "type": "land",
        "size": 600,
        "difficulty": [
            "medium",
            "hard"
        ]
    },
    {
        "name": "Filippinerna",
        "lat": 12.8797,
        "lng": 121.774,
        "type": "land",
        "size": 400,
        "difficulty": [
            "medium",
            "hard"
        ]
    },
    {
        "name": "Finland",
        "lat": 61.9241,
        "lng": 25.7482,
        "type": "land",
        "size": 400,
        "difficulty": [
            "easy",
            "medium",
            "hard"
        ]
    },
    {
        "name": "Frankrike",
        "lat": 46.2276,
        "lng": 2.2137,
        "type": "land",
        "size": 350,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Gabon",
        "lat": -0.8037,
        "lng": 11.6094,
        "type": "land",
        "size": 300,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Gambia",
        "lat": 13.4432,
        "lng": -15.3101,
        "type": "land",
        "size": 100,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Georgien",
        "lat": 42.3154,
        "lng": 43.3569,
        "type": "land",
        "size": 120,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Ghana",
        "lat": 7.9465,
        "lng": -1.0232,
        "type": "land",
        "size": 300,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Grekland",
        "lat": 39.0742,
        "lng": 21.8243,
        "type": "land",
        "size": 250,
        "difficulty": [
            "easy",
            "medium"
        ]
    },
    {
        "name": "Guatemala",
        "lat": 15.7835,
        "lng": -90.2308,
        "type": "land",
        "size": 200,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Guinea",
        "lat": 9.9456,
        "lng": -9.6966,
        "type": "land",
        "size": 300,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Guinea-Bissau",
        "lat": 11.8037,
        "lng": -15.1804,
        "type": "land",
        "size": 100,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Haiti",
        "lat": 18.9712,
        "lng": -72.2852,
        "type": "land",
        "size": 80,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Honduras",
        "lat": 15.2,
        "lng": -86.2419,
        "type": "land",
        "size": 200,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Indien",
        "lat": 20.5937,
        "lng": 78.9629,
        "type": "land",
        "size": 1500,
        "difficulty": [
            "easy",
            "medium"
        ]
    },
    {
        "name": "Indonesien",
        "lat": -0.7893,
        "lng": 113.9213,
        "type": "land",
        "size": 1200,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Irak",
        "lat": 33.2232,
        "lng": 43.6793,
        "type": "land",
        "size": 400,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Iran",
        "lat": 32.4279,
        "lng": 53.688,
        "type": "land",
        "size": 800,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Island",
        "lat": 64.9631,
        "lng": -19.0208,
        "type": "land",
        "size": 200,
        "difficulty": [
            "easy",
            "medium"
        ]
    },
    {
        "name": "Israel",
        "lat": 31.0461,
        "lng": 34.8516,
        "type": "land",
        "size": 100,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Italien",
        "lat": 41.8719,
        "lng": 12.5674,
        "type": "land",
        "size": 400,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Japan",
        "lat": 36.2048,
        "lng": 138.2529,
        "type": "land",
        "size": 600,
        "difficulty": [
            "easy",
            "medium"
        ]
    },
    {
        "name": "Jemen",
        "lat": 15.5527,
        "lng": 48.5164,
        "type": "land",
        "size": 400,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Jordanien",
        "lat": 30.5852,
        "lng": 36.2384,
        "type": "land",
        "size": 150,
        "difficulty": [
            "medium",
            "hard"
        ]
    },
    {
        "name": "Kambodja",
        "lat": 12.5657,
        "lng": 104.991,
        "type": "land",
        "size": 250,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Kamerun",
        "lat": 7.3697,
        "lng": 12.3547,
        "type": "land",
        "size": 400,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Kanada",
        "lat": 56.1304,
        "lng": -106.3468,
        "type": "land",
        "size": 2500,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Kazakstan",
        "lat": 48.0196,
        "lng": 66.9237,
        "type": "land",
        "size": 1200,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Kenya",
        "lat": -0.0236,
        "lng": 37.9062,
        "type": "land",
        "size": 400,
        "difficulty": [
            "easy",
            "medium"
        ]
    },
    {
        "name": "Kina",
        "lat": 35.8617,
        "lng": 104.1954,
        "type": "land",
        "size": 2000,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Kirgizistan",
        "lat": 41.2044,
        "lng": 74.7661,
        "type": "land",
        "size": 300,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Kosovo",
        "lat": 42.6026,
        "lng": 20.903,
        "type": "land",
        "size": 50,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Kroatien",
        "lat": 45.1,
        "lng": 15.2,
        "type": "land",
        "size": 150,
        "difficulty": [
            "medium",
            "hard"
        ]
    },
    {
        "name": "Kuwait",
        "lat": 29.3117,
        "lng": 47.4818,
        "type": "land",
        "size": 80,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Laos",
        "lat": 19.8563,
        "lng": 102.4955,
        "type": "land",
        "size": 300,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Lesotho",
        "lat": -29.61,
        "lng": 28.2336,
        "type": "land",
        "size": 80,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Lettland",
        "lat": 56.8796,
        "lng": 24.6032,
        "type": "land",
        "size": 120,
        "difficulty": [
            "medium",
            "hard"
        ]
    },
    {
        "name": "Libanon",
        "lat": 33.8547,
        "lng": 35.8623,
        "type": "land",
        "size": 80,
        "difficulty": [
            "medium",
            "hard"
        ]
    },
    {
        "name": "Liberia",
        "lat": 6.4281,
        "lng": -9.4295,
        "type": "land",
        "size": 150,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Litauen",
        "lat": 55.1694,
        "lng": 23.8813,
        "type": "land",
        "size": 120,
        "difficulty": [
            "medium",
            "hard"
        ]
    },
    {
        "name": "Malawi",
        "lat": -13.2543,
        "lng": 34.3015,
        "type": "land",
        "size": 200,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Malaysia",
        "lat": 4.2105,
        "lng": 101.9758,
        "type": "land",
        "size": 350,
        "difficulty": [
            "easy",
            "medium"
        ]
    },
    {
        "name": "Mali",
        "lat": 17.5707,
        "lng": -3.9962,
        "type": "land",
        "size": 700,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Marocko",
        "lat": 31.7917,
        "lng": -7.0926,
        "type": "land",
        "size": 500,
        "difficulty": [
            "easy",
            "medium"
        ]
    },
    {
        "name": "Mauretanien",
        "lat": 21.0079,
        "lng": -10.9408,
        "type": "land",
        "size": 600,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Mexiko",
        "lat": 23.6345,
        "lng": -102.5528,
        "type": "land",
        "size": 800,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Moçambique",
        "lat": -18.6657,
        "lng": 35.5296,
        "type": "land",
        "size": 500,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Moldavien",
        "lat": 47.4116,
        "lng": 28.3699,
        "type": "land",
        "size": 80,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Mongoliet",
        "lat": 46.8625,
        "lng": 103.8467,
        "type": "land",
        "size": 800,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Montenegro",
        "lat": 42.7087,
        "lng": 19.3744,
        "type": "land",
        "size": 60,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Myanmar",
        "lat": 21.9162,
        "lng": 95.956,
        "type": "land",
        "size": 400,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Namibia",
        "lat": -22.9576,
        "lng": 18.4904,
        "type": "land",
        "size": 600,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Nederländerna",
        "lat": 52.1326,
        "lng": 5.2913,
        "type": "land",
        "size": 100,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Nepal",
        "lat": 28.3949,
        "lng": 84.124,
        "type": "land",
        "size": 200,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Nicaragua",
        "lat": 12.8654,
        "lng": -85.2072,
        "type": "land",
        "size": 200,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Niger",
        "lat": 17.6078,
        "lng": 8.0817,
        "type": "land",
        "size": 700,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Nigeria",
        "lat": 9.082,
        "lng": 8.6753,
        "type": "land",
        "size": 600,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Nordmakedonien",
        "lat": 41.6086,
        "lng": 21.7453,
        "type": "land",
        "size": 80,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Norge",
        "lat": 60.472,
        "lng": 8.4689,
        "type": "land",
        "size": 400,
        "difficulty": [
            "easy",
            "medium"
        ]
    },
    {
        "name": "Nya Zeeland",
        "lat": -40.9006,
        "lng": 174.886,
        "type": "land",
        "size": 500,
        "difficulty": [
            "easy",
            "medium"
        ]
    },
    {
        "name": "Oman",
        "lat": 21.4735,
        "lng": 55.9754,
        "type": "land",
        "size": 300,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Pakistan",
        "lat": 30.3753,
        "lng": 69.3451,
        "type": "land",
        "size": 700,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Papua Nya Guinea",
        "lat": -6.315,
        "lng": 143.9555,
        "type": "land",
        "size": 600,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Paraguay",
        "lat": -23.4425,
        "lng": -58.4438,
        "type": "land",
        "size": 400,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Peru",
        "lat": -9.19,
        "lng": -75.0152,
        "type": "land",
        "size": 700,
        "difficulty": [
            "easy",
            "medium"
        ]
    },
    {
        "name": "Polen",
        "lat": 51.9194,
        "lng": 19.1451,
        "type": "land",
        "size": 300,
        "difficulty": [
            "easy",
            "medium"
        ]
    },
    {
        "name": "Portugal",
        "lat": 39.3999,
        "lng": -8.2245,
        "type": "land",
        "size": 200,
        "difficulty": [
            "easy",
            "medium"
        ]
    },
    {
        "name": "Qatar",
        "lat": 25.3548,
        "lng": 51.1839,
        "type": "land",
        "size": 50,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Rumänien",
        "lat": 45.9432,
        "lng": 24.9668,
        "type": "land",
        "size": 300,
        "difficulty": [
            "medium",
            "hard"
        ]
    },
    {
        "name": "Rwanda",
        "lat": -1.9403,
        "lng": 29.8739,
        "type": "land",
        "size": 80,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Ryssland",
        "lat": 61.524,
        "lng": 105.3188,
        "type": "land",
        "size": 3000,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "São Tomé och Príncipe",
        "lat": 0.1864,
        "lng": 6.6131,
        "type": "land",
        "size": 30,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Saudiarabien",
        "lat": 23.8859,
        "lng": 45.0792,
        "type": "land",
        "size": 1000,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Schweiz",
        "lat": 46.8182,
        "lng": 8.2275,
        "type": "land",
        "size": 100,
        "difficulty": [
            "easy",
            "medium"
        ]
    },
    {
        "name": "Senegal",
        "lat": 14.4974,
        "lng": -14.4524,
        "type": "land",
        "size": 250,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Serbien",
        "lat": 44.0165,
        "lng": 21.0059,
        "type": "land",
        "size": 150,
        "difficulty": [
            "medium",
            "hard"
        ]
    },
    {
        "name": "Sierra Leone",
        "lat": 8.4606,
        "lng": -11.7799,
        "type": "land",
        "size": 150,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Singapore",
        "lat": 1.3521,
        "lng": 103.8198,
        "type": "land",
        "size": 25,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Slovakien",
        "lat": 48.669,
        "lng": 19.699,
        "type": "land",
        "size": 100,
        "difficulty": [
            "medium",
            "hard"
        ]
    },
    {
        "name": "Slovenien",
        "lat": 46.1512,
        "lng": 14.9955,
        "type": "land",
        "size": 80,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Spanien",
        "lat": 40.4637,
        "lng": -3.7492,
        "type": "land",
        "size": 400,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Storbritannien",
        "lat": 55.3781,
        "lng": -3.436,
        "type": "land",
        "size": 300,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Sverige",
        "lat": 60.1282,
        "lng": 18.6435,
        "type": "land",
        "size": 500,
        "difficulty": [
            "easy",
            "medium"
        ]
    },
    {
        "name": "Sydafrika",
        "lat": -30.5595,
        "lng": 22.9375,
        "type": "land",
        "size": 600,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Sydkorea",
        "lat": 35.9078,
        "lng": 127.7669,
        "type": "land",
        "size": 250,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Syrien",
        "lat": 34.8021,
        "lng": 38.9968,
        "type": "land",
        "size": 250,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Tadzjikistan",
        "lat": 38.861,
        "lng": 71.2761,
        "type": "land",
        "size": 250,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Tanzania",
        "lat": -6.369,
        "lng": 34.8888,
        "type": "land",
        "size": 500,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Tchad",
        "lat": 15.4542,
        "lng": 18.7322,
        "type": "land",
        "size": 700,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Thailand",
        "lat": 15.87,
        "lng": 100.9925,
        "type": "land",
        "size": 400,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Tjeckien",
        "lat": 49.8175,
        "lng": 15.473,
        "type": "land",
        "size": 200,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Togo",
        "lat": 8.6195,
        "lng": 0.8248,
        "type": "land",
        "size": 100,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Tunisien",
        "lat": 33.8869,
        "lng": 9.5375,
        "type": "land",
        "size": 250,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Turkiet",
        "lat": 38.9637,
        "lng": 35.2433,
        "type": "land",
        "size": 700,
        "difficulty": [
            "easy",
            "medium"
        ]
    },
    {
        "name": "Turkmenistan",
        "lat": 38.9697,
        "lng": 59.5563,
        "type": "land",
        "size": 400,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Tyskland",
        "lat": 51.1657,
        "lng": 10.4515,
        "type": "land",
        "size": 300,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Uganda",
        "lat": 1.3733,
        "lng": 32.2903,
        "type": "land",
        "size": 300,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Ukraina",
        "lat": 48.3794,
        "lng": 31.1656,
        "type": "land",
        "size": 500,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Ungern",
        "lat": 47.1625,
        "lng": 19.5033,
        "type": "land",
        "size": 200,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Uruguay",
        "lat": -32.5228,
        "lng": -55.7658,
        "type": "land",
        "size": 200,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "USA",
        "lat": 37.0902,
        "lng": -95.7129,
        "type": "land",
        "size": 2000,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Uzbekistan",
        "lat": 41.3775,
        "lng": 64.5853,
        "type": "land",
        "size": 500,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Venezuela",
        "lat": 6.4238,
        "lng": -66.5897,
        "type": "land",
        "size": 500,
        "difficulty": [
            "medium",
            "hard"
        ]
    },
    {
        "name": "Vietnam",
        "lat": 14.0583,
        "lng": 108.2772,
        "type": "land",
        "size": 400,
        "difficulty": [
            "easy",
            "medium"
        ]
    },
    {
        "name": "Vitryssland",
        "lat": 53.7098,
        "lng": 27.9534,
        "type": "land",
        "size": 300,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Zambia",
        "lat": -13.1339,
        "lng": 27.8493,
        "type": "land",
        "size": 500,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Zimbabwe",
        "lat": -19.0154,
        "lng": 29.1549,
        "type": "land",
        "size": 400,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Österrike",
        "lat": 47.5162,
        "lng": 14.5501,
        "type": "land",
        "size": 150,
        "difficulty": [
            "easy",
            "medium"
        ]
    },
    {
        "name": "Östtimor",
        "lat": -8.5569,
        "lng": 125.5603,
        "type": "land",
        "size": 60,
        "difficulty": [
            "hard"
        ]
    }
];

export default countries;
