import { useState } from "react";
import axios from "axios";
import { useNavigate } from "react-router-dom";
import { BASE_API_URI } from "./constants";
import "./styles.css";

export default function ListUser() {
    const navigate = useNavigate();

    const [inputs, setInputs] = useState([]);

    const handleChange = (event) => {
        const name = event.target.name;
        const value = event.target.value;
        setInputs(values => ({...values, [name]: value}));
    }
    const handleSubmit = (event) => {
        event.preventDefault();

        axios.post(`${BASE_API_URI}/api/user/save`, inputs).then(function(response){
            console.log(response.data);
            navigate('/');
        });
        
    }
    return (
        <div className="container">
            <div className="form-card">
                <h1>Create User</h1>
                <form onSubmit={handleSubmit}>
                    <div className="form-group">
                        <label>Name:</label>
                        <input type="text" name="name" onChange={handleChange} />
                    </div>
                    <div className="form-group">
                        <label>Email:</label>
                        <input type="email" name="email" onChange={handleChange} />
                    </div>
                    <div className="form-group">
                        <label>Mobile:</label>
                        <input type="text" name="mobile" onChange={handleChange} />
                    </div>
                    <div className="button-container">
                        <button type="submit">Save</button>
                    </div>
                </form>
            </div>
        </div>
    );
}
