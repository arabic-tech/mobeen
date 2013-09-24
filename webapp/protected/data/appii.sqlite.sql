PRAGMA foreign_keys=OFF;
BEGIN TRANSACTION;
CREATE TABLE tbl_user (
Id INTEGER PRIMARY KEY AUTOINCREMENT,
pretty_name varchar(255) NOT NULL,
email varchar(255) NOT NULL,
created_at date,
last_login date,
updated_at date,
validation_key varchar(255),
subscripe boolean,
facebook_id varchar(255),
google_id varchar(255),
twitter varchar(255) ,
password varchar(256),
score integer

);
INSERT INTO "tbl_user" VALUES(22,'admin','admin@example.com',1370959970,1370961989,NULL,NULL,NULL,NULL,NULL,NULL,'$2a$10$TzzCNxAbaAe3R98L5Ri0pOYbUWZfmAZ8YuR9nzHE2gkVMmYQ86n8.');
CREATE TABLE tbl_post
(
        id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
        title VARCHAR(128) NOT NULL,
        content TEXT NOT NULL,
        tags TEXT,
        status INTEGER NOT NULL,
        create_time INTEGER,
        update_time INTEGER,
        user_id INTEGER NOT NULL,
        CONSTRAINT FK_post_author FOREIGN KEY (user_id)
                REFERENCES tbl_user (id) ON DELETE CASCADE ON UPDATE RESTRICT
);
CREATE TABLE tbl_tag
(
        id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
        name VARCHAR(128) NOT NULL,
        frequency INTEGER DEFAULT 1
);
CREATE TABLE tbl_lookup
(
        id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
        name VARCHAR(128) NOT NULL,
        code INTEGER NOT NULL,
        type VARCHAR(128) NOT NULL,
        position INTEGER NOT NULL
);
INSERT INTO "tbl_lookup" VALUES(1,'مسودة',1,'PostStatus',1);
INSERT INTO "tbl_lookup" VALUES(2,'منشورة',2,'PostStatus',2);
INSERT INTO "tbl_lookup" VALUES(3,'الأرشيف',3,'PostStatus',3);
INSERT INTO "tbl_lookup" VALUES(4,'Pending Approval',1,'CommentStatus',1);
INSERT INTO "tbl_lookup" VALUES(5,'Approved',2,'CommentStatus',2);
INSERT INTO "tbl_lookup" VALUES(6,'مسودة',1,'PostStatus',1);
INSERT INTO "tbl_lookup" VALUES(7,'منشورة',2,'PostStatus',2);
INSERT INTO "tbl_lookup" VALUES(8,'الأرشيف',3,'PostStatus',3);
INSERT INTO "tbl_lookup" VALUES(9,'Pending Approval',1,'CommentStatus',1);
INSERT INTO "tbl_lookup" VALUES(10,'Approved',2,'CommentStatus',2);
INSERT INTO "tbl_lookup" VALUES(11,'Suggestion',2,'CommentType',2);
INSERT INTO "tbl_lookup" VALUES(12,'Example',1,'CommentType',1);
CREATE TABLE tbl_post_like
(
        id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
        like boolean ,
        dislike boolean ,
        create_time INTEGER,
        user_id INTEGER NOT NULL,
        post_id INTEGER NOT NULL,

        CONSTRAINT FK_comment_post FOREIGN KEY (post_id)
                REFERENCES tbl_post (id) ON DELETE CASCADE ON UPDATE RESTRICT

        CONSTRAINT FK_comment_post FOREIGN KEY (user_id)
                REFERENCES tbl_user (id) ON DELETE CASCADE ON UPDATE RESTRICT

);
CREATE TABLE tbl_comment   (
        id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
        content TEXT NOT NULL,
        status INTEGER NOT NULL,
        create_time INTEGER,
        author VARCHAR(128) NOT NULL,
post_id INTEGER NOT NULL,
type varchar(256), coloumn email varchar(2), email varchar(2), url varchar(2),
        CONSTRAINT FK_comment_post FOREIGN KEY (post_id)
                REFERENCES tbl_post (id) ON DELETE CASCADE ON UPDATE RESTRICT
);
DELETE FROM sqlite_sequence;
INSERT INTO "sqlite_sequence" VALUES('tbl_user',2);
INSERT INTO "sqlite_sequence" VALUES('tbl_lookup',13);
INSERT INTO "sqlite_sequence" VALUES('tbl_post',1);
INSERT INTO "sqlite_sequence" VALUES('tbl_tag',1);
INSERT INTO "sqlite_sequence" VALUES('tbl_post_like',1);
INSERT INTO "sqlite_sequence" VALUES('tbl_comment',1);
COMMIT;

