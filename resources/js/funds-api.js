const url = '/api/funds';

const api = {
    funds: async () => {
        try {
            const response = await fetch(url);
            if (!response.ok) {
                throw new Error(`Response status: ${response.status}`);
            }

            const json = await response.json();
            return json;

        } catch (error) {
            console.error(error.message);
        }
    },
    fund: async (id) => {
        try {
            const response = await fetch(`${url}/${id}`);
            if (!response.ok) {
                throw new Error(`Response status: ${response.status}`);
            }

            const json = await response.json();
            return json;

        } catch (error) {
            console.error(error.message);
        }
    }
};

export default api;
