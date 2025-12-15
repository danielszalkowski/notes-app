import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { Link, useNavigate } from 'react-router-dom';

const NotesList = () => {
    const [notes, setNotes] = useState([]);
    
    const [pagination, setPagination] = useState({
        currentPage: 1,
        lastPage: 1,
        total: 0,
    });
    
    const [search, setSearch] = useState('');
    const [loading, setLoading] = useState(false);
    const [error, setError] = useState(null);
    const navigate = useNavigate();

    const fetchNotes = async (page = 1, query = '') => {
        setLoading(true);
        setError(null);
        try {
            const response = await axios.get(`/api/notes?q=${query}&page=${page}`);
            
            setNotes(response.data.data); 
            
            const meta = response.data.meta;
            setPagination({
                currentPage: meta.current_page,
                lastPage: meta.last_page,
                total: meta.total,
            });

        } catch (err) {
            setError('Error al cargar las notas, ¡fallo el backend o la red!');
            console.error(err);
        } finally {
            setLoading(false);
        }
    };

    useEffect(() => {
        fetchNotes(1);
    }, []);

    const handlePageChange = (newPage) => {
        if (newPage >= 1 && newPage <= pagination.lastPage) {
            fetchNotes(newPage, search);
        }
    };

    const handleDelete = async (id) => {
        if (window.confirm('¿Seguro que quieres borrar esta nota?')) {
            try {
                await axios.delete(`/api/notes/${id}`);
                
                fetchNotes(pagination.currentPage, search); 
            } catch (err) {
                alert('Fallo al borrar la nota.');
            }
        }
    };
    
    const handleSearch = (e) => {
        e.preventDefault();
        fetchNotes(1, search);
    };

    if (loading && notes.length === 0) return <p className="text-center mt-8">Cargando notas...</p>;
    if (error) return <p className="text-red-500 font-bold text-center mt-8">{error}</p>;

    return (
        <div>
            <div className="flex justify-between items-center mb-6">
                {}
                <Link to="/new" className="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow transition duration-150">
                    + Nueva Nota
                </Link>
                
                {}
                <form onSubmit={handleSearch} className="flex">
                    <input
                        type="text"
                        placeholder="Buscar por título..."
                        value={search}
                        onChange={(e) => setSearch(e.target.value)}
                        className="border p-2 rounded-l-md w-64 focus:ring-blue-500 focus:border-blue-500"
                    />
                    <button type="submit" className="bg-blue-600 hover:bg-blue-700 text-white p-2 rounded-r-md transition duration-150" disabled={loading}>
                        Buscar
                    </button>
                </form>
            </div>

            {notes.length === 0 && !loading && <p className="text-center text-gray-600">No hay notas que coincidan con la búsqueda.</p>}

            {}
            <div className="grid grid-cols-1 md:grid-cols-2 gap-6"> 
                {notes.map((note) => (
                    <div key={note.id} className="p-5 border rounded-lg shadow-md bg-white hover:shadow-xl transition duration-200">
                        {}
                        <Link to={`/notes/${note.id}`} className="block hover:text-blue-600"> 
                            <h3 className="text-xl font-semibold mb-2 cursor-pointer truncate">{note.title}</h3>
                        </Link> 
                        <p className="text-gray-600 mb-4 line-clamp-3">{note.content || 'Sin contenido'}</p>
                        
                        <div className="flex justify-between items-center text-sm text-gray-500 pt-2 border-t mt-3">
                            <span>{new Date(note.created_at).toLocaleDateString()}</span>
                            <div className="flex space-x-2">
                                {}
                                <Link
                                    to={`/notes/${note.id}`}
                                    className="bg-yellow-500 text-white py-1 px-3 rounded hover:bg-yellow-600 transition duration-150"
                                >
                                    Ver / Editar
                                </Link>
                                <button
                                    onClick={() => handleDelete(note.id)}
                                    className="bg-red-600 text-white py-1 px-3 rounded hover:bg-red-700 transition duration-150"
                                >
                                    Borrar
                                </button>
                            </div>
                        </div>
                    </div>
                ))}
            </div>

            {}
            {pagination.lastPage > 1 && (
                <div className="flex justify-center items-center space-x-2 mt-8">
                    <button
                        onClick={() => handlePageChange(pagination.currentPage - 1)}
                        disabled={pagination.currentPage === 1 || loading}
                        className="px-4 py-2 bg-gray-300 rounded disabled:opacity-50 hover:bg-gray-400 transition duration-150"
                    >
                        Anterior
                    </button>

                    <span className="text-gray-700 font-semibold">
                        Página {pagination.currentPage} de {pagination.lastPage}
                    </span>

                    <button
                        onClick={() => handlePageChange(pagination.currentPage + 1)}
                        disabled={pagination.currentPage === pagination.lastPage || loading}
                        className="px-4 py-2 bg-gray-300 rounded disabled:opacity-50 hover:bg-gray-400 transition duration-150"
                    >
                        Siguiente
                    </button>
                </div>
            )}
        </div>
    );
};

export default NotesList;