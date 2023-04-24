# Klasiu-nuoma

# Saityno-taikomųjų-programų-projektavimas

# Klasių nuoma užklasinei veiklai ir mokyklos tvarkaraščių sistema (Idėja)
Kiekvieno aukšto klasių ir pamokų sąrašai (tvarkaraščiai)

Kiekvienos klasės užimtumo (pamokų) grafikas

Laisvų kabinetų rezervacija užklasinei veiklai 

*Galima pridėti ir vertinimo (pažymių) sistemą*

# Sistemos paskirtis

Projekto tiklas - sujungti moksleivių pamokas ir užklasinės veiklas į vieną tvarkaraštį, bei palengvinti patalpų paieškos problemą užklasinės veiklos vedėjams/mokytojams/repetitoriams

Moksleivis norėdamas prisijungti prie svetainės turės susikūrti paskyrą ir palaukti kol ją patvirtins administratorius. Po paskyros patvirtinimo moksleivis galės matyti visas jo klasei (tuo pačiu ir jam) priskirtas pamokas ( savo tvarkaraštį ) ir pamokų aprašymą ( vedantį mokytoją, savaitines valandas ir t.t.). Taip pat moksleivis galės prisidėti užklasinės veiklas į savo tvarkaraštį.  *Galima pridėti ir vertinimo (pažymių) sistemą*

Mokytojas po paskyros patvirtinimo galės matyti jam priskirtas vesti pamokas ir juose turinčius dalyvauti moksleivius. Taip pat mokytojas gali dirbti repetitoriumi užregistruojant papildomas pamokas kaip užklasinę veiklą laisvuose kabinetuose.

# Objektai: mokykla -> aukštas -> klasė

# Rolės ir jų funkcijos: 

Sistemos administratorius:

• Naujos mokyklos pridėjimas/redagavimas/peržiūra/šalinimas

• Mokyklos administratoriaus paskyros sukūrimas/šalinimas/redagavimas/peržiūra



Mokyklos Administratorius: 

• Naujos paskyros patvirtinimas

• Paskyrų šalinimas/redagavimas/peržiura/kūrimas

• Vedančio pamoką mokytojo keitimas

• Pamokų priskirimas mokytojams

• Užklasinės veiklos kūrimo patvirtinimas

Moksleivis: 

• Tvarkaraščio peržiūra

• Kiekvieno dalyko(modulio) informacijos peržiūra

• Registracija/Atsisakymas į užklasines veiklas

Mokytojas/Užklasinės veiklos vedėjas:

• Laisvų klasių tvarkaraščio peržiūra

• Laisvų klasių rezervacija

• Užklasinės veiklos sukūrimas, aprašymas, redagavimas, šalinimas

# Architektūra

Sistemos sudedamosios dalys:
• Kliento pusė (ang. Front-End) – naudojant React.js; • Serverio pusė (angl. Back-End) – naudojant PHP Laravel. Duomenų bazė – MySQL.

![image](https://user-images.githubusercontent.com/35394736/209125043-b15e80fa-7979-4181-a7ac-4d253c17c9ea.png)

# Naudotojo sąsajos projektas
## Register langas
>Wireframe
![image](https://user-images.githubusercontent.com/35394736/209127321-ff664e82-fa39-4065-9940-6e660110ba5e.png)
Realizacija
![image](https://user-images.githubusercontent.com/35394736/209127995-f5239c35-c855-44cb-92bb-44725aee697f.png)
>
## Login langas
>Wireframe
![image](https://user-images.githubusercontent.com/35394736/209128974-999955ee-3c28-4886-9911-469514abc90a.png)
Realizacija
![image](https://user-images.githubusercontent.com/35394736/209129019-22aafb85-2322-421e-8323-6c2e7b46fe9d.png)
>
## Home langas
>Wireframe
![image](https://user-images.githubusercontent.com/35394736/209129787-a5aa6ee5-1a56-430e-8338-164eedef742b.png)
Realizacija
![image](https://user-images.githubusercontent.com/35394736/209129737-812cdbc4-dedb-4f04-a2bb-cfe1a99d280d.png)
>
## Dashboard langas
>Wireframe
![image](https://user-images.githubusercontent.com/35394736/209129867-296b8bc2-9ad3-4401-a9be-4a1923120b2d.png)
Realizacija
![image](https://user-images.githubusercontent.com/35394736/209129988-596c6666-81c4-438b-b5a0-10f7f76d2402.png)
>
## Users langas
>Wireframe
![image](https://user-images.githubusercontent.com/35394736/209135723-d2049081-0a9f-49dd-b58b-8e8c58638c3d.png)
Realizacija
![image](https://user-images.githubusercontent.com/35394736/209130199-972b51c3-c975-4989-b52e-482897be99a3.png)
>
## Edit user langas
>Wireframe
![image](https://user-images.githubusercontent.com/35394736/209130329-7b76cd0e-7022-414b-ba1c-186f606d3cca.png)
Realizacija
![image](https://user-images.githubusercontent.com/35394736/209130396-5d4be702-e667-45b1-b6e3-3cbe10b4a02b.png)
![image](https://user-images.githubusercontent.com/35394736/209130452-c0953560-d9a1-4189-aa1a-72cddbfc2ff4.png)
>
## Schools langas
>Wireframe
![image](https://user-images.githubusercontent.com/35394736/209131101-44f77c2c-cb68-470a-8dc1-cbf72131292d.png)
Realizacija
![image](https://user-images.githubusercontent.com/35394736/209131140-0b9194eb-6314-41c3-b8b4-02aa97551d13.png)
>
## Add school langas
>Wireframe
![image](https://user-images.githubusercontent.com/35394736/209131277-b0aafa8d-c5f6-4464-8d51-d3d3af49e947.png)
Realizacija
![image](https://user-images.githubusercontent.com/35394736/209131325-b370d0c5-07f6-4ee4-8cb5-fa314617cd73.png)
>
## School floors langas
>Wireframe
![image](https://user-images.githubusercontent.com/35394736/209131799-76c08d78-3d23-4ff3-b519-9822822a6f3a.png)
Realizacija
![image](https://user-images.githubusercontent.com/35394736/209131849-1ac54b2c-35df-4c8b-bac8-882e29199f89.png)
>
## Add floor langas
>Wireframe
![image](https://user-images.githubusercontent.com/35394736/209131945-101566db-5adb-48d9-bca4-fe414c8fdbc9.png)
Realizacija
![image](https://user-images.githubusercontent.com/35394736/209131964-4b91a1e0-26fe-444b-bab9-a67e43e5dd3f.png)
>
## Floor classrooms langas
>Wireframe
![image](https://user-images.githubusercontent.com/35394736/209132139-2c163df9-be80-4b96-a450-6772c75fca73.png)
Realizacija
![image](https://user-images.githubusercontent.com/35394736/209132094-b7db535b-37ce-4800-8e8c-6811a5ad3b02.png)
>
## Edit classroom langas
>Wireframe
![image](https://user-images.githubusercontent.com/35394736/209132677-e27cfc63-b9fa-41c4-87d3-77c8b169071f.png)
Realizacija
![image](https://user-images.githubusercontent.com/35394736/209132699-17e39c53-abc9-4601-8075-5c94381316f6.png)
>
## Add classroom langas
>Wireframe
![image](https://user-images.githubusercontent.com/35394736/209132759-b7d5f71b-ca82-4b68-a14c-4223cc8fdb40.png)
Realizacija
![image](https://user-images.githubusercontent.com/35394736/209132841-d065958b-785e-42aa-86f5-d91e43a7eac4.png)
>
## Classroom lessons langas
>Wireframe
![image](https://user-images.githubusercontent.com/35394736/209134243-2f2b8ee8-5c44-4025-b233-12ad20f8008e.png)
Realizacija
![image](https://user-images.githubusercontent.com/35394736/209132915-4adb576a-31ed-47d3-a779-57c9f0c53ce7.png)
>
## Add new lesson langas
>Wireframe
![image](https://user-images.githubusercontent.com/35394736/209134915-ad89b067-ca43-4bb5-84d2-77c210972abe.png)
Realizacija
![image](https://user-images.githubusercontent.com/35394736/209134944-629ef9f9-83ed-4db8-8344-e9b9ab1ae554.png)
>
## Edit lesson langas
>Wireframe
![image](https://user-images.githubusercontent.com/35394736/209135077-4061d8c2-86b8-466d-8d13-b333db322a3d.png)
Realizacija
![image](https://user-images.githubusercontent.com/35394736/209135113-fbbfb56c-dea1-4d76-a681-888aa8756bba.png)
>
## My lessons langas
>Wireframe
![image](https://user-images.githubusercontent.com/35394736/209135185-8da266e9-db16-4297-8d1d-150086500af3.png)
Realizacija
![image](https://user-images.githubusercontent.com/35394736/209135333-1667656c-fb6d-4352-8d7e-7b2aa78bfd01.png)
>

# API specifikacija
## POST api/auth/users
#### Užregistruoja nauja vartotoją, gali pasiekti visi neprisijungę vartotojai (svečiai)
#### Resource URL
##### `18.159.77.71/api/auth/users`
#### Resource information
| Response formats             |     JSON      |
| ---------------------------- | ------------- |
| Requires authentication      |      No       |
| Possible error codes         |   201, 400    |

#### Parameters
|   Name       | Required |       Description       |   Default value   |   Example    |
| --------     | -------- | ----------------------- | ----------------- | ------------ |
| Name         | Yes      | Users name              |                   | Viktoras     |
| Surname      | Yes      | Users surname           |                   | Dechtiar     |
| Personal code| Yes      | Users personal code     |                   | 39911140570  |
| Email        | Yes      | Users email             |                   | vikdec@ktu.lt|
| Password     | Yes      | New password            |                   | vikdec       |

#### Example request
`POST 18.159.77.71/api/auth/users Name='Viktoras' Surname='Dechtiar' Personal_code='39911140570' email='vikdec12@ktu.lt' password='vikdec'`
#### Example Response
    {
        "status": "success",
        "message": "User created successfully",
        "user": {
            "Name": "Viktoras",
            "Surname": "Dechtiar",
            "Personal_code": "39911140570",
            "email": "vikdec12@gmail.com",
            "password": "$2y$10$pwrWRKJbwkyozY6BJuoTm.acIfY3ZDoBQxn2xr7DGtNbHxYtpQPAi",
            "updated_at": "2022-12-22T13:09:37.000000Z",
            "created_at": "2022-12-22T13:09:37.000000Z",
            "id_User": 13
        },
        "authorisation": {
            "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMTguMTU5Ljc3LjcxL2FwaS9hdXRoL3VzZXJzIiwiaWF0IjoxNjcxNzE0NTc3LCJleHAiOjE2NzE3MTgxNzcsIm5iZiI6MTY3MTcxNDU3NywianRpIjoicDgxcTRINmdISGlNRXlVQiIsInN1YiI6IjEzIiwicHJ2IjoiMjNiZDVjODk0OWY2MDBhZGIzOWU3MDFjNDAwODcyZGI3YTU5NzZmNyIsIlVzZXJzIGlkIjoxMywiUm9sZSI6bnVsbH0.Gm72JS6gW7VMCP3TAcHwEhodUKbPGGQNGrIagZtuzfc",
            "type": "bearer"
        }
    }
    
## POST api/auth/iat
#### Prijungia konkretų vartotoją prie sistemos
#### Resource URL
##### `18.159.77.71/api/auth/iat`
#### Resource information
| Response formats             |     JSON      |
| ---------------------------- | ------------- |
| Requires authentication      |      No       |
| Possible error codes         |   200, 500    |

#### Parameters
|   Name       | Required |       Description       |   Default value   |   Example    |
| --------     | -------- | ----------------------- | ----------------- | ------------ |
| Email        | Yes      | Users email             |                   | vikdec@ktu.lt|
| Password     | Yes      | New password            |                   | vikdec       |

#### Example request
`POST 18.159.77.71/api/auth/iat email='vikdec12@ktu.lt' password='vikdec'`
#### Example Response
    {
    "status": "success",
    "user": {
        "Name": "Viktoras",
        "Surname": "Dechtiar",
        "Personal_code": 39911140570,
        "email": "vikdec12@gmail.com",
        "Grade": "0",
        "password": "$2y$10$pwrWRKJbwkyozY6BJuoTm.acIfY3ZDoBQxn2xr7DGtNbHxYtpQPAi",
        "Confirmation": "Unconfirmed",
        "id_User": 13,
        "Role": "Pupil",
        "created_at": "2022-12-22T13:09:37.000000Z",
        "updated_at": "2022-12-22T13:09:37.000000Z"
    },
    "authorisation": {
        "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMTguMTU5Ljc3LjcxL2FwaS9hdXRoL2lhdCIsImlhdCI6MTY3MTcxODY5MSwiZXhwIjoxNjcxNzIyMjkxLCJuYmYiOjE2NzE3MTg2OTEsImp0aSI6ImlRTXhXR3k4YTVtTHJMWWoiLCJzdWIiOiIxMyIsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJVc2VycyBpZCI6MTMsIlJvbGUiOiJQdXBpbCJ9.wjygthyRkINot9ejRWK_JTL2kzW1ucfA8OSCzHpLZ3k",
        "type": "bearer"
    }
    }

## POST api/auth/user
#### Gražina konkretaus prisijungusio vartotojo informaciją
#### Resource URL
##### `18.159.77.71/api/auth/user`
#### Resource information
| Response formats             |     JSON      |
| ---------------------------- | ------------- |
| Requires authentication      |      Yes      |
| Possible error codes         | 200, 404, 401 |

#### Parameters
None

#### Example request
`POST 18.159.77.71/api/auth/user authorization: Bearer Token`
#### Example Response
    {
    "Name": "Viktoras",
    "Surname": "Dechtiar",
    "Personal_code": 39911140570,
    "email": "vikdec12@gmail.com",
    "Grade": "0",
    "password": "$2y$10$pwrWRKJbwkyozY6BJuoTm.acIfY3ZDoBQxn2xr7DGtNbHxYtpQPAi",
    "Confirmation": "Unconfirmed",
    "id_User": 13,
    "Role": "Pupil",
    "created_at": "2022-12-22T13:09:37.000000Z",
    "updated_at": "2022-12-22T14:28:09.000000Z"
    }


## GET api/auth/tokens
#### Atjungia konkretų vartotoją nuo sistemos
#### Resource URL
##### `18.159.77.71/api/auth/tokens`
#### Resource information
| Response formats             |     JSON      |
| ---------------------------- | ------------- |
| Requires authentication      |      Yes      |
| Possible error codes         |   200, 401    |

#### Parameters
None

#### Example request
`GET 18.159.77.71/api/auth/tokens authorization: Bearer Token`
#### Example Response
    {
    "status": "success",
    "message": "Successfully logged out"
    }

## POST api/auth/tokens
#### Atnaujina prisijungusio vartotojo JWT tokeną
#### Resource URL
##### `18.159.77.71/api/auth/tokens`
#### Resource information
| Response formats             |     JSON      |
| ---------------------------- | ------------- |
| Requires authentication      |      Yes      |
| Possible error codes         |   200, 401    |

#### Parameters
None

#### Example request
`POST 18.159.77.71/api/auth/tokens authorization: Bearer Token`
#### Example Response
    {
    "status": "success",
    "user": {
        "Name": "Viktoras",
        "Surname": "Dechtiar",
        "Personal_code": 39911140570,
        "email": "vikdec12@gmail.com",
        "Grade": "0",
        "password": "$2y$10$pwrWRKJbwkyozY6BJuoTm.acIfY3ZDoBQxn2xr7DGtNbHxYtpQPAi",
        "Confirmation": "Unconfirmed",
        "id_User": 13,
        "Role": "Pupil",
        "created_at": "2022-12-22T13:09:37.000000Z",
        "updated_at": "2022-12-22T14:35:28.000000Z"
    },
    "authorisation": {
        "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMTguMTU5Ljc3LjcxL2FwaS9hdXRoL3Rva2VucyIsImlhdCI6MTY3MTcxOTcyOCwiZXhwIjoxNjcxNzIzMzM3LCJuYmYiOjE2NzE3MTk3MzcsImp0aSI6ImwzaFhiU1VVaVhIUW1kSWgiLCJzdWIiOiIxMyIsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJVc2VycyBpZCI6MTMsIlJvbGUiOiJQdXBpbCJ9.6pbvkjdWTzx4K6uMCPGEQjI5Ddpk0CvoPM3Y6BZpOqE",
        "type": "bearer"
    }
    }

## POST api/schools
#### Prideda naują mokyklą
#### Resource URL
##### `18.159.77.71/api/schools`
#### Resource information
| Response formats             |     JSON      |
| ---------------------------- | ------------- |
| Requires authentication      |      Yes      |
| Possible error codes         |   200, 400    |

#### Parameters
|   Name         | Required |       Description       |   Default value   |   Example                              |
| -------------- | -------- | ----------------------- | ----------------- | -------------------------------------- |
| Name           | Yes      | Schools name            |                   | Kauno Simono Daukanto progimnazija     |
| Adress         | Yes      | Schools adress          |                   | Taikos pr. 68, 51300 Kaunas            |
| Pupil_amount   | Yes      | Current pupil amount    |                   | 800                                    |
| Teacher_amount | Yes      | Current teacher amount  |                   | 59                                     |

#### Example request
`POST 18.159.77.71/api/schools Name='Kauno Simono Daukanto progimnazija' Adress='Taikos pr. 68, 51300 Kaunas' Pupil_amount=800 Teacher_amount=59 authorization: Bearer Token`
#### Example Response
    {
        "Name": "Kauno Simono Daukanto progimnazija",
        "Adress": "Taikos pr. 68, 51300 Kaunas",
        "Pupil_amount": "800",
        "Teacher_amount": "59",
        "id_School": 4
    }

## PUT api/schools/:id
#### Atnaujina mokyklos informaciją
#### Resource URL
##### `18.159.77.71/api/schools/:id`
#### Resource information
| Response formats             |        JSON        |
| ---------------------------- | ------------------ |
| Requires authentication      |         Yes        |
| Possible error codes         | 200, 400, 401, 404 |

#### Parameters
|   Name         | Required |       Description       |   Default value   |   Example                              |
| -------------- | -------- | ----------------------- | ----------------- | -------------------------------------- |
| Name           | Yes      | Schools name            |                   | Kauno Simono Daukanto progimnazija     |
| Adress         | Yes      | Schools adress          |                   | Taikos pr. 68, 51300 Kaunas            |
| Pupil_amount   | Yes      | Current pupil amount    |                   | 855                                    |
| Teacher_amount | Yes      | Current teacher amount  |                   | 75                                     |

#### Example request
`PUT 18.159.77.71/api/schools/4 Name='Kauno Simono Daukanto progimnazija' Adress='Taikos pr. 68, 51300 Kaunas' Pupil_amount=855 Teacher_amount=75 authorization: Bearer Token`
#### Example Response
    {
        "success": "School updated successfully"
    }

## GET api/schools/:id
#### Gauna mokyklos informaciją
#### Resource URL
##### `18.159.77.71/api/schools/:id`
#### Resource information
| Response formats             |        JSON        |
| ---------------------------- | ------------------ |
| Requires authentication      |         Yes        |
| Possible error codes         |    200, 401, 404   |

#### Parameters
|   Name         | Required |       Description       |   Default value   |   Example      |
| -------------- | -------- | ----------------------- | ----------------- | -------------- |
| Id             | Yes      | Schools id              |                   | 4              |

#### Example request
`GET 18.159.77.71/api/schools/4 authorization: Bearer Token`
#### Example Response
    {
        "id_School": 4,
        "Name": "Kauno Simono Daukanto progimnazija",
        "Adress": "Taikos pr. 68, 51300 Kaunas",
        "Pupil_amount": 855,
        "Teacher_amount": 75
    }
    
## GET api/schools/
#### Gauna visų mokyklų informaciją
#### Resource URL
##### `18.159.77.71/api/schools/`
#### Resource information
| Response formats             |        JSON        |
| ---------------------------- | ------------------ |
| Requires authentication      |         Yes        |
| Possible error codes         |    200, 401, 404   |

#### Parameters
None

#### Example request
`GET 18.159.77.71/api/schools/ authorization: Bearer Token`
#### Example Response
    [
        {
            "id_School": 2,
            "Name": "Kauno Varpo gimnazija",
            "Adress": "Varpo g. 49, 51309 Kaunas",
            "Pupil_amount": 700,
            "Teacher_amount": 52
        },
        {
            "id_School": 3,
            "Name": "S. Dariaus ir S. Girėno gimnazija",
            "Adress": "Miško g. 1, 44321 Kaunas",
            "Pupil_amount": 811,
            "Teacher_amount": 70
        },
        ...
    ]

## DELETE api/schools/:id
#### Ištrina mokyklą iš sistemos
#### Resource URL
##### `18.159.77.71/api/schools/:id`
#### Resource information
| Response formats             |        JSON        |
| ---------------------------- | ------------------ |
| Requires authentication      |         Yes        |
| Possible error codes         | 200, 400, 401, 404 |

#### Parameters
|   Name         | Required |       Description       |   Default value   |   Example      |
| -------------- | -------- | ----------------------- | ----------------- | -------------- |
| Id             | Yes      | Schools id              |                   | 4              |

#### Example request
`DELETE 18.159.77.71/api/schools/4 authorization: Bearer Token`
#### Example Response
    {
        "success": "School deleted"
    }

## POST api/schools/:id/floors
#### Prideda naują aukštą pasirinktai mokyklai
#### Resource URL
##### `18.159.77.71/api/schools/:id/floors`
#### Resource information
| Response formats             |     JSON          |
| ---------------------------- | ----------------- |
| Requires authentication      |      Yes          |
| Possible error codes         | 200, 400, 401 404 |

#### Parameters
|   Name          | Required |       Description            |   Default value   |   Example   |
| --------------- | -------- | ---------------------------- | ----------------- | ----------  |
| Classroom_amount| Yes      | Classroom amount             |                   | 30          |
| Sport_equipment | Yes      | Sport equipment existance    |                   | Yes         |
| Floor_number    | Yes      | Floors number (height)       |                   | 3           |

#### Example request
`POST 18.159.77.71/api/schools/2/floors Classroom_amount='30' Sport_equipment='Yes' Floor_number=3 authorization: Bearer Token`
#### Example Response
    {
        "Floor_number": "3",
        "Classroom_amount": "30",
        "id_Floor": 4
    }

## GET api/schools/:id/floors/:id2
#### Gauna konkrečios mokyklos pasirinkto aukšto informaciją
#### Resource URL
##### `18.159.77.71/api/schools/:id/floors/:id2`
#### Resource information
| Response formats             |        JSON        |
| ---------------------------- | ------------------ |
| Requires authentication      |         Yes        |
| Possible error codes         | 200, 401, 404, 400 |

#### Parameters
|   Name         | Required |       Description       |   Default value   |   Example      |
| -------------- | -------- | ----------------------- | ----------------- | -------------- |
| Id             | Yes      | Schools id              |                   | 4              |
| Id2            | Yes      | Floor id                |                   | 4              |

#### Example request
`GET 18.159.77.71/api/schools/2/floors/4 authorization: Bearer Token`
#### Example Response
    {
        "Floor_number": 3,
        "Classroom_amount": 30,
        "id_Floor": 4
    }

## GET api/schools/:id/floors
#### Gauna visų mokyklos aukštų informaciją
#### Resource URL
##### `18.159.77.71/api/schools/:id/floors`
#### Resource information
| Response formats             |        JSON        |
| ---------------------------- | ------------------ |
| Requires authentication      |         Yes        |
| Possible error codes         | 200, 401, 404, 400 |

#### Parameters
|   Name         | Required |       Description       |   Default value   |   Example      |
| -------------- | -------- | ----------------------- | ----------------- | -------------- |
| Id             | Yes      | Schools id              |                   | 2              |

#### Example request
`GET 18.159.77.71/api/schools/2/floors authorization: Bearer Token`
#### Example Response
    [
        {
            "Floor_number": 1,
            "Classroom_amount": 12,
            "id_Floor": 1
        },
        {
            "Floor_number": 2,
            "Classroom_amount": 30,
            "id_Floor": 2
        },
        {
            "Floor_number": 3,
            "Classroom_amount": 30,
            "id_Floor": 4
        }
    ]

## PUT api/schools/:id/floors/:id2
#### Atnaujina mokyklos pasirinkto aukšto informaciją
#### Resource URL
##### `18.159.77.71/api/schools/:id/floors/:id2`
#### Resource information
| Response formats             |        JSON        |
| ---------------------------- | ------------------ |
| Requires authentication      |         Yes        |
| Possible error codes         | 200, 400, 401, 404 |

#### Parameters
|   Name          | Required |       Description            |   Default value   |   Example    |
| --------------- | -------- | ---------------------------- | ----------------- | ------------ |
| Classroom_amount| Yes      | Classroom amount             |                   | 25           |
| Sport_equipment | Yes      | Sport equipment existance    |                   | No           |
| Id              | Yes      | Schools id                   |                   | 2            |
| Id2             | Yes      | Floor id                     |                   | 4            |

#### Example request
`PUT 18.159.77.71/api/schools/2/floors/4 Classroom_amount=25 Sport_equipment='No' authorization: Bearer Token`
#### Example Response
    {
        "success": "Floor updated successfully"
    }

## DELETE api/schools/:id/floors/:id2
#### Ištrina mokyklos pasirinktą aukštą iš sistemos
#### Resource URL
##### `18.159.77.71/api/schools/:id/floors/:id2`
#### Resource information
| Response formats             |        JSON        |
| ---------------------------- | ------------------ |
| Requires authentication      |         Yes        |
| Possible error codes         | 200, 400, 401, 404 |

#### Parameters
|   Name         | Required |       Description       |   Default value   |   Example      |
| -------------- | -------- | ----------------------- | ----------------- | -------------- |
| Id             | Yes      | Schools id              |                   | 2              |
| Id2            | Yes      | Floor id                |                   | 4              |

#### Example request
`DELETE 18.159.77.71/api/schools/2/floors/4 authorization: Bearer Token`
#### Example Response
    {
        "success": "Floor deleted"
    }

## POST api/schools/:id/floors/:id2/classrooms
#### Prideda naują klasę pasirinktam mokyklos aukštui
#### Resource URL
##### `18.159.77.71/api/schools/:id/floors/:id2/classrooms`
#### Resource information
| Response formats             |     JSON          |
| ---------------------------- | ----------------- |
| Requires authentication      |      Yes          |
| Possible error codes         | 200, 400, 401 404 |

#### Parameters
|   Name             | Required |       Description            |   Default value   |   Example   |
| ---------------    | -------- | ---------------------------- | ----------------- | ----------  |
| Number             | Yes      | Classroom number             |                   | 106         |
| Pupil_capacity     | Yes      | Pupil capacity               |                   | 35          |
| Musical_equipment  | Yes      | Musical equipment existance  |                   | Yes         |
| Chemistry_equipment| Yes      | Chemistry equipment existance|                   | No          |
| Computers          | Yes      | Computer existance in class  |                   | No          |
| Id                 | Yes      | Schools id                   |                   | 2           |
| Id2                | Yes      | Floor id                     |                   | 1           |

#### Example request
`POST 18.159.77.71/api/schools/2/floors/1/classrooms Number='106' Pupil_capacity=35 Musical_equipment='Yes' Chemistry_equipment='No' Computers='No' authorization: Bearer Token`
#### Example Response
    {
        "Number": "106",
        "Pupil_capacity": "15",
        "fk_Floorid_Floor": "1",
        "id_Classroom": 4
    }

## GET api/schools/:id/floors/:id2/classrooms/:id3
#### Gauna pasirinktos mokyklos aukšto klasės informaciją
#### Resource URL
##### `18.159.77.71/api/schools/:id/floors/:id2/classrooms/:id3`
#### Resource information
| Response formats             |        JSON        |
| ---------------------------- | ------------------ |
| Requires authentication      |         Yes        |
| Possible error codes         | 200, 401, 404, 400 |

#### Parameters
|   Name         | Required |       Description       |   Default value   |   Example      |
| -------------- | -------- | ----------------------- | ----------------- | -------------- |
| Id             | Yes      | Schools id              |                   | 2              |
| Id2            | Yes      | Floor id                |                   | 1              |
| Id3            | Yes      | Classroom id            |                   | 1              |

#### Example request
`GET 18.159.77.71/api/schools/2/floors/4/classrooms/1 authorization: Bearer Token`
#### Example Response
    {
        "Number": 105,
        "Pupil_capacity": 25,
        "id_Classroom": 1,
        "fk_Floorid_Floor": 1
    }

## GET api/schools/:id/floors/:id2/classrooms
#### Gauna visų mokyklos aukšto klasių informaciją
#### Resource URL
##### `18.159.77.71/api/schools/:id/floors/:id2/classrooms`
#### Resource information
| Response formats             |        JSON        |
| ---------------------------- | ------------------ |
| Requires authentication      |         Yes        |
| Possible error codes         | 200, 401, 404, 400 |

#### Parameters
|   Name         | Required |       Description       |   Default value   |   Example      |
| -------------- | -------- | ----------------------- | ----------------- | -------------- |
| Id             | Yes      | Schools id              |                   | 2              |
| Id2            | Yes      | Floor id                |                   | 1              |

#### Example request
`GET 18.159.77.71/api/schools/2/floors/1 authorization: Bearer Token`
#### Example Response
    [
        {
            "Number": 105,
            "Pupil_capacity": 25,
            "id_Classroom": 1,
            "fk_Floorid_Floor": 1
        },
        {
            "Number": 101,
            "Pupil_capacity": 15,
            "id_Classroom": 3,
            "fk_Floorid_Floor": 1
        },
        {
            "Number": 106,
            "Pupil_capacity": 15,
            "id_Classroom": 4,
            "fk_Floorid_Floor": 1
        }
    ]

## PUT api/schools/:id/floors/:id2/classrooms/:id3
#### Atnaujina pasirinktos mokyklos aukšto klasės informaciją
#### Resource URL
##### `18.159.77.71/api/schools/:id/floors/:id2/classrooms/:id3`
#### Resource information
| Response formats             |        JSON        |
| ---------------------------- | ------------------ |
| Requires authentication      |         Yes        |
| Possible error codes         | 200, 400, 401, 404 |

#### Parameters
|   Name             | Required |       Description            |   Default value   |   Example   |
| ------------------ | -------- | ---------------------------- | ----------------- | ----------- |
| Number             | Yes      | Classroom number             |                   | 108         |
| Pupil_capacity     | Yes      | Pupil capacity               |                   | 25          |
| Musical_equipment  | Yes      | Musical equipment existance  |                   | Yes         |
| Chemistry_equipment| Yes      | Chemistry equipment existance|                   | No          |
| Computers          | Yes      | Computer existance in class  |                   | No          |
| Id                 | Yes      | Schools id                   |                   | 2           |
| Id2                | Yes      | Floor id                     |                   | 1           |
| Id3                | Yes      | Classroom id                 |                   | 1           |

#### Example request
`PUT 18.159.77.71/api/schools/2/floors/1/classrooms/1 Number='108' Pupil_capacity=25 Musical_equipment='Yes' Chemistry_equipment='No' Computers='No' authorization: Bearer Token`
#### Example Response
    {
        "success": "Classroom updated successfully"
    }

## DELETE api/schools/:id/floors/:id2/classrooms/:id3
#### Ištrina pasirinktą mokyklos aukšto klasę iš sistemos
#### Resource URL
##### `18.159.77.71/api/schools/:id/floors/:id2/classrooms/:id3`
#### Resource information
| Response formats             |        JSON        |
| ---------------------------- | ------------------ |
| Requires authentication      |         Yes        |
| Possible error codes         | 200, 400, 401, 404 |

#### Parameters
|   Name         | Required |       Description       |   Default value   |   Example      |
| -------------- | -------- | ----------------------- | ----------------- | -------------- |
| Id             | Yes      | Schools id              |                   | 2              |
| Id2            | Yes      | Floor id                |                   | 1              |
| Id3            | Yes      | Classroom id            |                   | 4              |

#### Example request
`DELETE 18.159.77.71/api/schools/2/floors/1/classrooms/4 authorization: Bearer Token`
#### Example Response
    {
        "success": "Classroom deleted"
    }

## POST api/schools/:id/floors/:id2/classrooms/:id3/lessons
#### Prideda naują pamoką pasirinktai mokyklos aukšto klasei
#### Resource URL
##### `18.159.77.71/api/schools/:id/floors/:id2/classrooms/:id3/lessons`
#### Resource information
| Response formats             |     JSON          |
| ---------------------------- | ----------------- |
| Requires authentication      |      Yes          |
| Possible error codes         | 200, 400, 401 404 |

#### Parameters
|   Name                    | Required |       Description            |   Default value   |   Example                    |
| ------------------------- | -------- | ---------------------------- | ----------------- | ---------------------------- |
| Lessons_name              | Yes      | Lessons naming               |                   | Matematika                   |
| Lessons_starting_time     | Yes      | Lessons starting time        |                   | 2022-10-29 15:15:00          |
| Lessons_ending_time       | Yes      | Lessons ending time          |                   | 2022-10-29 16:00:00          |
| Lower_grade_limit         | Yes      | Lessons lower grade limit    |                   | 10                           |
| Upper_grade_limit         | Yes      | Lessons upper grade limit    |                   | 12                           |
| Id                        | Yes      | Schools id                   |                   | 2                            |
| Id2                       | Yes      | Floor id                     |                   | 1                            |
| Id3                       | Yes      | Classroom id                 |                   | 1                            |

#### Example request
`POST 18.159.77.71/api/schools/2/floors/1/classrooms/1/lessons Lessons_name='Matematika' Lessons_starting_time='2022-10-29 15:15:00' Lessons_ending_time='2022-10-29 16:00:00' Lower_grade_limit=10 Upper_grade_limit=12 authorization: Bearer Token`
#### Example Response
    {
        "Lessons_name": "Matematika",
        "Lessons_starting_time": "2022-10-29 15:15:00",
        "Lessons_ending_time": "2022-10-29 16:00:00",
        "Lower_grade_limit": "10",
        "Upper_grade_limit": "12",
        "creator_id": 13,
        "id_Lesson": 4
    }

## GET api/schools/:id/floors/:id2/classrooms/:id3/lessons/:id4
#### Gauna pasirinktos mokyklos aukšto klasės pamokos informaciją
#### Resource URL
##### `18.159.77.71/api/schools/:id/floors/:id2/classrooms/:id3/lessons/:id4`
#### Resource information
| Response formats             |        JSON        |
| ---------------------------- | ------------------ |
| Requires authentication      |         Yes        |
| Possible error codes         | 200, 401, 404, 400 |

#### Parameters
|   Name         | Required |       Description       |   Default value   |   Example      |
| -------------- | -------- | ----------------------- | ----------------- | -------------- |
| Id             | Yes      | Schools id              |                   | 2              |
| Id2            | Yes      | Floor id                |                   | 1              |
| Id3            | Yes      | Classroom id            |                   | 1              |
| Id4            | Yes      | Lessons id              |                   | 1              |

#### Example request
`GET 18.159.77.71/api/schools/2/floors/1/classrooms/1/lessons/1 authorization: Bearer Token`
#### Example Response
    {
        "Lessons_name": "Matematika",
        "Lessons_starting_time": "2022-10-23 15:15:00",
        "Lessons_ending_time": "2022-10-23 16:00:00",
        "id_Lesson": 1,
        "Lower_grade_limit": 10,
        "Upper_grade_limit": 10,
        "creator_id": 2
    }

## GET api/schools/:id/floors/:id2/classrooms/:id3/lessons/
#### Gauna pasirinktos mokyklos aukšto klasės pamokų informaciją
#### Resource URL
##### `18.159.77.71/api/schools/:id/floors/:id2/classrooms/:id3/lessons/`
#### Resource information
| Response formats             |        JSON        |
| ---------------------------- | ------------------ |
| Requires authentication      |         Yes        |
| Possible error codes         | 200, 401, 404, 400 |

#### Parameters
|   Name         | Required |       Description       |   Default value   |   Example      |
| -------------- | -------- | ----------------------- | ----------------- | -------------- |
| Id             | Yes      | Schools id              |                   | 2              |
| Id2            | Yes      | Floor id                |                   | 1              |
| Id3            | Yes      | Classroom id            |                   | 1              |

#### Example request
`GET 18.159.77.71/api/schools/2/floors/1/classrooms/1/lessons/ authorization: Bearer Token`
#### Example Response
    [
        {
            "Lessons_name": "Matematika",
            "Lessons_starting_time": "2022-10-22 15:15:00",
            "Lessons_ending_time": "2022-10-22 16:00:00",
            "id_Lesson": 4,
            "Lower_grade_limit": 10,
            "Upper_grade_limit": 10,
            "creator_id": 1
        },
        {
            "Lessons_name": "Matematika",
            "Lessons_starting_time": "2022-10-23 15:15:00",
            "Lessons_ending_time": "2022-10-23 17:00:00",
            "id_Lesson": 5,
            "Lower_grade_limit": 10,
            "Upper_grade_limit": 11,
            "creator_id": 2
        },
        {
            "Lessons_name": "Lietuvių kalba",
            "Lessons_starting_time": "2022-12-22 14:00:00",
            "Lessons_ending_time": "2022-12-22 14:45:00",
            "id_Lesson": 6,
            "Lower_grade_limit": 10,
            "Upper_grade_limit": 10,
            "creator_id": 32
        },
        ...
    ]
    
## PUT api/schools/:id/floors/:id2/classrooms/:id3/lessons/:id4
#### Atnaujina pasirinktos mokyklos aukšto klasės pamokos informaciją
#### Resource URL
##### `18.159.77.71/api/schools/:id/floors/:id2/classrooms/:id3/lessons/:id4`
#### Resource information
| Response formats             |        JSON        |
| ---------------------------- | ------------------ |
| Requires authentication      |         Yes        |
| Possible error codes         | 200, 400, 401, 404 |

#### Parameters
|   Name                    | Required |       Description            |   Default value   |   Example                    |
| ------------------------- | -------- | ---------------------------- | ----------------- | ---------------------------- |
| Lessons_name              | Yes      | Lessons naming               |                   | Geografija                   |
| Lessons_starting_time     | Yes      | Lessons starting time        |                   | 2022-10-29 15:15:00          |
| Lessons_ending_time       | Yes      | Lessons ending time          |                   | 2022-10-29 16:00:00          |
| Lower_grade_limit         | Yes      | Lessons lower grade limit    |                   | 10                           |
| Upper_grade_limit         | Yes      | Lessons upper grade limit    |                   | 12                           |
| Id                        | Yes      | Schools id                   |                   | 2                            |
| Id2                       | Yes      | Floor id                     |                   | 1                            |
| Id3                       | Yes      | Classroom id                 |                   | 1                            |
| Id4                       | Yes      | Lessons id                   |                   | 1                            |

#### Example request
`PUT 18.159.77.71/api/schools/2/floors/1/classrooms/1/lessons/1 Lessons_name='Geografija' Lessons_starting_time='2022-10-29 15:15:00' Lessons_ending_time='2022-10-29 16:00:00' Lower_grade_limit=10 Upper_grade_limit=12 authorization: Bearer Token`
#### Example Response
    {
        "success": "Lesson updated"
    }

## DELETE api/schools/:id/floors/:id2/classrooms/:id3/lessons/:id4
#### Ištrina pasirinktą mokyklos aukšto klasės pamoką iš sistemos
#### Resource URL
##### `18.159.77.71/api/schools/:id/floors/:id2/classrooms/:id3/lessons/:id4`
#### Resource information
| Response formats             |        JSON        |
| ---------------------------- | ------------------ |
| Requires authentication      |         Yes        |
| Possible error codes         | 200, 400, 401, 404 |

#### Parameters
|   Name         | Required |       Description       |   Default value   |   Example      |
| -------------- | -------- | ----------------------- | ----------------- | -------------- |
| Id             | Yes      | Schools id              |                   | 2              |
| Id2            | Yes      | Floor id                |                   | 1              |
| Id3            | Yes      | Classroom id            |                   | 1              |
| Id3            | Yes      | Classroom id            |                   | 9              |

#### Example request
`DELETE 18.159.77.71/api/schools/2/floors/1/classrooms/1/lessons/9 authorization: Bearer Token`
#### Example Response
    {
        "success": "Lesson deleted"
    }

## POST api/schools/:id/floors/:id2/classrooms/:id3/lessons/:id4
#### Registracija pasirinktai pamokai
#### Resource URL
##### `18.159.77.71/api/schools/:id/floors/:id2/classrooms/:id3/lessons/:id4`
#### Resource information
| Response formats             |     JSON          |
| ---------------------------- | ----------------- |
| Requires authentication      |      Yes          |
| Possible error codes         | 200, 400, 401 404 |

#### Parameters
|   Name                    | Required |       Description            |   Default value   |   Example                    |
| ------------------------- | -------- | ---------------------------- | ----------------- | ---------------------------- |
| Id                        | Yes      | Schools id                   |                   | 2                            |
| Id2                       | Yes      | Floor id                     |                   | 1                            |
| Id3                       | Yes      | Classroom id                 |                   | 1                            |
| Id4                       | Yes      | Lessons id                   |                   | 1                            |

#### Example request
`POST 18.159.77.71/api/schools/2/floors/1/classrooms/1/lessons/1 authorization: Bearer Token`
#### Example Response
    {
        "success": "Successfully registered"
    }

## GET api/user_lessons/
#### Gauna pasirinktam vartotojui priskirtų pamokų sąrašą
#### Resource URL
##### `18.159.77.71/api/user_lessons/`
#### Resource information
| Response formats             |        JSON        |
| ---------------------------- | ------------------ |
| Requires authentication      |         Yes        |
| Possible error codes         | 200, 401, 404, 400 |

#### Parameters
None

#### Example request
`GET 18.159.77.71/api/user_lessons/ authorization: Bearer Token`
#### Example Response
    [
        {
            "Lessons_name": "Matematika",
            "Lessons_starting_time": "2022-10-25 15:15:00",
            "Lessons_ending_time": "2022-10-25 16:00:00",
            "id_Lesson": 3,
            "Lower_grade_limit": 12,
            "Upper_grade_limit": 12,
            "creator_id": 5,
            "pivot": {
                "fk_Userid_User": 13,
                "fk_Lessonid_Lesson": 3
            }
        }
    ]

## DELETE api/user_lessons/:id
#### Gauna pasirinktam vartotojui priskirtų pamokų sąrašą
#### Resource URL
##### `18.159.77.71/api/user_lessons/:id`
#### Resource information
| Response formats             |        JSON        |
| ---------------------------- | ------------------ |
| Requires authentication      |         Yes        |
| Possible error codes         | 200, 401, 404, 400 |

#### Parameters
|   Name                    | Required |       Description            |   Default value   |   Example                    |
| ------------------------- | -------- | ---------------------------- | ----------------- | ---------------------------- |
| Id                        | Yes      | Lessons id                   |                   | 3                            |

#### Example request
`DELETE 18.159.77.71/api/user_lessons/3 authorization: Bearer Token`
#### Example Response
    {
        "success": "Successfully unregistered"
    }

## GET api/users/
#### Gauna visų vartotojų sąrašą
#### Resource URL
##### `18.159.77.71/api/users/`
#### Resource information
| Response formats             |        JSON        |
| ---------------------------- | ------------------ |
| Requires authentication      |         Yes        |
| Possible error codes         | 200, 401, 404      |

#### Parameters
None

#### Example request
`GET 18.159.77.71/api/users/ authorization: Bearer Token`
#### Example Response
    [
        {
            "Name": "Test",
            "Surname": "Name",
            "Personal_code": 1234,
            "email": "test@gmail.com",
            "Grade": "0",
            "password": "$2y$10$7yR1EAO.ybhMuA6cUO5nWeGmyZtSOlsYF33cuag6Jnbu41GOLsipu",
            "Confirmation": "Unconfirmed",
            "id_User": 1,
            "Role": "System Administrator",
            "created_at": "2022-11-20T16:49:02.000000Z",
            "updated_at": "2022-11-20T19:08:02.000000Z"
        },
        {
            "Name": "Vytenis",
            "Surname": "Bertulis",
            "Personal_code": 39905104125,
            "email": "vytber@gmail.com",
            "Grade": "0",
            "password": "$2y$10$oVxj5beNdKuSCBjum7wloer/621aUGpZyfGwq.xSux/BM4XygygD6",
            "Confirmation": "Confirmed",
            "id_User": 2,
            "Role": "System Administrator",
            "created_at": "2022-11-20T17:13:35.000000Z",
            "updated_at": "2022-11-20T19:00:00.000000Z"
        },
        {
            "Name": "Mantas",
            "Surname": "Katleris",
            "Personal_code": 39805107896,
            "email": "mankat@gmail.com",
            "Grade": "0",
            "password": "$2y$10$fbIuDgHiOgHxxjbzxcx0AOhS8B0Z0vyMlgbUI1NTHh1qp79ltrCXW",
            "Confirmation": "Confirmed",
            "id_User": 3,
            "Role": "School Administrator",
            "created_at": "2022-11-20T17:17:03.000000Z",
            "updated_at": "2022-11-20T19:21:10.000000Z"
        },
        ...
    ]

## GET api/user/:id
#### Gauna pasirinkto vartotojo informaciją
#### Resource URL
##### `18.159.77.71/api/user/:id`
#### Resource information
| Response formats             |        JSON        |
| ---------------------------- | ------------------ |
| Requires authentication      |         Yes        |
| Possible error codes         | 200, 401, 404      |

#### Parameters
|   Name                    | Required |       Description            |   Default value   |   Example                    |
| ------------------------- | -------- | ---------------------------- | ----------------- | ---------------------------- |
| Id                        | Yes      | Users id                     |                   | 3                            |
   
#### Example request
`GET 18.159.77.71/api/user/3 authorization: Bearer Token`
#### Example Response
    {
        "Name": "Mantas",
        "Surname": "Katleris",
        "Personal_code": 39805107896,
        "email": "mankat@gmail.com",
        "Grade": "0",
        "password": "$2y$10$fbIuDgHiOgHxxjbzxcx0AOhS8B0Z0vyMlgbUI1NTHh1qp79ltrCXW",
        "Confirmation": "Confirmed",
        "id_User": 3,
        "Role": "School Administrator",
        "created_at": "2022-11-20T17:17:03.000000Z",
        "updated_at": "2022-11-20T19:21:10.000000Z"
    }

## PUT api/users/:id
#### Atnaujina pasirinkto vartotojo informaciją
#### Resource URL
##### `18.159.77.71/api/users/:id`
#### Resource information
| Response formats             |        JSON        |
| ---------------------------- | ------------------ |
| Requires authentication      |         Yes        |
| Possible error codes         | 200, 401, 404      |

#### Parameters
|   Name                    | Required |       Description            |   Default value   |   Example                    |
| ------------------------- | -------- | ---------------------------- | ----------------- | ---------------------------- |
| Id                        | Yes      | Users id                     |                   | 3                            |
   
#### Example request
`PUT 18.159.77.71/api/users/3 authorization: Bearer Token`
#### Example Response
    {
        "success": "User updated successfully"
    }
    
# Išvados

####    Šio modulio metu pavyko realizuoti susigalvotą ir aprašytą sistemą su pasirinktomis priemonėmis. Laravel karkasas yra pakankamai patogus panašių API rašymui, nes sutaupo daug laiko dėl savo paprastos struktūros ir paprasto kodo. Tačiau hostinant sukurtą API kilo nemažai problemų dėl naujausios Laravel versijos pokyčių ir teko kreiptis pagalbos, todėl galima teigti, kad šis įrankis reikalauja didesnių žinių tam, kad pahostinti sukurtą programą. 
####    Frontendui buvo naudojamas React.js karkasas, kuris yra pakankamai sunkus besimokymui, tačiau puikiai tinka tokių sistemų kūrimui.
####    Modulio užduotis buvo sėkmingai įvykdyta, nors ir ne be sunkumų bei buvo išmokta daug naujų dalykų, tokių kaip REST API principai, API hostinimas bei pagilintos žinios apie autentifikacijos metodus.
