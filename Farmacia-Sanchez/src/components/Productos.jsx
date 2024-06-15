import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';

const Productoss = () => {
    const [newProduct, setNewProduct] = useState({
        id_producto: '',
        nom_producto: '',
        codigodebarras: '',
        cantidadstock: '',
        preciounitario: '',
        categoriamedicamento: '',
        fabricante: '',
        
    });
};

export default Productoss;
