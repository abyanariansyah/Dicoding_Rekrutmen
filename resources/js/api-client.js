// Helper JavaScript untuk consume API
// Simpan di: resources/js/api-client.js

export class ApiClient {
    constructor(baseUrl = '/api/v1') {
        this.baseUrl = baseUrl;
        this.token = localStorage.getItem('api_token');
    }
    
    /**
     * GET request
     */
    async get(endpoint, params = {}) {
        const url = new URL(this.baseUrl + endpoint, window.location.origin);
        Object.keys(params).forEach(key => 
            url.searchParams.append(key, params[key])
        );
        
        return fetch(url, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                ...(this.token && { 'Authorization': `Bearer ${this.token}` })
            }
        }).then(res => res.json());
    }
    
    /**
     * POST request
     */
    async post(endpoint, data = {}) {
        return fetch(this.baseUrl + endpoint, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                ...(this.token && { 'Authorization': `Bearer ${this.token}` })
            },
            body: JSON.stringify(data)
        }).then(res => res.json());
    }
    
    /**
     * PUT request
     */
    async put(endpoint, data = {}) {
        return fetch(this.baseUrl + endpoint, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                ...(this.token && { 'Authorization': `Bearer ${this.token}` })
            },
            body: JSON.stringify(data)
        }).then(res => res.json());
    }
    
    /**
     * DELETE request
     */
    async delete(endpoint) {
        return fetch(this.baseUrl + endpoint, {
            method: 'DELETE',
            headers: {
                'Accept': 'application/json',
                ...(this.token && { 'Authorization': `Bearer ${this.token}` })
            }
        }).then(res => res.json());
    }
    
    /**
     * Set token (saat user login)
     */
    setToken(token) {
        this.token = token;
        localStorage.setItem('api_token', token);
    }
    
    /**
     * Clear token (saat user logout)
     */
    clearToken() {
        this.token = null;
        localStorage.removeItem('api_token');
    }
    
    /**
     * Get all jobs
     */
    getJobs(params = {}) {
        return this.get('/jobs', params);
    }
    
    /**
     * Get single job
     */
    getJob(id) {
        return this.get(`/jobs/${id}`);
    }
    
    /**
     * Get companies
     */
    getCompanies(params = {}) {
        return this.get('/companies', params);
    }
    
    /**
     * Register user
     */
    register(data) {
        return this.post('/auth/register', data);
    }
    
    /**
     * Login user
     */
    login(email, password) {
        return this.post('/auth/login', { email, password });
    }
    
    /**
     * Get current user
     */
    getMe() {
        return this.get('/auth/me');
    }
    
    /**
     * Logout
     */
    logout() {
        return this.post('/auth/logout');
    }
    
    /**
     * Apply to job
     */
    applyJob(jobId, coverLetter = '') {
        return this.post('/applications', {
            job_id: jobId,
            cover_letter: coverLetter
        });
    }
    
    /**
     * Get user applications
     */
    getApplications(params = {}) {
        return this.get('/applications', params);
    }
    
    /**
     * Get single application
     */
    getApplication(id) {
        return this.get(`/applications/${id}`);
    }
}
