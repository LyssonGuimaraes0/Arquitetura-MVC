
const api = {

    async request(url, options = {}) {

        let body = null;

        let headers = {
            ...options.headers
        };

        if (options.body instanceof FormData) {

            body = options.body;

        } else if (options.body) {

            headers['Content-Type'] = 'application/json';
            body = JSON.stringify(options.body);

        }

        try {

            const response = await fetch(URLBASE + url, {
                method: options.method ?? 'GET',
                credentials: 'include',
                headers,
                body
            });

            const data = await response.json(); 

            if (!response.ok) {
                throw data;
            }

            return data;

        } catch (error) {

            return {
                success: false,
                error: error.message ?? 'Erro inesperado'
            };

        }

    },

    get(url) {
        return this.request(url);
    },

    post(url, body) {
        return this.request(url, {
            method: 'POST',
            body
        });
    },

    put(url, body) {
        return this.request(url, {
            method: 'PUT',
            body
        });
    },

    delete(url) {
        return this.request(url, {
            method: 'DELETE'
        });
    }

};

export default api;