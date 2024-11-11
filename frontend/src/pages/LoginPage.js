import React, { useState } from 'react';

function LoginPage() {
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');

    const handleLogin = (e) => {
        e.preventDefault();
    // Aquí se llamará al servicio de autenticación
    console.log('Login:', { email, password });
    };

    return (
    <div>
        <h2>Iniciar Sesión</h2>
        <form onSubmit={handleLogin}>
        <input
            type="email"
            placeholder="Correo electrónico"
            value={email}
            onChange={(e) => setEmail(e.target.value)}
        />
        <input
            type="password"
            placeholder="Contraseña"
            value={password}
            onChange={(e) => setPassword(e.target.value)}
        />
            <button type="submit">Iniciar Sesión</button>
        </form>
        </div>
    );
}

export default LoginPage;
