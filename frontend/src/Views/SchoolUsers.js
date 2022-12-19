import React, {useEffect, useState} from "react";
import APIController from '../Controllers/APIController';
import { Navigate, useParams} from 'react-router-dom';
import { useNavigate } from 'react-router-dom';
import {Spinner, Button, Row, Col, Alert, Modal} from 'react-bootstrap';

function SchoolUsers() {

    const navigate = useNavigate();
    const { http } = APIController();
    const [Users, setUsers] = useState('');

    useEffect(() => {
        fetchUsers();
    }, []);

    const fetchUsers= () => {

        console.log("fetching");
        http.get('/school_users/').then((res) => {
            setUsers(res.data);
        });
        

    };
    const editUser= async(e, id) => {
        navigate(`/user/${id}`);
    };

    const DeleteUser= async(e, id) => {


        http.delete(`/users/${id}`, {
            
        }).then((res) => {
            console.log(res.data);
            window.location.reload();
        }).catch((res) => {
            //alert(res.data);
            alert("Failed to remove user");
            navigate(`/school_users/`);
        })  
        navigate(`/school_users/`);
    };

    return (
        <div>
          <div className="container">
            <div className="row">
              <div className="col-md-12">
                <div className="card">
                  <div className="card-header">
                    <h4><svg height="24" width="24" viewBox="0 0 24 24" class="EmployeeSelect-module_avatar_f8203f" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid meet" fill="currentColor"><path d="M17.6 13.714A9.987 9.987 0 0122 22h-2a8 8 0 00-4.124-7 8.026 8.026 0 001.724-1.286zM12 2a6 6 0 01.225 11.996L12 14a8 8 0 00-8 8H2c0-4.21 2.603-7.814 6.287-9.288A6 6 0 0112 2zm0 2C9.79 4 8 5.79 8 8s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4z" fill-rule="evenodd"></path></svg>Users</h4>
                  </div>
                  <div className="card-body">
                    </div>
                  <table className="table">
                    <thead>
                      <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Surname</th>
                        <th scope="col">Email</th>
                        <th scope="col">Grade</th>
                        <th scope="col">Role</th>
                        <th scope="col">Edit</th>
                        <th scope="col">Delete</th>
                      </tr>
                    </thead>
                    <tbody>
                      {Object.entries(Users).map(([key, val]) => (
                        <tr key={val.id_User}>
                          <th scope="row">{val.Name}</th>
                          <th scope="row">{val.Surname}</th>
                          <th scope="row">{val.email}</th>
                          <th scope="row">{val.Grade}</th>
                          <th scope="row">{val.Role}</th>
                          <td>
                            <button
                              className="btn btn-success"
                              onClick={(e) => editUser(e, val.id_User)}
                            >
                              Edit
                            </button>
                          </td>
                          <td>
                            <button
                              className="btn btn-warning"
                              onClick={(e) => DeleteUser(e, val.id_User)}
                            >
                              Delete
                            </button>
                          </td>
                        </tr>
                      ))}
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
    );
    
}

export default SchoolUsers;