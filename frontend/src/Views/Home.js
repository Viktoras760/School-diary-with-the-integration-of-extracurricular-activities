import React, { useEffect, useState } from 'react'
import APIController from '../Controllers/APIController'
import { Button, Card, Modal, Spinner, Table } from 'react-bootstrap'
import PropTypes from 'prop-types'

export default function Home () {
  const { http } = APIController()
  const [userDetail, setUserDetail] = useState('')
  const [lessonsToday, setLessonsToday] = useState([])

  const [isLoadingDelete, setLoadingDelete] = useState(false)
  const [isLoadingApprove] = useState(false)

  useEffect(() => {
    fetchUserDetail()
    fetchUserLessons()
  }, [])

  const fetchUserDetail = () => {
    http.post('/auth/user').then((res) => {
      setUserDetail(res.data)
    })
  }

  const deleteLesson = () => {
    setLoadingDelete(true)
  }

  const fetchUserLessons = () => {
    http.get('/user_lessons').then((res) => {
      const today = new Date().toISOString().substr(0, 10)
      const lessons = res.data.filter((lesson) => lesson.lessonsStartingTime.includes(today))
      setLessonsToday(lessons)
    }).catch((error) => {
      console.log(error)
    })
  }

  function submitDelete (lesson) {
    http
      .delete(`/user_lessons/${lesson.id_Lesson}`)
      .then((res) => {
        alert(res.data.success)
        fetchUserLessons()
      })
      .catch((error) => {
        if (error.response.data.error != null) {
          alert(error.response.data.error)
        } else if (error.response.data.errors != null) {
          const errors = error.response.data.errors
          const allErrors = []
          Object.keys(errors).map((err) => allErrors.push(errors[err][0]))
          alert(allErrors.join('\n'))
        }
      })
      .finally(() => {
        setLoadingDelete(false)
      })
  }

  function DeleteApproval ({ message, lesson }) {
    const [show, setShow] = useState(message)

    const handleSubmit = () => {
      setShow(false)
      submitDelete(lesson)
    }

    const handleClose = () => {
      setShow(false)
      setLoadingDelete(false)
    }

    return (
      <>
        <Modal show={show} onHide={handleClose}>
          <Modal.Header closeButton>
            <Modal.Title>Unregister from lesson</Modal.Title>
          </Modal.Header>
          <Modal.Body>
            Are you sure you want to unregister from {lesson.lessonsName}?
          </Modal.Body>
          <Modal.Footer>
            <Button variant="danger" onClick={handleSubmit}>
              Unregister
            </Button>
            <Button variant="secondary" onClick={handleClose}>
              Cancel
            </Button>
          </Modal.Footer>
        </Modal>
      </>
    )
  }

  DeleteApproval.propTypes = {
    message: PropTypes.bool.isRequired,
    lesson: PropTypes.object.isRequired
  }

  function renderElement () {
    if (userDetail) {
      let greeting
      if (userDetail.role === 'Pupil') {
        greeting = `Hi ${userDetail.name}, welcome to the student dashboard! You are currently in grade ${userDetail.grade} and your email is ${userDetail.email}.`
      } else if (userDetail.role === 'Teacher') {
        greeting = `Hello ${userDetail.name}, welcome to the teacher dashboard! You can manage your students and assignments here. Your email is ${userDetail.email}.`
      } else {
        greeting = `Welcome, ${userDetail.name}! Your email is ${userDetail.email} and your role is ${userDetail.role}.`
      }

      return (
        <div>
          <p className="fs-5">{greeting}</p>
          {/* eslint-disable-next-line react/no-unescaped-entities */}
          <h2>Today's Lessons</h2>
          {lessonsToday.length > 0
            ? <ul>
              <Card className="justify-content-center mt-3" border="light">
                <Card.Title className="mb-0">
                </Card.Title>
                <Table striped hover responsive>
                  <thead>
                  <tr>
                    <th>Name</th>
                    <th>Starting Time</th>
                    <th>Ending Time</th>
                    <th>Details</th>
                    <th>Unregister</th>
                  </tr>
                  </thead>
                  <tbody>
              {lessonsToday.map((lesson, index) => (
                    <tr key={index}>
                      <DeleteApproval message={isLoadingDelete} lesson={lesson} />
                      <td>{lesson.lessonsName}</td>
                      <td>{lesson.lessonsStartingTime}</td>
                      <td>{lesson.lessonsEndingTime}</td>
                      <td>
                        <Button
                          variant="primary"
                          className="w-100 mb-2"
                          disabled={isLoadingApprove}
                        >
                          {isLoadingApprove
                            ? (
                              <>
                                <Spinner animation="border" size="sm" /> Fetching details…
                              </>
                              )
                            : (
                                'Details'
                              )}
                        </Button>
                      </td>
                      <td>
                        <Button
                          variant="danger"
                          className="w-100"
                          disabled={isLoadingDelete}
                          onClick={!isLoadingDelete ? deleteLesson : null}
                        >
                          {isLoadingDelete
                            ? (
                              <>
                                <Spinner animation="border" size="sm" /> Unregistering…
                              </>
                              )
                            : (
                                'Unregister'
                              )}
                        </Button>
                      </td>
                    </tr>
              ))}
                  </tbody>
                </Table>
              </Card>
            </ul>
            : <Card className="justify-content-center mt-3" border="light">
              <Card.Title className="mb-0">
              </Card.Title>
              <Table striped hover responsive>
                <thead>
                <tr>
                  <th>Name</th>
                  <th>Starting Time</th>
                  <th>Ending Time</th>
                  <th>Details</th>
                  <th>Unregister</th>
                </tr>
                </thead>
                <tbody>
                <tr className="text-center">
                  <td colSpan={5}>You have no planned activities for today.</td>
                </tr>
                </tbody>
              </Table>
            </Card>
          }
        </div>

      )
    } else {
      return (
        <div className="text-center">
          <Spinner animation="border" />
        </div>
      )
    }
  }

  return (
    <div>
      <h1 className="mb-4 mt-4">Greetings {userDetail.name}</h1>
      {userDetail.fk_Schoolid_School == null && (
        <p className="mb-4 mt-4">
          <strong>
            {/* eslint-disable-next-line react/no-unescaped-entities */}
            Warning! You will not be able to see your school's data until you get
            assigned to it!!!
          </strong>
        </p>
      )}
      {renderElement()}
    </div>
  )
}
