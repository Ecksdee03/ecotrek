DROP DATABASE IF EXISTS ecotrek;

CREATE DATABASE ecotrek;

USE ecotrek;
CREATE TABLE users (
  profileID INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  password VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  points INT NOT NULL DEFAULT 0,
  address VARCHAR(255) NOT NULL DEFAULT 'Not provided',
  biography VARCHAR(1200) NOT NULL DEFAULT 'Not provided',
  profileURL VARCHAR(255) NOT NULL DEFAULT 'https://example.com/default.jpg',
  CONSTRAINT users_pk PRIMARY KEY(profileID)
);

CREATE TABLE products (
  productID INT NOT NULL AUTO_INCREMENT,
  productName VARCHAR(255) NOT NULL,
  totalQuantity INT NOT NULL DEFAULT 0,
  points INT NOT NULL DEFAULT 0,
  desiredQuantity INT NOT NULL DEFAULT 0,
  productURL VARCHAR(255),
  CONSTRAINT products_pk PRIMARY KEY(productID)
);

CREATE TABLE rewards_history (
  profileID INT NOT NULL,
  productID INT NOT NULL,
  quantity INT NOT NULL,
  CONSTRAINT rewards_history_pk PRIMARY KEY(profileID, productID),
  CONSTRAINT rewards_history_fk1 FOREIGN KEY(profileID) REFERENCES users(profileID),
  CONSTRAINT rewards_history_fk2 FOREIGN KEY(productID) REFERENCES products(productID)
);

CREATE TABLE friends (
  friend1ID INT NOT NULL,
  friend2ID INT NOT NULL,
  CONSTRAINT friends_pk PRIMARY KEY (friend1ID, friend2ID),
  CONSTRAINT friends_fk1 FOREIGN KEY (friend1ID) REFERENCES users(profileID),
  CONSTRAINT friends_fk2 FOREIGN KEY (friend2ID) REFERENCES users(profileID)
);

CREATE TABLE user_travel (
  profileID INT NOT NULL,
  datetime_stamp TIMESTAMP NOT NULL,
  start_location VARCHAR(255) NOT NULL,
  end_location VARCHAR(255) NOT NULL,
  carbon_emission DECIMAL(64, 4) NOT NULL,
  CONSTRAINT user_travel_pk PRIMARY KEY(profileID, datetime_stamp, start_location, end_location),
  CONSTRAINT user_travel_fk1 FOREIGN KEY(profileID) REFERENCES users(profileID)
);


INSERT INTO users (name, email, password, biography, profileURL,points) VALUES
('Alice', 'alice@example.com', 'password', 'I am Alice, a software engineer who is passionate about sustainability.', 'https://example.com/alice.jpg',10000),
('Bob', 'bob@example.com', 'password', 'I am Bob, a student who is interested in learning more about environmental issues.', 'https://example.com/bob.jpg',7600),
('Carol', 'carol@example.com', 'password', "I am Carol, a stay-at-home mom who is looking for ways to reduce her family's carbon footprint.", 'images/images.jpg',4500),
('Damien','dam@example.com','password','I am Damien, a student who is interested in learning more about environmental issues.','https://example.com/damien.jpg',9380),
('Eve','eve@example.com','password','I am eve','https://example.com/eve.jpg',4500),
('Frank','frank@example.com','password','I am frank','https://example.com/frank.jpg',8900),
('Gina','gina@example.com','password','I am gina','https://example.com/gina.jpg',3790),
('Harry','harry@example.com','password','I am harry','https://example.com/harry.jpg',1430),
('Ivy','ivy@example.com','password','I am ivy','https://example.com/ivy.jpg',1000),
('John','john@example.com','password','I am john','https://example.com/john.jpg',1540),
('Kate','kate@example.com','password','I am kate','https://example.com/kate.jpg',8900),
('Liam','liam@example.com','password','I am liam','https://example.com/liam.jpg',7480),
('Mary','mary@example.com','password','I am mary','https://example.com/mary.jpg',6500),
('Nathan','nate@example.com','password','I am nate','https://example.com/nate.jpg',5600),
('Olivia','olivia@example.com','password','I am olivia','https://example.com/olivia.jpg',9000),
('Peter','pete@example.com','password','I am pete','https://example.com/pete.jpg',3200),
('Quinn','quinn@example.com','password','I am quinn','https://example.com/quinn.jpg',2600),
('Ryan','ryan@example.com','password','I am ryan','https://example.com/ryan.jpg',1000),
('Sarah','sarah@example.com','password','I am sarah','https://example.com/sarah.jpg',2400),
('Tom','tom@example.com','password','I am tom','https://example.com/tom.jpg',1000);

-- ('John Doe', 'johndoe@example.com',  'password123', 100, 'A short bio about John.', '123 Main St', 'images/profilepic1.jpeg'),
-- ('Alice Smith', 'pass456', 'alice.smith@example.com', 75, '456 Elm St', 'Alice loves coding.', 'Images/profilepic2.jpg' ),
-- ('Bob Johnson', 'bobpass', 'bob.j@example.com', 50, '789 Oak St', 'Bob enjoys traveling.', 'Images/profilepic2.jpeg' ),
-- ('Eva Williams', 'evapass', 'eva.w@example.com', 80, '101 Pine St', 'Eva is an artist.', 'Images/profilepic3.jpeg'),
-- ('David Lee', 'lee123', 'david.lee@example.com', 60, '202 Cedar St', 'David is a foodie.', 'Images/profilepic4.jpg');




INSERT INTO friends (friend1ID, friend2ID) VALUES
(1,2),
(2,1),
(2,3),
(3,2);

INSERT INTO products (productID, productName, totalQuantity, points, productURL, desiredQuantity) VALUES
('123', 'Bamboo Toothbrush 10% Voucher', 10, 25,"images/products/bamboo_toothbrush.jpg",0),
('456', 'Metal Straw 20% Voucher', 12, 50,"images/products/metal_straw.jpg",0),
('324', 'Wooden Cutlery 15% Voucher', 5, 15,"images/products/wooden_cutlery.jpg",0),
('789', 'Thermal Bottle 20% Voucher', 3, 10,"images/products/bottle.jpg",0),
('012', 'Cotton Pad 20% Voucher', 6, 5,"images/products/cotton_pad.jpg",0),
('356', 'Cotton Swab 10% Voucher', 4, 15,"images/products/cotton_swab.jpg",0),
('467', 'Hair Comb 25% Voucher', 3, 10,"images/products/hair_comb.jpg",0),
('712', 'Natural Candles 20% Voucher', 5, 20,"images/products/natural_candles.jpg",0),
('412', 'Sunscreen 20% Voucher', 10, 5,"images/products/sunscreen.jpg",0);






INSERT INTO users (name, password, email, points, address, biography, profileURL)
VALUES ('John Doe', 'password123', 'johndoe@example.com', 2100, '123 Main St', 'A short bio about John.', 'images/profilepic1.jpeg');


INSERT INTO users (name, password, email, points, address, biography, profileURL)
VALUES ('Alice Smith', 'pass456', 'alice.smith@example.com', 7500, '456 Elm St', 'Alice loves coding.', 'Images/profilepic2.jpg' );


INSERT INTO users (name, password, email, points, address, biography, profileURL)
VALUES ('Bob Johnson', 'bobpass', 'bob.j@example.com', 5000, '789 Oak St', 'Bob enjoys traveling.', 'Images/profilepic2.jpeg' );


INSERT INTO users (name, password, email, points, address, biography, profileURL)
VALUES ('Eva Williams', 'evapass', 'eva.w@example.com', 8000, '101 Pine St', 'Eva is an artist.', 'Images/profilepic3.jpg');


INSERT INTO users (name, password, email, points, address, biography, profileURL)
VALUES ('David Lee', 'lee123', 'david.lee@example.com', 6000, '202 Cedar St', 'David is a foodie.', 'Images/profilepic4.jpg');

select * from users;

insert into friends (friend1ID, friend2ID)
VALUES ('21', '22');
insert into friends (friend1ID, friend2ID)
VALUES ('21', '23');
insert into friends (friend1ID, friend2ID)
VALUES ('21', '24');
insert into friends (friend1ID, friend2ID)
VALUES ('21', '25');
insert into friends (friend1ID, friend2ID)
VALUES ('21', '3');




INSERT INTO user_travel (profileID, datetime_stamp, start_location, end_location, carbon_emission)
VALUES (21, '2023-01-01', 'Chinatown', 'Sentosa', 3000);

-- February
INSERT INTO user_travel (profileID, datetime_stamp, start_location, end_location, carbon_emission)
VALUES (21, '2023-02-01', 'Marina Bay Sands', 'Orchard Road', 5500);

-- March
INSERT INTO user_travel (profileID, datetime_stamp, start_location, end_location, carbon_emission)
VALUES (21, '2023-03-01', 'Gardens by the Bay', 'Universal Studios', 6100);

-- April
INSERT INTO user_travel (profileID, datetime_stamp, start_location, end_location, carbon_emission)
VALUES (21, '2023-04-01', 'Little India', 'Singapore Zoo', 5000);

-- May
INSERT INTO user_travel (profileID, datetime_stamp, start_location, end_location, carbon_emission)
VALUES (21, '2023-05-01', 'East Coast Park', 'Jurong Bird Park', 3050);

-- June
INSERT INTO user_travel (profileID, datetime_stamp, start_location, end_location, carbon_emission)
VALUES (21, '2023-06-01', 'Suntec City', 'Haw Par Villa', 2280);

-- July
INSERT INTO user_travel (profileID, datetime_stamp, start_location, end_location, carbon_emission)
VALUES (21, '2023-07-01', 'Singapore River', 'Bukit Timah Nature Reserve', 1270);

-- August
INSERT INTO user_travel (profileID, datetime_stamp, start_location, end_location, carbon_emission)
VALUES (21, '2023-08-01', 'Changi Airport', 'Pulau Ubin', 802);

-- September
INSERT INTO user_travel (profileID, datetime_stamp, start_location, end_location, carbon_emission)
VALUES (21, '2023-09-01', 'Marina Barrage', 'Chinatown', 1000);

INSERT INTO user_travel (profileID, datetime_stamp, start_location, end_location, carbon_emission)
VALUES (21, '2023-09-01', 'Junction8', 'Chinatown', 900);

-- October
INSERT INTO user_travel (profileID, datetime_stamp, start_location, end_location, carbon_emission)
VALUES (21, '2023-10-01', 'Sengkang Riverside Park', 'MacRitchie Reservoir', 4150);

-- November
INSERT INTO user_travel (profileID, datetime_stamp, start_location, end_location, carbon_emission)
VALUES (21, '2023-11-01', 'Punggol Waterway Park', 'East Coast Park', 1203);

-- December
INSERT INTO user_travel (profileID, datetime_stamp, start_location, end_location, carbon_emission)
VALUES (21, '2023-12-01', 'Esplanade', 'Botanic Gardens', 2230);