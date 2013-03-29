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
	event_facebook_id INTEGER NULL,
	event_name VARCHAR(100) NOT NULL,
	event_desc TEXT NOT NULL,

	-- Boolean
	event_expired INTEGER NOT NULL DEFAULT 0,

	-- ISO 8601 Format
	event_datetime TEXT NOT NULL,

	event_room_id INTEGER NOT NULL,
	event_bldg_id INTEGER NOT NULL,

	PRIMARY KEY (event_id),
	FOREIGN KEY (event_bldg_id) REFERENCES locations (bldg_id)
);

-- Data for events that propagate to facebook
CREATE TABLE IF NOT EXISTS events_facebook (
	event_facebook_id INTEGER NOT NULL,
	event_id INTEGER NOT NULL,
	event_full_desc TEXT NOT NULL,

	PRIMARY KEY (event_facebook_id),
	FOREIGN KEY (event_id) REFERENCES events (id)
);

CREATE TABLE IF NOT EXISTS locations (
	bldg_id INTEGER NOT NULL,
	location_full_name VARCHAR(100) NOT NULL,
	location_short_name VARCHAR(45) NOT NULL,

	PRIMARY KEY (bldg_id)
);

-- CREATE TABLE IF NOT EXISTS teams {
-- 	team_id INTEGER NOT NULL,
-- 	team_name VARCHAR(45) NOT NULL,
-- 
-- 	PRIMARY KEY (team_id)
-- }
-- 
-- CREATE TABLE IF NOT EXISTS member_teams {
-- 	member_id INTEGER NOT NULL,
-- 	team_id INTEGER NOT NULL,
-- 
-- 	PRIMARY KEY (member_id, team_id),
-- 	FOREIGN KEY (member_id) REFERENCES members (member_id),
-- 	FOREIGN KEY (team_id) REFERENCES teams (team_id)
-- }
-- 
-- CREATE TABLE IF NOT EXISTS competitions {
-- 	competition_id INTEGER NOT NULL,
-- 	competition_name VARCHAR(100) NOT NULL,
-- 	competition_desc TEXT NOT NULL,
-- 
-- 	-- Boolean
-- 	competition_recurring INTEGER NOT NULL DEFAULT 0,
-- 	competition_team_based INTEGER NOT NULL DEFAULT 0,
-- }
-- 
-- CREATE TABLE IF NOT EXISTS competition_instances {
-- 	instance_id INTEGER NOT NULL,
-- 	competition_id INTEGER NOT NULL,
-- 
-- 	-- ISO 8601 Format
-- 	instance_datetime TEXT NOT NULL,
-- 
-- 	PRIMARY KEY (instance_id),
-- 	FOREIGN KEY (competition_id) REFERENCES competitions (competition_id)
-- }
-- 
-- CREATE TABLE IF NOT EXISTS competition_instance_members {
-- 	instance_id INTEGER NOT NULL,
-- 	member_id INTEGER NOT NULL,
-- 	member_rank INTEGER NOT NULL,
-- 
-- 	PRIMARY KEY (instance_id, member_id),
-- 	FOREIGN KEY (instance_id) REFERENCES locations (instance_id),
-- 	FOREIGN KEY (member_id) REFERENCES members (member_id)
-- }
-- 
-- CREATE TABLE IF NOT EXISTS competition_instance_teams {
-- 	instance_id INTEGER NOT NULL,
-- 	team_id INTEGER NOT NULL,
-- 	team_rank INTEGER NOT NULL,
-- 
-- 	PRIMARY KEY (instance_id, member_id),
-- 	FOREIGN KEY (instance_id) REFERENCES locations (instance_id),
-- 	FOREIGN KEY (team_id) REFERENCES teams (team_id)
-- }
-- 
-- CREATE TABLE IF NOT EXISTS competition_members {
-- 	competition_id INTEGER NOT NULL,
-- 	member_id INTEGER NOT NULL,
-- 	highest_rank INTEGER NOT NULL,
-- 
-- 	PRIMARY KEY (competition_id, member_id),
-- 	FOREIGN KEY (competition_id) REFERENCES competitions (competition_id),
-- 	FOREIGN KEY (member_id) REFERENCES members (member_id)
-- }
-- 
-- CREATE TABLE IF NOT EXISTS competition_teams {
-- 	competition_id INTEGER NOT NULL,
-- 	team_id INTEGER NOT NULL,
-- 	highest_rank INTEGER NOT NULL,
-- 
-- 	PRIMARY KEY (competition_id, member_id),
-- 	FOREIGN KEY (competition_id) REFERENCES competitions (competition_id),
-- 	FOREIGN KEY (team_id) REFERENCES teams (team_id)
-- }
