import React from 'react'
import { Link } from 'react-router-dom'
import { Card } from 'react-bootstrap'
import { FaUser, FaChalkboardTeacher } from 'react-icons/fa'

const RegisterPage = () => {
  return (
    <div className="card-container" style={{ display: 'flex', justifyContent: 'center', alignItems: 'center', height: '100vh' }}>
      <Link to="/register" style={{ textDecoration: 'none' }}>
        <Card style={{ width: '350px', height: '450px', margin: '10px 30px', boxShadow: '0px 4px 8px rgba(0, 0, 0, 0.1)' }}>
          <Card.Body style={{ display: 'flex', flexDirection: 'column', justifyContent: 'center', alignItems: 'center' }}>
            <FaUser style={{ fontSize: '4em', marginBottom: '20px' }} />
            <Card.Title>Student Registration</Card.Title>
            <Card.Text>
              Register as a student to browse and book classes.
            </Card.Text>
          </Card.Body>
        </Card>
      </Link>

      <Link to="/register?teacher=true" style={{ textDecoration: 'none' }}>
        <Card style={{ width: '350px', height: '450px', margin: '10px 30px', boxShadow: '0px 4px 8px rgba(0, 0, 0, 0.1)' }}>
          <Card.Body style={{ display: 'flex', flexDirection: 'column', justifyContent: 'center', alignItems: 'center' }}>
            <FaChalkboardTeacher style={{ fontSize: '4em', marginBottom: '20px' }} />
            <Card.Title>Teacher Registration</Card.Title>
            <Card.Text>
              Register as a teacher to create and manage classes.
            </Card.Text>
          </Card.Body>
        </Card>
      </Link>
    </div>
  )
}

export default RegisterPage
