import axios from "axios"
import { useEffect, useState } from "react";
import { BASE_API_URI } from "./constants";
import "./styles.css";


export default function ListUser() {

    const [users, setUsers] = useState([]);
    useEffect(() => {
        getUsers();
    }, []);

    function getUsers() {
        axios.get(`${BASE_API_URI}/api/users/`).then(function(response) {
            console.log(response.data);
            setUsers(response.data);
        });
    }

    const deleteUser = (id) => {
        axios.delete(`${BASE_API_URI}/user/${id}/delete`).then(function(response){
            console.log(response.data);
            getUsers();
        });
    }
    return (
        <div className="table-container">
            <h1>List Users</h1>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                    </tr>
                </thead>
                <tbody>
                    {users.map((user, key) =>
                        <tr key={key}>
                            <td>{user.id}</td>
                            <td>{user.name}</td>
                            <td>{user.email}</td>
                            <td>{user.mobile}</td>
                        </tr>
                    )}
                    
                </tbody>
            </table>
        </div>
    )
}
