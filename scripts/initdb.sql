DROP DATABASE IF EXISTS  grocery_tracker;
CREATE DATABASE grocery_tracker;
USE grocery_tracker;

/*
CREATE TABLE Users(
  user_id INTEGER AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(255) UNIQUE,
  keyword  VARCHAR(255)
);
*/

CREATE TABLE Items(
  upc VARCHAR(12) PRIMARY KEY,
  name VARCHAR(255) NOT NULL
);

CREATE TABLE Lists(
  /*
  user_id INTEGER,
  */
  time TIMESTAMP DEFAULT CURRENT_TIMESTAMP UNIQUE,
  /*
  FOREIGN KEY (user_id) REFERENCES Users(user_id)
  PRIMARY KEY (user_id, time)
  */
  PRIMARY KEY (time)
);

CREATE TABLE ListItems(
  /*
  user_id INTEGER,
  */
  time TIMESTAMP,
  upc VARCHAR(12),
  /*
  FOREIGN KEY (user_id, time) REFERENCES Lists(user_id, time),
  */
  FOREIGN KEY (time) REFERENCES Lists(time),
  FOREIGN KEY (upc) REFERENCES Items(upc)
);
