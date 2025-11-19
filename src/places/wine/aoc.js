// French AOC wine regions (type: "aoc")
// Total: 42 unique places
const aocWineRegions = [
    {
        "name": "Alsace AOC",
        "lat": 48.3181,
        "lng": 7.4416,
        "type": "aoc",
        "size": 80,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Bandol, Provence",
        "lat": 43.1378,
        "lng": 5.7556,
        "type": "aoc",
        "size": 15,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Beaujolais, Bourgogne",
        "lat": 46.1667,
        "lng": 4.6333,
        "type": "aoc",
        "size": 50,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Bordeaux AOC",
        "lat": 44.8378,
        "lng": -0.5792,
        "type": "aoc",
        "size": 80,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Bourgogne AOC",
        "lat": 47.05,
        "lng": 4.85,
        "type": "aoc",
        "size": 100,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Bourgueil, Loire",
        "lat": 47.2833,
        "lng": 0.1667,
        "type": "aoc",
        "size": 15,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Cahors, Sud-Ouest",
        "lat": 44.4478,
        "lng": 1.4411,
        "type": "aoc",
        "size": 40,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Cassis, Provence",
        "lat": 43.2147,
        "lng": 5.5384,
        "type": "aoc",
        "size": 8,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Chablis Grand Cru",
        "lat": 47.8167,
        "lng": 3.8,
        "type": "aoc",
        "size": 5,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Chablis, Bourgogne",
        "lat": 47.8167,
        "lng": 3.8,
        "type": "aoc",
        "size": 20,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Chambertin, Bourgogne",
        "lat": 47.2267,
        "lng": 4.9644,
        "type": "aoc",
        "size": 3,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Champagne AOC",
        "lat": 49.042,
        "lng": 4.036,
        "type": "aoc",
        "size": 120,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Châteauneuf-du-Pape",
        "lat": 44.0575,
        "lng": 4.8317,
        "type": "aoc",
        "size": 12,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Chinon, Loire",
        "lat": 47.1667,
        "lng": 0.25,
        "type": "aoc",
        "size": 20,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Condrieu, Rhône",
        "lat": 45.4667,
        "lng": 4.7667,
        "type": "aoc",
        "size": 8,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Corbieres, Languedoc",
        "lat": 43.0167,
        "lng": 2.6833,
        "type": "aoc",
        "size": 50,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Corton-Charlemagne",
        "lat": 47.0667,
        "lng": 4.8667,
        "type": "aoc",
        "size": 4,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Côte-Rôtie, Rhône",
        "lat": 45.4667,
        "lng": 4.7667,
        "type": "aoc",
        "size": 10,
        "difficulty": [
            "medium",
            "hard"
        ]
    },
    {
        "name": "Côtes du Rhône",
        "lat": 44.1833,
        "lng": 4.8333,
        "type": "aoc",
        "size": 150,
        "difficulty": [
            "easy"
        ]
    },
    {
        "name": "Gevrey-Chambertin",
        "lat": 47.2267,
        "lng": 4.9644,
        "type": "aoc",
        "size": 8,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Gigondas, Rhône",
        "lat": 44.165,
        "lng": 5.015,
        "type": "aoc",
        "size": 12,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Hermitage, Rhône",
        "lat": 45.0778,
        "lng": 4.8383,
        "type": "aoc",
        "size": 8,
        "difficulty": [
            "medium",
            "hard"
        ]
    },
    {
        "name": "Jurançon, Sud-Ouest",
        "lat": 43.3,
        "lng": -0.4,
        "type": "aoc",
        "size": 20,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "La Tâche, Bourgogne",
        "lat": 47.1611,
        "lng": 4.9597,
        "type": "aoc",
        "size": 2,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Madiran, Sud-Ouest",
        "lat": 43.5167,
        "lng": -0.1333,
        "type": "aoc",
        "size": 25,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Margaux, Bordeaux",
        "lat": 45.0419,
        "lng": -0.6689,
        "type": "aoc",
        "size": 12,
        "difficulty": [
            "medium",
            "hard"
        ]
    },
    {
        "name": "Meursault, Bourgogne",
        "lat": 46.9792,
        "lng": 4.7744,
        "type": "aoc",
        "size": 8,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Minervois, Languedoc",
        "lat": 43.3167,
        "lng": 2.5167,
        "type": "aoc",
        "size": 35,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Montrachet, Bourgogne",
        "lat": 46.95,
        "lng": 4.75,
        "type": "aoc",
        "size": 3,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Muscadet, Loire",
        "lat": 47.1333,
        "lng": -1.3833,
        "type": "aoc",
        "size": 30,
        "difficulty": [
            "easy",
            "hard"
        ]
    },
    {
        "name": "Pauillac, Bordeaux",
        "lat": 45.1967,
        "lng": -0.7489,
        "type": "aoc",
        "size": 15,
        "difficulty": [
            "medium",
            "hard"
        ]
    },
    {
        "name": "Pomerol, Bordeaux",
        "lat": 44.9333,
        "lng": -0.2,
        "type": "aoc",
        "size": 8,
        "difficulty": [
            "medium",
            "hard"
        ]
    },
    {
        "name": "Pommard, Bourgogne",
        "lat": 47,
        "lng": 4.8,
        "type": "aoc",
        "size": 6,
        "difficulty": [
            "medium"
        ]
    },
    {
        "name": "Pouilly-Fumé, Loire",
        "lat": 47.2833,
        "lng": 2.9667,
        "type": "aoc",
        "size": 12,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Quarts de Chaume",
        "lat": 47.3167,
        "lng": -0.7167,
        "type": "aoc",
        "size": 5,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Romanée-Conti, Bourgogne",
        "lat": 47.1608,
        "lng": 4.96,
        "type": "aoc",
        "size": 2,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Saint-Émilion, Bordeaux",
        "lat": 44.8939,
        "lng": -0.1556,
        "type": "aoc",
        "size": 10,
        "difficulty": [
            "medium",
            "hard"
        ]
    },
    {
        "name": "Sancerre, Loire",
        "lat": 47.3333,
        "lng": 2.8333,
        "type": "aoc",
        "size": 15,
        "difficulty": [
            "easy",
            "hard"
        ]
    },
    {
        "name": "Sauternes, Bordeaux",
        "lat": 44.5333,
        "lng": -0.3167,
        "type": "aoc",
        "size": 15,
        "difficulty": [
            "medium",
            "hard"
        ]
    },
    {
        "name": "Savennières, Loire",
        "lat": 47.3833,
        "lng": -0.65,
        "type": "aoc",
        "size": 10,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Vacqueyras, Rhône",
        "lat": 44.1333,
        "lng": 5.0333,
        "type": "aoc",
        "size": 10,
        "difficulty": [
            "hard"
        ]
    },
    {
        "name": "Vouvray, Loire",
        "lat": 47.4111,
        "lng": 0.7983,
        "type": "aoc",
        "size": 12,
        "difficulty": [
            "medium",
            "hard"
        ]
    }
];

export default aocWineRegions;
