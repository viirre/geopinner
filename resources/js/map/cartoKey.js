const CARTO_KEY = import.meta.env.VITE_CARTO_KEY;

/**
 * Appends the CARTO API key (VITE_CARTO_KEY) to a tile URL when one is configured.
 */
export const withCartoKey = (url) => (CARTO_KEY ? `${url}?key=${CARTO_KEY}` : url);
