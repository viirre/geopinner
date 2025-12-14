// Export places from JS modules to JSON for database seeding
import { allPlaces } from './resources/js/places/index.js';
import fs from 'fs';

// Write to JSON file
fs.writeFileSync(
    './database/seeders/places-data.json',
    JSON.stringify(allPlaces, null, 2)
);

console.log(`✓ Exported ${allPlaces.length} places to database/seeders/places-data.json`);
