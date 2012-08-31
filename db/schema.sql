CREATE TABLE IF NOT EXISTS projects (
	project_id INTEGER NOT NULL,
	project_status INTEGER NOT NULL DEFAULT '0',
	project_name VARCHAR(100) NOT NULL,
	project_contact_name VARCHAR(100) NOT NULL,
	project_contact_email VARCHAR(100),
	project_desc TEXT NOT NULL,
	PRIMARY KEY (project_id)
);

CREATE TABLE IF NOT EXISTS members (
	member_id INTEGER NOT NULL,
	member_full_name VARCHAR(100) NOT NULL,
	PRIMARY KEY (member_id)
);

CREATE TABLE IF NOT EXISTS projects_members (
	project_id INTEGER NOT NULL,
	member_id INTEGER NOT NULL,
	PRIMARY KEY (project_id, member_id)
);
