--TABLES OF DATABASE SCHOOL MARKS

--Table users
CREATE TABLE Users(
    user VARCHAR(25) Primary Key not null,
    firstname VARCHAR(25),
    lastname VARCHAR(50),
    email VARCHAR(25),
    password VARCHAR(25),
    type VARCHAR(10),
    phone int
)

--Table evaluations
CREATE TABLE Evaluation(
    id int PRIMARY KEY NOT NULL,
   	FOREIGN KEY(user) REFERENCES Users(user),
    FOREIGN KEY(subjectid) REFERENCES Subjects(id),
    FOREIGN KEY(taskid) REFERENCES TaskTypes(id),
	  description varchar(100),
    marks decimal(2,2),
    evaluation varchar(20),
    constraint PK_Evaluation PRIMARY KEY (user,subjectid)
    
)

--Table subjects
CREATE TABLE Subjects(
    id INT PRIMARY KEY NOT NULL,
    name VARCHAR(25)
)

--Table task types
CREATE TABLE TaskTypes(
  id int PRIMARY KEY NOT NULL,
  percentage decimal(2,2),
  name varchar(25)
)
