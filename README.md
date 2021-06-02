# Car inventory
## Introduction

This simple CRUD application written in PHP has a login functionality (password: **php123**) and allows connecting to a MySQL-database. You can setup the database by using the following SQL command: 

```
CREATE TABLE autos(
    auto_id INTEGER NOT NULL KEY AUTO_INCREMENT,
    make VARCHAR(255),
    model VARCHAR(255),
    YEAR INTEGER,
    mileage INTEGER
) ENGINE = InnoDB DEFAULT CHARSET = utf8;
```

This application is the capstone project of the course *Building Database applications in PHP* which I took on Coursera (see my certificate [here](https://coursera.org/share/1ac7cb1ed1ca48a36f983bcf6867b22b)).

## Live Version
To see a live version follow this [link](https://cuspidal-perforatio.000webhostapp.com/).
