import axios from 'axios';

const axiosInstance = axios.create({
    baseURL: '/api', // Base URL para las solicitudes
    timeout: 10000,  // Tiempo máximo de espera (en milisegundos)
    headers: {
        'Content-Type': 'application/json',
        // Agregar más encabezados si es necesario
    },
});


export default axiosInstance;
