USE fullstack_course;

ALTER TABLE users ADD username VARCHAR(30) NULL AFTER name;

UPDATE users
SET username = CASE
  WHEN role = 'teacher' THEN 'professor'
  ELSE LOWER(SUBSTRING_INDEX(email, '@', 1))
END;

ALTER TABLE users DROP INDEX email;
ALTER TABLE users DROP COLUMN email;
ALTER TABLE users MODIFY username VARCHAR(30) NOT NULL;
ALTER TABLE users ADD UNIQUE KEY uq_users_username (username);
