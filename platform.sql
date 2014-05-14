-- PCL metrics engine database structure
-- Compatible with mysql 5.0+
-- AfterLifeLochie, 2014

DROP TABLE IF EXISTS SESSIONS;
DROP TABLE IF EXISTS USERS;
DROP TABLE IF EXISTS PRODUCTVIEWS;
DROP TABLE IF EXISTS VIEWS;
DROP TABLE IF EXISTS COMPONENTS;
DROP TABLE IF EXISTS PRODUCTS;

-- CREATE USERS
CREATE TABLE USERS (
	USER_ID				INTEGER			NOT NULL 	AUTO_INCREMENT,
	USER_NAME			VARCHAR(255)	NOT NULL,
	USER_HASH			VARCHAR(255)	NOT NULL,
	USER_RIGHTS			INTEGER			NOT NULL,
	PRIMARY KEY(USER_ID)
);

-- CREATE SESSIONS
CREATE TABLE SESSIONS (
	SESSION_TAG			VARCHAR(255)	NOT NULL,
	SESSION_USERID		INTEGER			NOT NULL,
	SESSION_IPADDR_H	BIGINT			NOT NULL,   -- HIWORD(V6) / VOID
	SESSION_IPADDR_L	BIGINT			NOT NULL,	-- LOWORD(V6) / V4
	SESSION_AGENT		VARCHAR(512)	NOT NULL,
	SESSION_EXPIRY		INTEGER			NOT NULL,
	PRIMARY KEY (SESSION_TAG), 
	FOREIGN KEY (SESSION_USERID) REFERENCES USERS(USER_ID)
);

-- CREATE COMPONENTS
CREATE TABLE COMPONENTS (
	COMPONENT_ID		INTEGER			NOT NULL 	AUTO_INCREMENT,
	COMPONENT_NAME		VARCHAR(255)	NOT NULL,
	COMPONENT_CLASS		VARCHAR(255)	NOT NULL,
	COMPONENT_ARGS		TEXT			NOT NULL
	PRIMARY KEY (COMPONENT_ID);
);

-- CREATE VIEWS
CREATE TABLE VIEWS (
	VIEW_ID					INTEGER			NOT NULL	AUTO_INCREMENT,
	VIEW_NAME				VARCHAR(255)	NOT NULL,
	VIEW_ON_NAVIGATION		INTEGER(1)		NOT NULL,
	VIEW_RIGHTS_REQUIRED	INTEGER			NOT NULL,
	PRIMARY KEY (VIEW_ID);
);

-- CREATE PRODUCTS
CREATE TABLE PRODUCTS (
	PRODUCT_ID				INTEGER			NOT NULL AUTO_INCREMENT,
	PRODUCT_NAME			VARCHAR(255)	NOT NULL,
	PRODUCT_HOME			VARCHAR(255)	NOT NULL,
	PRODUCT_DEFAULT_VIEW	INTEGER			NOT NULL,
	PRIMARY KEY (PRODUCT_ID),
	FOREIGN KEY (PRODUCT_DEFAULT_VIEW) REFERENCES VIEWS(VIEW_ID)
);

-- CREATE PRODUCT VIEWS
CREATE TABLE PRODUCTVIEWS (
	PRODUCT_ID	INTEGER 			NOT NULL,
	VIEW_ID		INTEGER		NOT NULL,
	PRIMARY KEY (PRODUCT_ID, VIEW_ID),
	FOREIGN KEY (PRODUCT_ID) REFERENCES PRODUCTS(PRODUCT_ID),
	FOREIGN KEY (VIEW_ID) REFERENCES VIEWS(VIEW_ID)
);

