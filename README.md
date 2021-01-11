# Car inventory

This simple CRUD application written in PHP has a login functionality (password: **php123**) and allows connecting to a MySQL-database. You can setup the database by using the following SQL command: 

```
CREATE TABLE autos (
  autos_id INTEGER NOT NULL KEY AUTO_INCREMENT,
  make VARCHAR(255),
  model VARCHAR(255),
  year INTEGER,
  mileage INTEGER
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
```
