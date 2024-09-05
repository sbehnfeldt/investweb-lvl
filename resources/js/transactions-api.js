const url = '/api/transactions';

const api = {
    transactions: async () => {
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

    transaction: async (id) => {
        try {
            const response = await fetch(`${url}/${id}`);
            if (!response.ok) {
                throw new Error(`Response status: ${response.status}`);
            }

            return await response.json();
        } catch (error) {
            console.error(error.message);
        }
    },

    delete: async (id) => {
        try {
            const response = await fetch(`${url}/${id}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

        } catch (error) {
            console.error(error);
        }
    }
};

export default api;
