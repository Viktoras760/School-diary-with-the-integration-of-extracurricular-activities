import { useEffect, useState } from 'react';
import APIController from '../Controllers/APIController';

import {Spinner} from 'react-bootstrap';

export default function Dashboard() {
    const { http } = APIController();
    const [userdetail, setUserdetail] = useState('');

    useEffect(() => {
        fetchUserDetail();
    }, []);

    const fetchUserDetail = () => {
        http.post('/auth/user').then((res) => {
            setUserdetail(res.data);
        });
    }

    function renderElement() {
        if (userdetail) {
            return <div>
                <h4>Name</h4>
                <p>{userdetail.Name}</p>
                <h4>Email</h4>
                <p>{userdetail.email}</p>
                <h4>Grade</h4>
                <p>{userdetail.Grade}</p>
                <h4>Role</h4>
                <p>{userdetail.Role}</p>
            </div>
        } else {
            return (
                <div className="text-center">
                    <Spinner animation="border" />
                </div>
            );
        }

    }

    return (
        <div>
            <h1 className="mb-4 mt-4">Dashboard page</h1>
            {userdetail.fk_Schoolid_School == null ? <>
            <p className="mb-4 mt-4"><strong>Warning! You won't be able to see your schools data until you get assigned to it!!!</strong></p></> : ""}
            {renderElement()}
    
        </div>
    )
}