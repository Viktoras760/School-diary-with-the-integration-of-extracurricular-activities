import React, { useEffect, useState } from 'react'
import APIController from '../Controllers/APIController'

import { Spinner } from 'react-bootstrap'

export default function Dashboard () {
  const { http } = APIController()
  const [userDetail, setUserDetail] = useState('')

  useEffect(() => {
    fetchUserDetail()
  }, [])

  const fetchUserDetail = () => {
    http.post('/auth/user').then((res) => {
      setUserDetail(res.data)
    })
  }

  function renderElement () {
    if (userDetail) {
      return <div>
                <h4>Name</h4>
                <p>{userDetail.name}</p>
                <h4>Email</h4>
                <p>{userDetail.email}</p>
        {userDetail.role === 'Pupil' && (
          <div>
            <h4>Grade</h4>
            <p>{userDetail.grade}</p>
          </div>
        )}
                <h4>Role</h4>
                <p>{userDetail.role}</p>
            </div>
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
            <h1 className="mb-4 mt-4">Dashboard page</h1>
            {userDetail.fk_Schoolid_School == null
              ? <>
            <p className="mb-4 mt-4"><strong>Warning! You will not be able to see your schools data until you get assigned to it!!!</strong></p></>
              : ''}
            {renderElement()}

        </div>
  )
}
