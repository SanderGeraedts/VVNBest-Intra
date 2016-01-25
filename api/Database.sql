SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE if exists VVN_EVENT;
DROP TABLE if exists FILE;
DROP TABLE if exists MEETING;
DROP TABLE if exists MEETINGITEM;
DROP TABLE if exists MESSAGE;
DROP TABLE if exists MESSAGE_USER;
DROP TABLE if exists TASK;
DROP TABLE if exists VVN_USER;
DROP TABLE if exists USER_EVENT;
SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE VVN_USER(
	Id				INT(10)				PRIMARY KEY auto_increment,
	Name			VARCHAR(255)		NOT NULL,
	Username		VARCHAR(255)		NOT NULL UNIQUE,
	Password		VARCHAR(255)		NOT NULL,
	Email			VARCHAR(255)		NOT NULL,

	CONSTRAINT 		CK_PasswordLength	CHECK (LENGTH(Password) > 7),
	CONSTRAINT		CK_PasswordUpper	CHECK (UPPER(Password) != Password),
	CONSTRAINT		CK_PasswordLower	CHECK (LOWER(Password) != Password)
);

CREATE TABLE VVN_EVENT(
	Id				INT(10)				PRIMARY KEY auto_increment,
	Name			VARCHAR(255)		NOT NULL,
	DateEvent		DATE 				NULL,
	Location		VARCHAR(255)		NULL,
	Description		LONGTEXT			NULL
);

CREATE TABLE TASK(
	Id				INT(10)				PRIMARY KEY auto_increment,
	UserId			INT(10)				NULL,
	Name			VARCHAR(255)		NOT NULL,
	Description 	LONGTEXT 			NULL,
	Deadline 		DATE 				NULL,
	Completed		TINYINT(1)			NOT NULL DEFAULT 0,

	CONSTRAINT 		FK_UserId1			FOREIGN KEY (UserId) REFERENCES VVN_USER(Id)
);

CREATE TABLE MEETING(
	EventId			INT(10)				PRIMARY KEY,
	PreviousMeeting	INT(10)				NULL,

	CONSTRAINT 		FK_EventId1			FOREIGN KEY (EventId) REFERENCES VVN_EVENT(Id),
	CONSTRAINT 		FK_MeetingId1		FOREIGN KEY (PreviousMeeting) REFERENCES MEETING(EventId)
);

CREATE TABLE MEETINGITEM(
	Id 				INT(10)				PRIMARY KEY auto_increment,
	MeetingId 		INT(10)				NOT NULL,
	ItemOrder		INT(3)				NOT NULL,
	Title			VARCHAR(255)		NOT NULL,
	Description 	LONGTEXT 			NULL,

	CONSTRAINT 		FK_MeetingId2 		FOREIGN KEY (MeetingId) REFERENCES MEETING(EventId)
);

CREATE TABLE FILE(
	Id 				INT(10) 			PRIMARY KEY auto_increment,
	UserId 			INT(10)				NOT NULL,
	EventId 		INT(10)				NULL,
	Name			VARCHAR(255)		NOT NULL,
	FilePath		VARCHAR(255)		NOT NULL,
	DateUpload		DATE				NOT NULL,

	CONSTRAINT 		UQ_FileName			UNIQUE(Name, FilePath),
	CONSTRAINT 		FK_UserId2 			FOREIGN KEY (UserId) REFERENCES VVN_USER(Id),
	CONSTRAINT 		FK_EventId2 		FOREIGN KEY (EventId) REFERENCES VVN_EVENT(Id)
);

CREATE TABLE MESSAGE(
	Id 				INT(10)				PRIMARY KEY auto_increment,
	UserId 			INT(10)				NOT NULL,
	DateSent		DATE 				NOT NULL,
	Title 			VARCHAR(255)		NULL,
	MessageText 	LONGTEXT 			NULL,

	CONSTRAINT 		FK_UserId3			FOREIGN KEY (UserId) REFERENCES VVN_USER(Id)
);

CREATE TABLE MESSAGE_USER(
	MessageId 		INT(10) 			NOT NULL,
	UserId 			INT(10)				NOT NULL,

	PRIMARY KEY 	(MessageId, UserId),
	CONSTRAINT 		FK_MessageId1 		FOREIGN KEY (MessageId) REFERENCES MESSAGE(Id),
	CONSTRAINT 		FK_UserId4 			FOREIGN KEY (UserId) REFERENCES VVN_USER(Id)
);

CREATE TABLE USER_EVENT(
	EventId 		INT(10)				NOT NULL,
	UserId 			INT(10)				NOT NULL,

	PRIMARY KEY 	(EventId, UserId),
	CONSTRAINT 		FK_EventId3 		FOREIGN KEY (EventId) REFERENCES VVN_EVENT(Id),
	CONSTRAINT 		FK_UserId5 			FOREIGN KEY (UserId) REFERENCES VVN_USER(Id)
);

INSERT INTO VVN_USER(Name, Username, Password, Email) VALUES ('Sander Geraedts', 'admin', 'VVN-Intra', 'info@codepanda.nl');
INSERT INTO VVN_USER(Name, Username, Password, Email) VALUES ('Jan Geraedts', 'j.geraedts', 'VVN-Intra', 'jcjg.geraedts@kpnmail.nl');
INSERT INTO VVN_USER(Name, Username, Password, Email) VALUES ('Rik Willems', 'r.willems', 'VVN-Intra', 'voorzitter@vvnbest.nl');
INSERT INTO VVN_USER(Name, Username, Password, Email) VALUES ('Anton Kon', 'a.kon', 'VVN-Intra', 'penningmeester@vvnbest.nl');
INSERT INTO VVN_USER(Name, Username, Password, Email) VALUES ('René van Boxtel', 'r.boxtel', 'VVN-Intra', 'renevboxtel@onsmail.nl');
INSERT INTO VVN_USER(Name, Username, Password, Email) VALUES ('Paul Gondrie', 'p.gondrie', 'VVN-Intra', 'p.gondrie@wxs.nl');
INSERT INTO VVN_USER(Name, Username, Password, Email) VALUES ('Marriëtte Schepers', 'm.schepers', 'VVN-Intra', 'verkeersouder@vvnbest.nl');
INSERT INTO VVN_USER(Name, Username, Password, Email) VALUES ('Gast', 'g.ast', 'Gast1234', 'nope@vvnbest.nl');

UPDATE VVN_USER SET Username = UPPER(Username);

INSERT INTO VVN_EVENT(Name, DateEvent, Location, Description) VALUES ('Vergadering', '2016-02-02', 'De Kadans, Best', 'Eerste vergadering van VVN Best in 2016');

INSERT INTO MEETING(EventId) VALUES (1);

INSERT INTO MEETINGITEM(MeetingId, ItemOrder, Title, Description) VALUES (1, 1, 'Opening door de voorzitter', 'Opening door de voorzitter');
INSERT INTO MEETINGITEM(MeetingId, ItemOrder, Title, Description) VALUES (1, 2, 'Vastellen notulen van de vergadering', 'Vastellen notulen van de vergadering');
INSERT INTO MEETINGITEM(MeetingId, ItemOrder, Title, Description) VALUES (1, 3, 'Ingekomen stukken / mededelingen', 'Ingekomen stukken / mededelingen');
INSERT INTO MEETINGITEM(MeetingId, ItemOrder, Title, Description) VALUES (1, 4, 'Evaluatie Fietsverlichtingsactie Heerbeeck College. 26 november j.l', 'Evaluatie Fietsverlichtingsactie Heerbeeck College. 26 november j.l');
INSERT INTO MEETINGITEM(MeetingId, ItemOrder, Title, Description) VALUES (1, 5, 'Project Verkeer en Vervoer', 'Project Verkeer en Vervoer');
INSERT INTO MEETINGITEM(MeetingId, ItemOrder, Title, Description) VALUES (1, 6, 'Subsidie gemeente Best', 'Subsidie gemeente Best');
INSERT INTO MEETINGITEM(MeetingId, ItemOrder, Title, Description) VALUES (1, 7, 'Jaarverslag/financiën', 'Jaarverslag/financiën');
INSERT INTO MEETINGITEM(MeetingId, ItemOrder, Title, Description) VALUES (1, 8, 'Activiteitenkalender 2016 datavergaderingen en acties bepalen', 'Activiteitenkalender 2016 datavergaderingen en acties bepalen');
INSERT INTO MEETINGITEM(MeetingId, ItemOrder, Title, Description) VALUES (1, 9, 'Actielijst doorlopen', 'Actielijst doorlopen');
INSERT INTO MEETINGITEM(MeetingId, ItemOrder, Title, Description) VALUES (1, 10, 'Moeten er nog materialen besteld worden?', 'Moeten er nog materialen besteld worden?');
INSERT INTO MEETINGITEM(MeetingId, ItemOrder, Title, Description) VALUES (1, 11, 'Rondvraag afsluiting.', 'Rondvraag afsluiting.');

INSERT INTO TASK(UserId, Name, Description, Deadline) VALUES (1, 'VVN Intranet', 'Je bent als side project een intranet systeem voor VVNBest aan het maken. De dingen die nog moeten gebruiken zijn: alles...', null);
INSERT INTO TASK(UserId, Name, Description, Deadline) VALUES (null, 'Test 1', 'Test 1: zonder deadline', null);
INSERT INTO TASK(UserId, Name, Description, Deadline) VALUES (null, 'Test 2', 'Test 2: nu met deadline', '2016-02-25');

INSERT INTO FILE(UserId, EventId, Name, FilePath, DateUpload) VALUES (1, null, 'Test.txt', '/files/s.geraedts/', '2016-01-25');
INSERT INTO FILE(UserId, EventId, Name, FilePath, DateUpload) VALUES (2, null, 'Test.txt', '/files/j.geraedts/', '2016-01-25');
INSERT INTO FILE(UserId, EventId, Name, FilePath, DateUpload) VALUES (1, null, 'Test.txt', '/files/shared/', '2016-01-25');
INSERT INTO FILE(UserId, EventId, Name, FilePath, DateUpload) VALUES (1, 1, 'Meeting.txt', '/files/events/meetings/2016-02-02/Meeting.txt', '2016-01-25');

INSERT INTO MESSAGE(UserId, DateSent, Title, MessageText) VALUES (1, '2016-01-25', 'Servers down', 'We zijn nog niet Live dus hoe had je verwacht dat de servers up zouden zijn? Twat...');
INSERT INTO MESSAGE(UserId, DateSent, Title, MessageText) VALUES (1, '2016-01-25', 'Servers up', 'Haha just kidding! Twat...');

INSERT INTO MESSAGE_USER(MessageId, UserId) VALUES (1, 1);
INSERT INTO MESSAGE_USER(MessageId, UserId) VALUES (1, 2);
INSERT INTO MESSAGE_USER(MessageId, UserId) VALUES (1, 3);
INSERT INTO MESSAGE_USER(MessageId, UserId) VALUES (1, 4);
INSERT INTO MESSAGE_USER(MessageId, UserId) VALUES (1, 5);
INSERT INTO MESSAGE_USER(MessageId, UserId) VALUES (1, 6);
INSERT INTO MESSAGE_USER(MessageId, UserId) VALUES (1, 7);
INSERT INTO MESSAGE_USER(MessageId, UserId) VALUES (1, 8);
INSERT INTO MESSAGE_USER(MessageId, UserId) VALUES (2, 1);

INSERT INTO USER_EVENT(EventId, UserId) VALUES (1, 1);
INSERT INTO USER_EVENT(EventId, UserId) VALUES (1, 2);
INSERT INTO USER_EVENT(EventId, UserId) VALUES (1, 3);
INSERT INTO USER_EVENT(EventId, UserId) VALUES (1, 4);
INSERT INTO USER_EVENT(EventId, UserId) VALUES (1, 5);
INSERT INTO USER_EVENT(EventId, UserId) VALUES (1, 6);
INSERT INTO USER_EVENT(EventId, UserId) VALUES (1, 7);
INSERT INTO USER_EVENT(EventId, UserId) VALUES (1, 8);