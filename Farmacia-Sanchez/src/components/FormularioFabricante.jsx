import React, { useState, useEffect } from 'react';

const FormularioFabricante = () => {
    const [nombre, setNombre] = useState('');
    const [telefono, setTelefono] = useState('');
    const [direccion, setDireccion] = useState('');
    const [correo, setCorreo] = useState('');
    const [fabricantes, setFabricantes] = useState([]);
    const [mensaje, setMensaje] = useState('');
    const [modoEdicion, setModoEdicion] = useState(false);
    const [fabricanteEditar, setFabricanteEditar] = useState(null);

    useEffect(() => {
        cargarFabricantes();
    }, []);

    const cargarFabricantes = () => {
        fetch('http://localhost/backend/listarfabricante.php')
            .then(response => response.json())
            .then(data => {
                setFabricantes(data);
            })
            .catch(error => {
                console.error('Error:', error);
            });
    };

    const handleSubmit = (event) => {
        event.preventDefault();

        const fabricante = {
            nombre,
            telefono,
            direccion,
            correo,
        };

        const url = modoEdicion ? 'http://localhost/backend/modificarfabricante.php' : 'http://localhost/backend/insertarfabricante.php';

        fetch(url, {
            method: modoEdicion ? 'PUT' : 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(fabricante),
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la solicitud: ' + response.statusText);
            }
            return response.json();
        })
        .then(data => {
            if (data.message === (modoEdicion ? 'Fabricante actualizado correctamente' : 'Fabricante insertado correctamente')) {
                setMensaje(`Fabricante ${data.id} ${modoEdicion ? 'actualizado' : 'insertado'} correctamente.`);
                cargarFabricantes();
                cancelarEdicion();
            } else {
                setMensaje(`Error al intentar ${modoEdicion ? 'actualizar' : 'guardar'} el fabricante.`);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            setMensaje('Error en la conexión o servidor.');
        });
    };

    const handleEliminarFabricante = (id) => {
        fetch(`http://localhost/backend/eliminarfabricante.php?id=${id}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.message === 'Fabricante eliminado correctamente') {
                setMensaje(`Fabricante con ID ${id} eliminado correctamente.`);
                cargarFabricantes();
            } else {
                setMensaje('Error al intentar eliminar el fabricante.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            setMensaje('Error en la conexión o servidor.');
        });
    };

    const iniciarEdicion = (fabricante) => {
        setModoEdicion(true);
        setFabricanteEditar(fabricante);
        setNombre(fabricante.nombre);
        setTelefono(fabricante.telefono);
        setDireccion(fabricante.direccion);
        setCorreo(fabricante.correo);
    };

    const cancelarEdicion = () => {
        setModoEdicion(false);
        setFabricanteEditar(null);
        setNombre('');
        setTelefono('');
        setDireccion('');
        setCorreo('');
    };

    return (
        <div>
            <h2>Formulario de Fabricante</h2>
            {modoEdicion ? (
                <form className="w3-container w3-card-4 w3-grey w3-text-black w3-margin" onSubmit={handleSubmit}>
                    <label htmlFor="nombre">Nombre:</label>
                    <input
                        type="text"
                        id="nombre"
                        name="nombre"
                        value={nombre}
                        onChange={(e) => setNombre(e.target.value)}
                        required
                        className="w3-input"
                    /><br />
                    <label htmlFor="telefono">Teléfono:</label>
                    <input
                        type="text"
                        id="telefono"
                        name="telefono"
                        value={telefono}
                        onChange={(e) => setTelefono(e.target.value)}
                        required
                        className="w3-input"
                    /><br />
                    <label htmlFor="direccion">Dirección:</label>
                    <textarea
                        id="direccion"
                        name="direccion"
                        value={direccion}
                        onChange={(e) => setDireccion(e.target.value)}
                        required
                        className="w3-input"
                    /><br />
                    <button type="submit" className="w3-button w3-block w3-section w3-red w3-ripple">Guardar Cambios</button>
                    <button type="button" className="w3-button w3-block w3-section w3-red w3-ripple" onClick={cancelarEdicion}>Cancelar</button>
                </form>
            ) : (
                <form className="w3-container w3-card-4 w3-grey w3-text-black w3-margin" onSubmit={handleSubmit}>
                    <label htmlFor="nombre">Nombre:</label>
                    <input
                        type="text"
                        id="nombre"
                        name="nombre"
                        value={nombre}
                        onChange={(e) => setNombre(e.target.value)}
                        required
                        className="w3-input"
                    /><br />
                    <label htmlFor="telefono">Teléfono:</label>
                    <input
                        type="text"
                        id="telefono"
                        name="telefono"
                        value={telefono}
                        onChange={(e) => setTelefono(e.target.value)}
                        required
                        className="w3-input"
                    /><br />
                    <label htmlFor="direccion">Dirección:</label>
                    <textarea
                        id="direccion"
                        name="direccion"
                        value={direccion}
                        onChange={(e) => setDireccion(e.target.value)}
                        required
                        className="w3-input"
                    /><br />
                    <button type="submit" className="w3-button w3-block w3-section w3-red w3-ripple">Guardar Fabricante</button>
                </form>
            )}

            {mensaje && <p>{mensaje}</p>}

            <h2>Lista de Fabricantes</h2>
            <table className="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">
                <thead>
                    <tr className="w3-red">
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Teléfono</th>
                        <th>Dirección</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    {fabricantes.map(fabricante => (
                        <tr key={fabricante.id}>
                            <td>{fabricante.id}</td>
                            <td>{fabricante.nombre}</td>
                            <td>{fabricante.telefono}</td>
                            <td>{fabricante.direccion}</td>
                            <td>
                                <button className="w3-button w3-red w3-hover-pink" onClick={() => handleEliminarFabricante(fabricante.id)}>Eliminar</button>
                            </td>
                        </tr>
                    ))}
                </tbody>
            </table>
        </div>
    );
};

export default FormularioFabricante;
