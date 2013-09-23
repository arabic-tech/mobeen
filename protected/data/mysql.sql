CREATE TABLE tbl_badge (
id INTEGER PRIMARY KEY AUTO_INCREMENT,
type varchar(256),
name varchar(256),
score integer
);





CREATE TABLE tbl_user (
id INTEGER PRIMARY KEY AUTO_INCREMENT,
pretty_name varchar(255) NOT NULL,
email varchar(255) NOT NULL,
created_at date,
last_login date,
updated_at date,
validation_key varchar(255),
subscripe boolean,
facebook_id varchar(255),
google_id varchar(255),
twitter varchar(255) , password varchar(256), score int, sbscripe boolean, picture varchar(255));



CREATE TABLE tbl_post
(
        id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
        title VARCHAR(128) NOT NULL,
        content TEXT NOT NULL,
        tags TEXT,
        status INTEGER NOT NULL,
        create_time INTEGER,
        update_time INTEGER,
        user_id INTEGER NOT NULL, type INTEGER, 
        CONSTRAINT FK_post_author FOREIGN KEY (user_id)
                REFERENCES tbl_user (id) ON DELETE CASCADE ON UPDATE RESTRICT
);





CREATE TABLE tbl_post_like
(
	id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,

        create_time INTEGER,
        user_id INTEGER NOT NULL,
        post_id INTEGER NOT NULL,
        likepost    int(1) ,
        CONSTRAINT FK_comment_post FOREIGN KEY (user_id)              REFERENCES tbl_user (id) ON DELETE CASCADE ON UPDATE RESTRICT ,
	FOREIGN KEY (post_id ) REFERENCES tbl_post (id)  ,
unique index( post_id , user_id) 
);




CREATE TABLE tbl_comment   (
            id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
            content TEXT NOT NULL,
            status INTEGER NOT NULL,
            create_time INTEGER,
            user_id  INTEGER NOT NULL,
	    post_id INTEGER NOT NULL, 
            FOREIGN KEY  (user_id) REFERENCES tbl_user (id) 
);




CREATE TABLE tbl_lookup
(
        id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
        name VARCHAR(128) NOT NULL,
        code INTEGER NOT NULL,
        type VARCHAR(128) NOT NULL,
        position INTEGER NOT NULL
);



CREATE TABLE tbl_tag
(
        id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
        name VARCHAR(128) NOT NULL,
        frequency INTEGER DEFAULT 1
);





