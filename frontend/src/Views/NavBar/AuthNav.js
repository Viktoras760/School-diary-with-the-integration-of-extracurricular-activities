import { Routes, Route } from 'react-router-dom';
import Home from '../Home';
import Dashboard from '../Dashboard';
import UserLessons from '../UserLessons';
import SchoolList from '../Schools';
import EditSchool from '../School';
import AddSchool from '../AddSchool';
import UserList from '../Users';
import EditUser from '../EditUser';
import FloorList from '../FloorList';
import AddFloor from '../AddFloor';
import AddClassroom from '../AddClassroom';
import ClassroomList from '../ClassroomList';
import LessonList from '../LessonList';
import EditClassroom from '../EditClassroom';
import EditLesson from '../EditLesson';
import AddLesson from '../AddLesson';
import Schedule from '../Schedule';
import SchoolUsers from '../SchoolUsers';
import APIController from '../../Controllers/APIController';
import {Navbar, Nav, Container} from 'react-bootstrap';
import {LinkContainer} from 'react-router-bootstrap';
import { useEffect, useState } from "react";
import { useNavigate } from 'react-router-dom';

function Auth() {
    const navigate = useNavigate();
    const { token, logout } = APIController();
    const { http } = APIController();
    const [userdetail, setUserdetail] = useState("");
    const [successMessage, setSuccessMessage] = useState(sessionStorage.getItem('post-success'));

    const logoutUser = () => {
        if (token !== undefined) {
            logout();
            navigate('/login');
            window.location.reload(false);
        }
    }


    useEffect(() => {
        fetchUserDetail();
    }, []);

    const fetchUserDetail = () => {
        http.post("/auth/user").then((res) => {
            setUserdetail(res.data);
        }).catch((error) => {
            if(error.response.data.error != null) {
                alert(error.response.data.error);
            } else if (error.response.data.errors != null) {
                var errors = error.response.data.errors;
                var all_errors = [];
                Object.keys(errors).map((err) => (
                    all_errors.push(errors[err][0])
                ))
                alert(all_errors.join("\n"));
            }
        })
    };

    return (
        <>
            <Navbar bg="dark" variant="dark" expand="lg">
                <Container>
                    <LinkContainer to="/">
                        <Navbar.Brand>Your diary</Navbar.Brand>
                    </LinkContainer>
                    <Navbar.Toggle aria-controls="basic-navbar-nav" />
                    <Navbar.Collapse id="basic-navbar-nav">
                        <Nav className="me-auto">
                            <LinkContainer to="/">
                                <Nav.Link>Home</Nav.Link>
                            </LinkContainer>
                            <LinkContainer to="/dashboard">
                                <Nav.Link>Dashboard</Nav.Link>
                            </LinkContainer>
                            {userdetail.fk_Schoolid_School != null ? <>
                            <LinkContainer to={`/schools/${userdetail.fk_Schoolid_School}/floors`}>
                                <Nav.Link>School floors</Nav.Link>
                            </LinkContainer></> : ""}
                            <LinkContainer to="/lessons">
                                <Nav.Link>My Lessons</Nav.Link>
                            </LinkContainer>
                            {userdetail.Role === "System Administrator" ? <>
                            <LinkContainer to="/schools">
                                <Nav.Link>Schools</Nav.Link>
                            </LinkContainer>
                            <LinkContainer to="/users">
                                <Nav.Link>Users</Nav.Link>
                            </LinkContainer></> : ""}
                            {userdetail.Role === "School Administrator" ? <>
                            <LinkContainer to="/school_users">
                                <Nav.Link>School Users</Nav.Link>
                            </LinkContainer></> : ""}
                            {userdetail.Role === "Teacher" ? <>
                            <LinkContainer to="/schedule">
                                <Nav.Link>Schedule</Nav.Link>
                            </LinkContainer></> : ""}
                            <Nav.Link onClick={logoutUser}>Logout</Nav.Link>
                        </Nav>
                    </Navbar.Collapse>
                </Container>
            </Navbar>
            <Container>
                <Routes>
                    <Route path="/" element={<Home />} />
                    <Route path="/dashboard" element={<Dashboard />} />
                    <Route path="/lessons" element={<UserLessons />} />
                    <Route path="/schedule" element={<Schedule />} />
                    <Route path="/schools" element={<SchoolList />} />
                    <Route path="/schools/:id" element={<EditSchool />} />
                    <Route path="/school" element={<AddSchool />} />
                    <Route path="/users" element={<UserList />} />
                    <Route path="/school_users" element={<SchoolUsers />} />
                    <Route path="/user/:id" element={<EditUser />} />
                    <Route path="/schools/:id1/floors" element={<FloorList />} />
                    <Route path="/schools/:id1/floor" element={<AddFloor />} />
                    <Route path="/schools/:id1/floors/:id2/classrooms" element={<ClassroomList />} />
                    <Route path="/schools/:id1/floors/:id2/classroom/" element={<AddClassroom />} />
                    <Route path="/schools/:id1/floors/:id2/classroom_edit/:id3" element={<EditClassroom />} />
                    <Route path="/schools/:id1/floors/:id2/classrooms/:id3/lessons" element={<LessonList />} />
                    <Route path="/schools/:id1/floors/:id2/classrooms/:id3/lesson" element={<AddLesson />} />
                    <Route path="/schools/:id1/floors/:id2/classrooms/:id3/edit_lesson/:id4" element={<EditLesson />} />
                </Routes>
            </Container>
        </>
    );
}

export default Auth;
