
-- Database: `projecttest`
CREATE DATABASE projecttest;


--Creating Table Complaint
CREATE TABLE complaint (complaintno serial primary key, name text NOT NULL, mobile text NOT NULL, addr text NOT NULL, dept text NOT NULL, description text NOT NULL, photos bytea NOT NULL, dateofcomp date DEFAULT NULL, dateofapp date DEFAULT NULL, status text NOT NULL, dateofclose date DEFAULT NULL);



-- Dumping data for table `complaint` (NOT REQUIRED)
INSERT INTO complaint ( name, mobile, addr, dept, description, photos, dateofcomp, dateofapp, status ) VALUES ( '$name', '$mobile', '$addr', '$dept', '$description', '$photos', CURRENT_DATE, NULL, 'unassigned')



-- Creating table adminlogin
CREATE TABLE adminlogin (email text primary key, password text);

--Dumping Data in adminlogin
INSERT INTO adminlogin('admin1@gov.in', '1111');


-- Creating table emplogin
CREATE TABLE emplogin (email text primary key, password text, dept text);

--Dumping Data in emplogin
INSERT INTO emplogin('road@gov.in', 'roads', 'road');

