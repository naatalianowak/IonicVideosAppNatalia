import axios from 'axios';

const apiClient = axios.create({
  baseURL: 'http://localhost:8000/api',
  headers: {
    Accept: 'application/json',
  },
});

apiClient.interceptors.request.use(
    (config) => {
      const token = localStorage.getItem('token');
      console.log('Sending request with token:', token);
      if (token) {
        config.headers.Authorization = `Bearer ${token}`;
      } else {
        console.warn('No token found in localStorage');
      }
      return config;
    },
    (error) => Promise.reject(error)
);

export default apiClient;