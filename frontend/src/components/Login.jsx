import React, { useState } from 'react';
import axios from '../lib/axios';
import { useNavigate, Link } from 'react-router-dom';

const Login = () => {
    const [form, setForm] = useState({ email: '', password: '' });
    const [error, setError] = useState(null);
    const navigate = useNavigate();

    const handleLogin = async (e) => {
        e.preventDefault();
        setError(null);
        try {
            await axios.get('/sanctum/csrf-cookie');
            
            await axios.post('/login', form);
            
            navigate('/');
        } catch (err) {
            setError('Credenciales incorrectas o fallo de red.');
            console.error(err);
        }
    };

    return (
        <div className="p-8 max-w-md mx-auto bg-white rounded-xl shadow-md mt-10">
            <h2 className="text-2xl font-bold mb-6 text-center">Login</h2>
            {error && <p className="text-red-500 mb-4 text-center">{error}</p>}
            <form onSubmit={handleLogin} className="space-y-4">
                <input 
                    type="email" 
                    placeholder="Email" 
                    className="w-full border p-2 rounded"
                    onChange={e => setForm({ ...form, email: e.target.value })} 
                    required
                />
                <input 
                    type="password" 
                    placeholder="Contraseña" 
                    className="w-full border p-2 rounded"
                    onChange={e => setForm({ ...form, password: e.target.value })} 
                    required
                />
                <button type="submit" className="w-full bg-blue-600 text-white py-2 rounded font-bold hover:bg-blue-700">
                    Entrar
                </button>
            </form>
            <p className="mt-4 text-center text-sm">
                ¿No tienes cuenta? <Link border to="/register" className="text-blue-600 underline">Regístrate aquí</Link>
            </p>
        </div>
    );
};

export default Login;