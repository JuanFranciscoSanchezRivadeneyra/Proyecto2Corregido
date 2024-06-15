import React, { useState, useEffect } from 'react';

const FormularioProducto = () => {
    const [nombre, setNombre] = useState('');
    const [categoria, setCategoria] = useState('');
    const [descripcion, setDescripcion] = useState('');
    const [stock, setStock] = useState('');
    const [precio, setPrecio] = useState('');
    const [productos, setProductos] = useState([]);
    const [mensaje, setMensaje] = useState('');
    const [modoEdicion, setModoEdicion] = useState(false);
    const [productoEditar, setProductoEditar] = useState(null);

    useEffect(() => {
        cargarProductos();
    }, []); 

    const cargarProductos = () => {
        fetch('http://localhost/backend/listarproductos.php')
            .then(response => response.json())
            .then(data => {
                console.log(data); 
                setProductos(data); 
            })
            .catch(error => {
                console.error('Error:', error);
            });
    };

    const handleSubmit = (event) => {
        event.preventDefault();
    
        const producto = {
            id: productoEditar ? productoEditar.id : null,
            nombre,
            codigodebarras,
            cantidadstock: parseInt(cantidadstock),
            preciounitario: parseFloat(preciounitario),
            categoriamedicamento,
            fabricante,
        };
    
        const url = modoEdicion ? 'http://localhost/backend/modificarproducto.php' : 'http://localhost/backend/insertarproducto.php';
    
        fetch(url, {
            method: modoEdicion ? 'PUT' : 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(producto),
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la solicitud: ' + response.statusText);
            }
            return response.json();
        })
        .then(data => {
            console.log(data);
            if (data.message === (modoEdicion ? 'Producto actualizado correctamente' : 'Producto insertado correctamente')) {
                setMensaje(`Producto ${data.id} ${modoEdicion ? 'actualizado' : 'insertado'} correctamente.`);
                cargarProductos();
                cancelarEdicion();
            } else {
                setMensaje(`Error al intentar ${modoEdicion ? 'actualizar' : 'guardar'} el producto.`);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            setMensaje('Error en la conexión o servidor.');
        });
    };

    const handleEliminarProducto = (id) => {
        fetch(`http://localhost/backend/eliminarproducto.php?id=${id}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            console.log(data); 
            
            if (data.message === 'Producto eliminado correctamente') {
                setMensaje(`Producto con ID ${id} eliminado correctamente.`);
                cargarProductos(); 
            } else {
                setMensaje('Error al intentar eliminar el producto.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            setMensaje('Error en la conexión o servidor.');
        });
    };

    const cancelarEdicion = () => {
        setModoEdicion(false);
        setProductoEditar(null);
        setNombre('');
        setCodigodeBarras('');
        setCantidadStock('');
        setPrecioUnitario('');
        setCategoriaMedicamento('');
        setFabricante('');
    };

    return (
        <div>
            <h2>Formulario de Producto</h2>
            {modoEdicion ? (
                <form className="w3-container w3-card-4 w3-grey w3-text-red w3-margin" onSubmit={handleSubmit}>
                    <label>Nombre:</label>
                    <input
                        type="text"
                        value={nombre}
                        onChange={(e) => setNombre(e.target.value)}
                        required
                        className="w3-input"
                    /><br />
                    <label>Código de Barras:</label>
                    <input
                        type="text"
                        value={codigobarras}
                        onChange={(e) => setCodigoBarras(e.target.value)}
                        required
                        className="w3-input"
                    /><br />
                    <label>Cantidad en Stock:</label>
                    <input
                        type="number"
                        value={cantidadstock}
                        onChange={(e) => setCantidadStock(e.target.value)}
                        required
                        className="w3-input"
                    /><br />
                    <label>Precio Unitario:</label>
                    <input
                        type="number"
                        step="0.01"
                        value={preciounitario}
                        onChange={(e) => setPrecioUnitario(e.target.value)}
                        required
                        className="w3-input"
                    /><br />
                    <label>Categoría Medicamento:</label>
                    <input
                        type="text"
                        value={categoriamedicamento}
                        onChange={(e) => setCategoriaMedicamento(e.target.value)}
                        required
                        className="w3-input"
                    /><br />
                    <label>Fabricante:</label>
                    <input
                        type="text"
                        value={fabricante}
                        onChange={(e) => setFabricante(e.target.value)}
                        required
                        className="w3-input"
                    /><br />
                    <button type="submit" className="w3-button w3-block w3-section w3-red w3-ripple">Guardar Cambios</button>
                    <button type="button" className="w3-button w3-block w3-section w3-red w3-ripple" onClick={cancelarEdicion}>Cancelar</button>
                </form>
            ) : (
                <form className="w3-container w3-card-4 w3-yellow w3-text-red w3-margin" onSubmit={handleSubmit}>
                    <label>Nombre:</label>
                    <input
                        type="text"
                        value={nombre}
                        onChange={(e) => setNombre(e.target.value)}
                        required
                        className="w3-input"
                    /><br />
                    <label>Código de Barras:</label>
                    <input
                        type="text"
                        value={codigobarras}
                        onChange={(e) => setCodigoBarras(e.target.value)}
                        required
                        className="w3-input"
                    /><br />
                    <label>Cantidad en Stock:</label>
                    <input
                        type="number"
                        value={cantidadstock}
                        onChange={(e) => setCantidadStock(e.target.value)}
                        required
                        className="w3-input"
                    /><br />
                    <label>Precio Unitario:</label>
                    <input
                        type="number"
                        step="0.01"
                        value={preciounitario}
                        onChange={(e) => setPrecioUnitario(e.target.value)}
                        required
                        className="w3-input"
                    /><br />
                    <label>Categoría Medicamento:</label>
                    <input
                        type="text"
                        value={categoriamedicamento}
                        onChange={(e) => setCategoriaMedicamento(e.target.value)}
                        required
                        className="w3-input"
                    /><br />
                    <label>Fabricante:</label>
                    <input
                        type="text"
                        value={fabricante}
                        onChange={(e) => setFabricante(e.target.value)}
                        required
                        className="w3-input"
                    /><br />
                    <button type="submit" className="w3-button w3-block w3-section w3-red w3-ripple">Guardar Producto</button>
                </form>
            )}
    
            {mensaje && <p>{mensaje}</p>}
    
            <h2>Lista de Productos</h2>
            <table className="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">
                <thead>
                    <tr className="w3-red">
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Código de Barras</th>
                        <th>Cantidad en Stock</th>
                        <th>Precio Unitario</th>
                        <th>Categoría Medicamento</th>
                        <th>Fabricante</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    {productos.map(producto => (
                        <tr key={producto.id}>
                            <td>{producto.id}</td>
                            <td>{producto.nombre}</td>
                            <td>{producto.codigobarras}</td>
                            <td>{producto.cantidadstock}</td>
                            <td>{producto.preciounitario}</td>
                            <td>{producto.categoriamedicamento}</td>
                            <td>{producto.fabricante}</td>
                            <td>
                                <button className="w3-button w3-red w3-hover-pink" onClick={() => handleEliminarProducto(producto.id)}>Eliminar</button>
                            </td>
                        </tr>
                    ))}
                </tbody>
            </table>
        </div>
    );
    
};

export default FormularioProducto;