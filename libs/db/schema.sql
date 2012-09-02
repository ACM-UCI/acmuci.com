-- Projects and Members
-- Events and Locations

CREATE TABLE IF NOT EXISTS projects (
	project_id INTEGER NOT NULL,
	project_status INTEGER NOT NULL DEFAULT '0',
	project_name VARCHAR(100) NOT NULL,
	project_desc TEXT NOT NULL,
	project_contact_id INTEGER NOT NULL,
	PRIMARY KEY (project_id),
	FOREIGN KEY (project_contact_id) REFERENCES members (member_id)
);

CREATE TABLE IF NOT EXISTS members (
	member_id INTEGER NOT NULL,
	member_fb_id INTEGER NOT NULL,
	member_name VARCHAR(100) NOT NULL,
	member_role INTEGER NOT NULL DEFAULT '0',
	member_link VARCHAR(100), -- optional contact information
	member_email VARCHAR(100), -- optional contact information
	PRIMARY KEY (member_id)
);

CREATE TABLE IF NOT EXISTS projects_members (
	project_id INTEGER NOT NULL,
	member_id INTEGER NOT NULL,
	PRIMARY KEY (project_id, member_id)
);

CREATE TABLE IF NOT EXISTS events (
	event_id INTEGER NOT NULL,
	event_name VARCHAR(100) NOT NULL,
	event_desc TEXT NOT NULL,
	event_room_id INTEGER NOT NULL,
	event_bldg_id INTEGER NOT NULL,
	PRIMARY KEY (event_id),
	FOREIGN KEY (event_room_id, event_bldg_id) REFERENCES locations (room_id,
	bldg_id)
);

CReATE TABLE IF NOT EXISTS locations (
	room_id INTEGER NOT NULL,
	bldg_id INTEGER NOT NULL,
	location_full_name VARCHAR(100) NOT NULL,
	location_short_name VARCHAR(45) NOT NULL,
	PRIMARY KEY (room_id, bldg_id)
);
