import React, { useEffect, useState } from 'react'
import APIController from '../Controllers/APIController'
import { Spinner } from 'react-bootstrap'
import LessonDetail from './UserLessons'

export default function Home () {
  const { http } = APIController()
  const [userDetail, setUserDetail] = useState('')
  const [lessonsToday, setLessonsToday] = useState([])

  useEffect(() => {
    fetchUserDetail()
    fetchUserLessons()
  }, [])

  const fetchUserDetail = () => {
    http.post('/auth/user').then((res) => {
      setUserDetail(res.data)
    })
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
              {lessonsToday.map((lesson) => (
                <LessonDetail key={lesson.id_Lesson} lesson={lesson} onDelete={fetchUserLessons} />
              ))}
            </ul>
            : <p>No lessons today.</p>
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
