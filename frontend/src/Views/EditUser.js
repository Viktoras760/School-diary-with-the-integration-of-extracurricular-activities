import React, { useEffect, useState, useRef } from 'react'
import APIController from '../Controllers/APIController'
import { Spinner, Button, Row, Col, Card, Form, Alert } from 'react-bootstrap'
import { useNavigate, useParams } from 'react-router-dom'
import autoAnimate from '@formkit/auto-animate'
import PropTypes from 'prop-types'

export default function EditUser () {
  const { http } = APIController()
  const navigate = useNavigate()

  const { id } = useParams()

  const [name, setName] = useState('')
  const [surname, setSurname] = useState('')
  const [personalCode, setPersonalCode] = useState('')
  const [email, setEmail] = useState('')
  const [grade, setGrade] = useState('')
  const [role, setRole] = useState('')
  const [password, setPassword] = useState('')
  const [confirmation, setConfirmation] = useState('')
  const [schoolId, setSchoolID] = useState('')
  const [schools, setSchools] = useState([])

  const [currentUserSchool, setCurrentUserSchool] = useState('')

  const [isLoading, setLoading] = useState(false)

  const [errorMessage, setErrorMessage] = useState('')

  const [open, setOpen] = useState(false)
  const parentRef = useRef(null)

  useEffect(() => {
    fetchUserDetails()
    fetchSchools()
    if (parentRef.current) {
      autoAnimate(parentRef.current)
    }
  }, [])

  const showMore = () => setOpen(!open)

  const fetchUserDetails = () => {
    http
      .get(`/users/${id}`)
      .then((res) => {
        setName(res.data.name)
        setSurname(res.data.surname)
        setPersonalCode(res.data.personalCode)
        setEmail(res.data.email)
        setGrade(res.data.grade)
        setRole(res.data.role)
        setPassword(res.data.password)
        setConfirmation(res.data.confirmation)
        setSchoolID(res.data.fk_Schoolid_School)
        getCurrentUserSchool(res.data.fk_Schoolid_School).then(r => setCurrentUserSchool(r))
      })
      .catch(() => {
        navigate('/users/')
      })
  }

  const fetchSchools = () => {
    http
      .get('/schools/')
      .then((res) => {
        setSchools(res.data)
      })
      .catch(() => {
        navigate('/users/')
      })
  }

  const updateUser = () => {
    setLoading(true)
    http
      .put(`/users/${id}`, {
        name,
        surname,
        personalCode,
        email,
        grade,
        role,
        password,
        confirmation,
        fk_Schoolid_School: schoolId
      })
      .then(() => {
        sessionStorage.setItem('post-success', 'User was successfully updated')
        navigate('/users')
      })
      .catch((error) => {
        if (error.response.data.error != null) {
          setErrorMessage(error.response.data.error)
        } else if (error.response.data.errors != null) {
          const errors = error.response.data.errors
          const allErrors = []
          Object.keys(errors).map((err) => allErrors.push(errors[err][0]))
          setErrorMessage(allErrors.join('\n'))
        }
      })
      .finally(() => {
        setLoading(false)
      })
  }

  function ErrorAlert ({ message }) {
    const [show, setShow] = useState(!!message)

    if (show) {
      return (
                <Alert variant='danger' onClose={() => setShow(false)} dismissible className='mt-3'>
                    <Alert.Heading>Error</Alert.Heading>
                    <p>{message}</p>
                </Alert>
      )
    }
    return <></>
  }
  ErrorAlert.propTypes = {
    message: PropTypes.string
  }

  async function getCurrentUserSchool (usersSchoolId) {
    try {
      const res = await http.get(`/schools/${usersSchoolId}`)
      return res.data.name
    } catch (error) {
      console.error(error)
      return null
    }
  }

  const goBack = () => {
    setLoading(true)
    navigate(-1)
  }

  if (name || surname || email) {
    return (
            <Row className="justify-content-center pt-5">
                <Col>
                    <Card className="p-4">
                        <h1 className="text-center mb-3">Edit user</h1>
                        <ErrorAlert message={errorMessage} />
                        <Form.Group className="mb-3" controlId="formBasicName">
                            <Form.Label>Name</Form.Label>
                            <Form.Control type="text" placeholder="Enter name" value={name} onChange={e => setName(e.target.value)} />
                        </Form.Group>
                        <Form.Group className="mb-3" controlId="formBasicSurname">
                            <Form.Label>Surname</Form.Label>
                            <Form.Control type="text" placeholder="Enter surname" value={surname} onChange={e => setSurname(e.target.value)} />
                        </Form.Group>
                        <Form.Group className="mb-3" controlId="formBasicEmail">
                            <Form.Label>Email</Form.Label>
                            <Form.Control type="email" placeholder="Enter email" value={email} onChange={e => setEmail(e.target.value)} />
                        </Form.Group>
                        <Form.Group className="mb-3" controlId="formBasicGrade">
                        <div className="px-2 cursor-pointer py-1 border-2 border-gray-200 w-[400px] rounded-lg" ref={parentRef}>
                            <div onClick={showMore} className="select-none font-bold w-full flex justify-between items-center">
                                <Form.Label>Show personal code</Form.Label>
                            </div>
                            {open && (
                                <Form.Control readOnly type="number" placeholder="Enter personal code" value={personalCode} onChange={e => setPersonalCode(e.target.value)} />
                            )}
                        </div>
                        </Form.Group>
                        <Form.Group className="mb-3" controlId="formBasicGrade">
                            <Form.Label>Grade</Form.Label>
                            <Form.Select className="mb-3" defaultValue={grade} onChange={e => setGrade(e.target.value)}>
                                <option value={grade} >{grade}</option>
                                <option value="0" >0</option>
                                <option value="1" >1</option>
                                <option value="2" >2</option>
                                <option value="3" >3</option>
                                <option value="4" >4</option>
                                <option value="5" >5</option>
                                <option value="6" >6</option>
                                <option value="7" >7</option>
                                <option value="8" >8</option>
                                <option value="9" >9</option>
                                <option value="10" >10</option>
                                <option value="11" >11</option>
                                <option value="12" >12</option>
                            </Form.Select>
                        </Form.Group>
                        <Form.Group className="mb-3" controlId="formBasicRole">
                            <Form.Label>Role</Form.Label>
                            <Form.Select className="mb-3" defaultValue={role} onChange={e => setRole(e.target.value)}>
                                <option value={role} >{role}</option>
                                <option value="Pupil" >Pupil</option>
                                <option value="Teacher" >Teacher</option>
                                <option value="School Administrator" >School Administrator</option>
                                <option value="System Administrator" >System Administrator</option>
                            </Form.Select>
                        </Form.Group>
                        <Form.Group className="mb-3" controlId="formBasicConfirmation">
                            <Form.Label>Confirmation</Form.Label>
                            <Form.Select className="mb-3" defaultValue={confirmation} onChange={e => setConfirmation(e.target.value)}>
                                <option value={confirmation} >{confirmation}</option>
                                <option value="Confirmed" >Confirmed</option>
                                <option value="Unconfirmed" >Unconfirmed</option>
                                <option value="Declined" >Declined</option>
                            </Form.Select>
                        </Form.Group>
                        <Form.Group className="mb-3" controlId="formBasicSchool">
                            <Form.Label>School</Form.Label>
                            <Form.Select onChange={e => setSchoolID(e.target.value)}>
                                <option value={schoolId}>{currentUserSchool}</option>
                                {schools.map(sch => (
                                  <option key={sch.id_School} value={sch.id_School}>
                                    {sch.name}
                                  </option>
                                ))}
                            </Form.Select>
                        </Form.Group>
                        <Button variant="primary" type="submit" disabled={isLoading} onClick={!isLoading ? updateUser : null}>
                            {isLoading ? <><Spinner animation="border" size="sm" /> Loading…</> : 'Edit'}
                        </Button>
                      <Button variant="secondary" disabled={isLoading} onClick={!isLoading ? goBack : null} style={{ marginTop: '10px', backgroundColor: 'gray' }}>
                        {isLoading ? <><Spinner animation="border" size="sm" /> Loading…</> : 'Cancel'}
                      </Button>
                    </Card>
                </Col>
            </Row>
    )
  } else {
    return (
            <Row className="justify-content-center pt-5">
                <Spinner animation="border" />
            </Row>
    )
  }
}
