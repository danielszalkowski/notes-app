import React, { useState } from 'react';
import axios from '../lib/axios';
import { useNavigate } from 'react-router-dom';

const Register = () => {
    const navigate = useNavigate();
    const [form, setForm] = useState({
        name: '', email: '', password: '', password_confirmation: '', office_id: 1
    });

const handleRegister = async (e) => {
    e.preventDefault();
    console.log("1. Empezamos el registro..."); // Mete este log para debuguear
    try {
        await axios.get('/sanctum/csrf-cookie');
        console.log("2. Cookie recibida, lanzando POST...");
        
        // ¡Ojo aquí! Asegúrate de que esta URL es la correcta
        const response = await axios.post('/register', form); 
        
        console.log("3. Respuesta del servidor:", response);
        alert('¡Usuario registrado!');
        navigate('/');
    } catch (err) {
        console.error("4. Error en el proceso:", err.response?.data || err.message);
    }
};

    return (
        <div className="p-8 max-w-md mx-auto bg-white rounded-xl shadow-md">
            <h2 className="text-2xl font-bold mb-4">Registro de Usuario</h2>
            <form onSubmit={handleRegister} className="space-y-4">
                <input type="text" placeholder="Nombre" className="w-full border p-2" onChange={e => setForm({ ...form, name: e.target.value })} />
                <input type="email" placeholder="Email" className="w-full border p-2" onChange={e => setForm({ ...form, email: e.target.value })} />
                <input type="password" placeholder="Password" className="w-full border p-2" onChange={e => setForm({ ...form, password: e.target.value })} />
                <input type="password" placeholder="Confirmar Password" className="w-full border p-2" onChange={e => setForm({ ...form, password_confirmation: e.target.value })} />

                <label className="block font-bold">Oficina asignada:</label>
                <select className="w-full border p-2" onChange={e => setForm({ ...form, office_id: e.target.value })}>
                    <option value="1">Oficina Central Valencia (ID 1)</option>
                    <option value="2">Oficina Secundaria Madrid (ID 2)</option>
                </select>

                <button type="submit" className="w-full bg-blue-600 text-white py-2 rounded">Darse de alta</button>
            </form>
        </div>
    );
};

export default Register;