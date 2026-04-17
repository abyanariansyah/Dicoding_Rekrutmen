import './bootstrap';
import { ApiClient } from './api-client';

// Create global API client instance
window.api = new ApiClient();

// Load token from localStorage if exists
const token = localStorage.getItem('api_token');
if (token) {
    window.api.setToken(token);
}
