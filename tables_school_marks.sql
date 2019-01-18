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
CREATE TABLE Marks(
    user varchar(25),
    subjectid char(3),
    taskname nvarchar(25);
    description varchar(100),
    marks decimal(2,2),
    evaluation varchar(20),
    constraint PK_Evaluation PRIMARY KEY (user,subjectid,taskname)
)
--Foreign key marks: subjectid
ALTER TABLE marks
ADD FOREIGN KEY (subjectid) REFERENCES subjects(id)

--Foreign key marks: user
ALTER TABLE marks
ADD FOREIGN KEY (user) REFERENCES users(user)

--Foreign key marks: user
ALTER TABLE marks
ADD FOREIGN KEY (taskname) REFERENCES tasktypes(name)

--Table subjects
CREATE TABLE Subjects(
    id char(3) PRIMARY KEY NOT NULL,
    name VARCHAR(25),
    teacher varchar(25)
)

--Foreing key subjects: 
ALTER TABLE Subjects
ADD FOREIGN KEY (teacher) REFERENCES users(user)

--Table task types
CREATE TABLE TaskTypes(
  id int PRIMARY KEY NOT NULL,
  percentage decimal(2,2),
  name varchar(25)
)
