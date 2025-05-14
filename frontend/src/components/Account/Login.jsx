import { useState } from "react";
import { NavLink } from "react-router";
import useFetch from "../../hooks/useFetch";

export default function Login() {
    const [form, setForm] = useState({ email: "", password: "" });

    const handleChange = e => setForm({ ...form, [e.target.name]: e.target.value });

    const handleSubmit = async e => {
        e.preventDefault();
        
        const res = await fetch("http://localhost:8000/api/token/", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(form),
        });
        
        const data = await res.json();
        
        if (res.ok) {
            localStorage.setItem("access_token", data.access);
            localStorage.setItem("refresh_token", data.refresh);

            // On récupère les infos de l'utilisateur
            const userRes = await fetch('http://localhost:8000/api/user/', {
                method: 'GET',
                headers: {
                    "Accept": "application/json",
                    'Authorization': `Bearer ${data.access}`
                }
            });

            const contentType = userRes.headers.get("content-type");
            if (!contentType || !contentType.includes("application/json")) {
              const errorText = await userRes.text();
              throw new Error("Réponse non-JSON : " + errorText);
            }

            const userData = await userRes.json();
            
            if (userRes.ok) {
                localStorage.setItem("user_data", JSON.stringify(userData));
                window.location.href = "/dashboard";
            } else {
                console.error("Impossible de récupérer les données de l'utilisateur");
            }


        } else {
            alert("Échec de la connexion.");
        }
    };

    return (
        <form onSubmit={handleSubmit} className="max-w-md mx-auto mt-10 bg-gray-100 p-8 rounded-lg shadow-lg">
            <h2 className="text-3xl font-bold text-gray-800 mb-6 text-center">Connexion</h2>
            <div className="mb-4">
                <input 
                    name="email" 
                    type="email" 
                    placeholder="Email" 
                    required 
                    value={form.email} 
                    onChange={handleChange} 
                    className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
            </div>
            <div className="mb-6">
                <input 
                    name="password" 
                    type="password" 
                    placeholder="Mot de passe" 
                    required 
                    value={form.password} 
                    onChange={handleChange} 
                    className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
            </div>
            <button 
                type="submit" 
                className="w-full bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition duration-300"
            >
                Se connecter
            </button>
            <p className="mt-4 text-center">
                Pas de compte ? <NavLink to="/register" className="text-blue-500 hover:underline">Créer un compte</NavLink>
            </p>
        </form>
    );
}
