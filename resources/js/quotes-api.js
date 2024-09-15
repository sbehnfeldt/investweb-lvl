const url = '/api/quotes';

const api = {
    quotes: async () => {
        try {
            const response = await fetch(url);
            if (!response.ok) {
                throw new Error(`Response status: ${response.status}`);
            }
            return await response.json();
        } catch (error) {
            console.error(error.message);
        }
    },
    latest: async () => {
        try {
            const response = await fetch(`${url}?latest`);
            if (!response.ok) {
                throw new Error(`Response status: ${response.status}`);
            }
            return await response.json();
        } catch (error) {
            console.error(error.message);
        }
    }
};

export default api;
